<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>
<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'message',
            'time',
            [
                'class' => 'yii\grid\DataColumn',
                'label' => 'Link',
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\bootstrap\Html::a($model->url, $model->url, ['target' => '_blank']);
                },
            ],
            'created_at',
            [
                'class' => 'yii\grid\DataColumn',
                'label' => 'Created by',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->created_by) ? $model->createdBy->username : "Unknown";
                },
            ],
            'updated_at',
            [
                'class' => 'yii\grid\DataColumn',
                'label' => 'Updated by',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->updated_by) ? $model->updatedBy->username : "Unknown";
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $default ? '{update}{delete}' : '{view}{delete}{refresh}',
                'buttons' => [
                    'refresh' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-refresh"></span>', 'javascript:void(0);', [
                            'title' => Yii::t('app', 'Refresh'),
                            'class' => 'refreshNotificationBtn',
                            'data-id' => $model->id
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<?php
$param_io_connect = Yii::$app->params['io_connect'];
$refreshLink = Yii::$app->params['domain'] . 'notification/refresh';
$js=<<<JS
var socket = io.connect('$param_io_connect');
// var socket = io.connect('http://125.212.210.113:8890');
$(".refreshNotificationBtn").click(function() {
    var id = $(this).data("id");
    $.ajax({
        url: '$refreshLink',
        type: 'post',
        data: {id: id},
        success: function (resp) {
            socket.emit('notification', resp);
            window.location.href = resp.reloadLink;
        }
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>