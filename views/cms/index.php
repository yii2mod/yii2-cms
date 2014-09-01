<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create Page', [
            'modelClass' => 'Cms Model',
        ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'url',
                'format' => 'html',
                'value' => function ($model, $index, $wiredget) {
                        return Html::a($model->url, Url::to($model->url, true));
                    }
            ],
            'title',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'status',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'dateUpdated',
                'value' => function ($model, $index, $widget) {
                        return date("d-M-Y", $model->dateUpdated);
                    },
            ],
            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]);
    ?>

</div>
