<?php

namespace app\controllers;

use app\models\searches\NoteSearch;
use app\models\Tag;
use Yii;
use yii\web\Controller;
use app\models\Note;
use app\models\forms\NoteForm;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class NoteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'index', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new NoteForm();

        $tags = Tag::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {;
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'tags' => $tags,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $tags = Tag::find()->all();

        return $this->render('update', [
            'model' => $model,
            'tags' => $tags,
        ]);
    }

    public function actionDelete($id)
    {
        $note = $this->findModel($id);
        $note->delete();

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $note = $this->findModel($id);
        return $this->render('view', [
            'note' => $note,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = NoteForm::findOne($id)) !== null && $model->user_id === Yii::$app->user->id) {
            $model->tagIds = $model->getTags()->select('id')->column();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
