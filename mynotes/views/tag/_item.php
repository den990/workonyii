<?php

use yii\helpers\Html;

/* @var $model app\models\Tag */

?>
<div class="tag-item d-flex justify-content-between mt-1 border border-1 p-2">
    <div class="d-flex align-items-center">
        <?= Html::encode($model->name) ?>
    </div>
    <div>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this tag?',
            'method' => 'post',
        ],
    ]) ?>
    </div>
</div>
