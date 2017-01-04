<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
\app\assets\NotificationAsset::register($this);
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

