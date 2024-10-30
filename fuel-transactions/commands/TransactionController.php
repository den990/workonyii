<?php

namespace app\commands;
use app\models\Data;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class TransactionController extends Controller
{
    public function actionProcessTransaction()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $refunds = Data::find()->where(['>=', 'volume', 0])->orderBy(['date' => SORT_ASC])->all();

            foreach ($refunds as $refund) {

                if ($refund->volume == 0) {
                    $refund->delete();
                    continue;
                }

                $expense = $this->getLastNegativeExpense($refund);

                if ($expense) {
                    $newVolume = $expense->volume + $refund->volume;
                    if ($newVolume > 0) {
                        while ($newVolume > 0) {
                            $newExpense = $this->getLastNegativeExpense($expense);
                            $expense->delete();
                            $newVolume += $newExpense->volume;

                            $expense = $newExpense;
                        }
                    }
                    if ($newVolume == 0) {
                        $expense->delete();
                    }
                    else {
                        $expense->volume = $newVolume;
                        $expense->save(false);
                    }
                    $refund->delete();
                }
            }

            $transaction->commit();
            echo "Транзакции успешно обработаны.\n";
            return ExitCode::OK;

        } catch (\Exception $e) {
            $transaction->rollBack();
            echo "Ошибка обработки транзакций: " . $e->getMessage() . "\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    private function getLastNegativeExpense($data)
    {
        return Data::find()
            ->where(['card_number' => $data->card_number, 'address_id' => $data->address_id])
            ->andWhere(['<', 'date', $data->date])
            ->andWhere(['<', 'volume', 0])
            ->orderBy(['date' => SORT_DESC])
            ->one();
    }
}