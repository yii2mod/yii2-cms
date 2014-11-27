<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-model-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('app', 'Create Page', [
            'modelClass' => 'Cms Model',
        ]), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>
    <?php \yii\widgets\Pjax::begin(['enablePushState' => false,'timeout' => 3000]); ?>
    <?php echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'url',
                'format' => 'html',
                'value' => function ($model) {
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
                'attribute' => 'updatedAt',
                'value' => function ($model) {
                    return date("d-M-Y", $model->updatedAt);
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
    <?php \yii\widgets\Pjax::end(); ?>
</div>
