<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $note app\models\Note */

$this->title = $note->title;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $note->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $note->id], [
            'class' => 'btn btn-danger',
            'data-method' => 'post',
            'data-confirm' => Yii::t('app', 'Вы собираетесь удалить "{object}". Подтвердите свое действие. Продолжить?', [
                'object' => $note->title
            ]),
        ]) ?>
    </p>

    <div class="note-content">
        <p><?= nl2br(Html::encode($note->content)) ?></p>
    </div>

</div>
