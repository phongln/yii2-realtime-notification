<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="notification-default">
    <h1>Default configuration notification</h1>

    <div class="notification-form">

        <?php $form = ActiveForm::begin(['id' => 'defaultNotificationForm']); ?>

        <?= \yii\bootstrap\Html::hiddenInput('tab', 'default') ?>

        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'time')->textInput() ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <?= $form->field($model, 'status')->hiddenInput(['value' => 1])->label(false) ?>

        <div class="form-group">
            <?= Html::button('Change default configuration', ['class' => 'btn btn-primary', 'id' => 'changeBtn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?= $this->render('_gridview', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'default' => true
]) ?>