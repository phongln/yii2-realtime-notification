<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="notification-index">

    <h1>Pushed notification</h1>

    <div class="notification-form">

        <?php $form = ActiveForm::begin(['id' => 'notificationForm']); ?>

        <?= \yii\bootstrap\Html::hiddenInput('tab', 'pushed') ?>

        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'time')->textInput() ?>

        <?= $form->field($model, 'url')->textInput() ?>

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