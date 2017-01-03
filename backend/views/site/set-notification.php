<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Notification BE Control';
$this->params['breadcrumbs'][] = $this->title;

\app\assets\NotificationAsset::register($this);
?>
<div class="site-about">
    <div class="alert alert-warning alert-dismissible hide" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong>
        <span id="err-mess"></span>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the Notification BE Control page.
    </p>
    <?php \yii\widgets\ActiveForm::begin([
            'id' => 'notificationForm',
            'options' => [
                'class' => 'form-horizontal'
            ]
    ]) ?>
    <div class="form-group">
        <?= \yii\bootstrap\Html::label('Hours: ', 'hour', ['class' => 'col-lg-1 control-label']) ?>
        <div class="col-lg-3">
            <input type="number" id="hour" class="form-control" name="hour" min="0" max="23">
       </div>
    </div>

    <div class="form-group">
        <?= \yii\bootstrap\Html::label('Minutes: ', 'minute', ['class' => 'col-lg-1 control-label']) ?>
        <div class="col-lg-3">
            <input type="number" id="minute" class="form-control" name="minute" min="0" max="59">
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <button type="button" class="btn btn-primary" id="pushBtn">Push notification</button>
        </div>
    </div>

    <div class="form-group">
        <ul id="changedList">
        </ul>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
