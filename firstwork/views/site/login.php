<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

/** @var app\models\PasswordResetForm $modelPasswordReset */

use app\assets\LoginAsset;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

LoginAsset::register($this);
$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'action' => ['login/login'],
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <p><?= Html::a('Не удается войти?', 'javascript:void(0);', ['class' => 'reset-password-link']) ?></p>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->label('Запомнить меня') ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <p>Нет аккаунта? <?= Html::a('Зарегистрируйся', ['site/registration']) ?></p>
            <?php ActiveForm::end(); ?>



        </div>
    </div>
</div>


<!-- Modal for password reset -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Восстановление пароля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $resetPasswordForm = ActiveForm::begin([
                    'action' => ['reset-password/send-password-reset-email'],
                    'id' => 'reset-password-form',
                ]); ?>
                <?= $resetPasswordForm->field($modelPasswordReset, 'email')->textInput()->label('Email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'reset-password-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
