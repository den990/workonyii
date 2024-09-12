<?php

use app\models\searches\NoteSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';

$this->registerJs("
    $('#sort-dropdown').on('change', function() {
        $('#form').submit();
    });
");
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="note-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['/note'],
        'id' => 'form'
    ]); ?>
    <div class="row">
        <div class="col-3">
            <?= $form->field($searchModel, 'tag')->textInput(['placeholder' => 'Search by tags'])->label(false) ?>
        </div>
        <div class="col-3">
            <?= $form->field($searchModel, 'content')->textInput(['placeholder' => 'Search by content'])->label(false) ?>
        </div>
        <div class="form-group ">
            <?= Html::submitButton('Search', ['class' => 'btn btn-outline-success']) ?>
            <?= Html::a('Reset', ['/note'], ['class' => 'ms-2 btn btn-outline-secondary']) ?>
        </div>

    </div>


    <div class="d-flex  justify-content-between">
        <p>
            <?= Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="col-2">
            <?= $form->field($searchModel, 'sort')->dropDownList(
                NoteSearch::listSortOptions(),
                ['prompt' => 'Sort', 'id' => 'sort-dropdown']
            )->label(false) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'title',
        'content:ntext',
        [
            'label' => 'Теги',
            'value' => function ($model) {
                return implode(', ', array_map(function ($tag) {
                    return $tag->name;
                }, $model->tags));
            },
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
