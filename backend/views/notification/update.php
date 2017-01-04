<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Update Notification: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
\app\assets\NotificationAsset::register($this);
?>
<div class="notification-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="notification-form">

        <?php $form = ActiveForm::begin(['id' => 'updateNotificationForm']); ?>

        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'time')->textInput() ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <div class="form-group">
            <?= Html::button('Push Notification', ['class' => 'btn btn-warning', 'id' => 'updateBtn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>