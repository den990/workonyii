<?php
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;

$this->title = 'Вход или регистрация через VK';
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для продолжения, пожалуйста, войдите через VK:</p>

    <div class="auth-clients">
        <?= AuthChoice::widget([
            'baseAuthUrl' => ['auth/auth'], // указываем URL для authAction в AuthController
        ]) ?>
    </div>
</div>
