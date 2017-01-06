<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php if(Yii::$app->session->hasFlash('error-message')) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> <?= Yii::$app->session->getFlash('error-message') ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('success-message')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Congratulation!</strong> <?= Yii::$app->session->getFlash('success-message') ?>
        </div>
    <?php endif; ?>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?= $tab == 'pushed' ? 'active' : '' ?>"><a href="#pushed" aria-controls="profile" role="tab" data-toggle="tab">Pushed</a></li>
        <li role="presentation" class="<?= $tab == 'default' ? 'active' : '' ?>"><a href="#default" aria-controls="home" role="tab" data-toggle="tab">Default</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?= $tab == 'pushed' ? 'active' : '' ?>" id="pushed">
            <?= $this->render('_pushed', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        ]) ?>
        </div>
        <div role="tabpanel" class="tab-pane <?= $tab == 'default' ? 'active' : '' ?>" id="default">
            <?= $this->render('_default', [
                'model' => $model,
                'dataProvider' => $defaultDataProvider,
                'searchModel' => $searchModel,
            ]) ?>
        </div>
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

    $("#pushBtn").click(function () {
        if($('#instantPushed').is(":checked")) {
            var currentTime = /(..)(:..)/.exec(new Date());
            $(".pushedNotification").val(currentTime[0]);        
        }
        submitFormByAjax($('#notificationForm'));
    });
    $("#changeBtn").click(function () {
        submitFormByAjax($('#defaultNotificationForm'));
    });
    $("#updateBtn").click(function () {
        submitFormByAjax($('#updateNotificationForm'));
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
