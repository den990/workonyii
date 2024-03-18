<?php

use app\assets\LoginAsset;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\PasswordReset $model */


LoginAsset::register($this);
$this->title = 'Изменение пароля';
$this->params['breadcrumbs'][] = $this->title;

$passwordHash = Yii::$app->request->get('password');
$user = User::findOne(['password' => $passwordHash]);

if ($user !== null) {
    ?>

    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin([
                    'action' => ['reset-password/reset-password', 'password' => $passwordHash],
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); ?>


                <?= $form->field($model, 'password')->passwordInput()->label('Новый пароль') ?>

                <?= $form->field($model, 'password_confirming')->passwordInput()->label('Повторить пароль') ?>


                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <?= Html::a('Отменить', Yii::$app->homeUrl, ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>

    <?php
} else {
    // Если пользователь не найден, выполняем редирект на домашнюю страницу
    Yii::$app->response->redirect(Yii::$app->homeUrl)->send();
    Yii::$app->end();
}
?>
