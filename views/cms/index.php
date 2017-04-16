<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2mod\editable\EditableColumn;
use yii2mod\enum\helpers\BooleanEnum;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \yii2mod\cms\models\search\CmsSearch */

$this->title = Yii::t('yii2mod.cms', 'Cms Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-model-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Yii::t('yii2mod.cms', 'Create Page'), ['create'], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a(Yii::t('yii2mod.cms', 'View Comments'), ['/comment/manage/index'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(['timeout' => 5000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'class' => EditableColumn::class,
                'attribute' => 'url',
                'url' => ['edit-page'],
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'title',
                'url' => ['edit-page'],
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'status',
                'url' => ['edit-page'],
                'value' => function ($model) {
                    return CmsStatus::getLabel($model->status);
                },
                'type' => 'select',
                'editableOptions' => function ($model) {
                    return [
                        'source' => CmsStatus::listData(),
                        'value' => $model->status,
                    ];
                },
                'filter' => CmsStatus::listData(),
                'filterInputOptions' => ['prompt' => Yii::t('yii2mod.cms', 'Select Status'), 'class' => 'form-control'],
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'comment_available',
                'url' => ['edit-page'],
                'value' => function ($model) {
                    return BooleanEnum::getLabel($model->comment_available);
                },
                'type' => 'select',
                'editableOptions' => function ($model) {
                    return [
                        'source' => BooleanEnum::listData(),
                        'value' => $model->comment_available,
                    ];
                },
                'filter' => BooleanEnum::listData(),
                'filterInputOptions' => ['prompt' => Yii::t('yii2mod.cms', 'Select'), 'class' => 'form-control'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'full'],
            ],
            [
                'header' => Yii::t('yii2mod.cms', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to($model->url, true),
                            [
                                'title' => Yii::t('yii2mod.cms', 'View'),
                                'data-pjax' => 0,
                                'target' => '_blank',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
