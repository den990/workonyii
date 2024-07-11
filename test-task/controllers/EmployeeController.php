<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class EmployeeController extends ActiveController
{
    public $modelClass = 'app\models\Employee';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            Yii::$app->getResponse()->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $model;
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        Yii::$app->getResponse()->setStatusCode(204);
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException("Object not found: $id");
        }
    }
}
