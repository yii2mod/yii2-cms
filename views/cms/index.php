<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii2mod\editable\EditableColumn;

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
    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'url',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->url, Url::to($model->url, true));
                }
            ],
            [
                'class' => EditableColumn::className(),
                'attribute' => 'title',
                'url' => ['edit-page'],
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'status',
                'vAlign' => 'middle',
                'width' => '150px',
                'filterInputOptions' => ['prompt' => 'Select Status', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'createdAt',
                'value' => function ($model) {
                    return date("d-M-Y", $model->createdAt);
                },
                'filter' => false,
            ],
            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ]
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
