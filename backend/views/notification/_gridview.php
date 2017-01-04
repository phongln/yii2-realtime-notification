<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>
<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
                'template' => $default ? '{view}{update}{delete}' : '{view}{delete}'
            ],
        ],
    ]); ?>
</div>