<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Update Notification: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notification-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="notification-form">

        <?php $form = ActiveForm::begin(['id' => 'updateNotificationForm']); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'time')->widget(\kartik\widgets\TimePicker::className(), [
            'addonOptions' => [
                'asButton' => true,
                'buttonOptions' => ['class' => 'btn btn-info']
            ],
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
            ]
        ]) ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <div class="form-group">
            <?= Html::button('Push Notification', ['class' => 'btn btn-warning', 'id' => 'updateBtn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php
$param_io_connect = Yii::$app->params['io_connect'];
$js=<<<JS
$(document).ready(function () {
    var socket = io.connect('$param_io_connect');
    function submitFormByAjax(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (resp) {
                socket.emit('notification', resp);
                window.location.href = resp.reloadLink;
            }
        });
    }
    $("#updateBtn").click(function () {
        submitFormByAjax($('#updateNotificationForm'));
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>