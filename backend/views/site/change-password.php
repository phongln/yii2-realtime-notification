<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Change password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-change-password">
    <?php if(Yii::$app->session->hasFlash('success-message')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Congratulation!</strong> <?= Yii::$app->session->getFlash('success-message') ?>
        </div>
    <?php endif; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'old_password')->passwordInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'repeat_password')->passwordInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
