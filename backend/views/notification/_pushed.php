<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="notification-index">

    <h1>Pushed notification</h1>

    <div class="notification-form">

        <?php $form = ActiveForm::begin(['id' => 'notificationForm']); ?>

        <?= \yii\bootstrap\Html::hiddenInput('tab', 'pushed') ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

        <?= $form->field($model, 'message')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <div class="checkbox">
            <label style="font-weight: bold;">
                <?= \yii\bootstrap\Html::checkbox('instant', 0, ['id' => 'instantPushed']) ?> Instant Pushed
            </label>
        </div>

        <?= $form->field($model, 'time')->widget(\kartik\widgets\TimePicker::className(), [
            'options' => [
                'class' => 'pushedNotification'
            ],
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

        <?= $form->field($model, 'status')->hiddenInput(['value' => 0])->label(false) ?>

        <div class="form-group">
            <?= Html::button('Push Notification', ['class' => 'btn btn-success', 'id' => 'pushBtn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?= $this->render('_gridview', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'default' => false
]) ?>
<?php
$js=<<<JS
$("#instantPushed").change(function() {
    var parentPushed = $(".pushedNotification").parents(".field-notification-time");
    if($(this).is(":checked")) {
        $(this).val(1);
        $(parentPushed).removeClass("show");
        $(parentPushed).addClass("hide");
    } else {
        $(this).val(0);
        $(parentPushed).removeClass("hide");
        $(parentPushed).addClass("show");
    }
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
