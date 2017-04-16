<?php

/* @var $this \yii\web\View */
/* @var $model \yii2mod\cms\models\CmsModel */
/* @var $commentWidgetParams array */

use yii\helpers\ArrayHelper;
use yii2mod\comments\widgets\Comment;

$this->title = $model->meta_title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
?>
<div class="page-wrapper">
    <h1 class="page-title">
        <?php echo $model->title; ?>
    </h1>
    <div class="page-content">
        <?php echo $model->getContent(); ?>
    </div>
    <?php if ($model->comment_available): ?>
        <div class="page-comments">
            <?php echo Comment::widget(ArrayHelper::merge(
                [
                    'model' => $model,
                    'relatedTo' => 'cms page: ' . $model->url,
                ],
                $commentWidgetParams
            )); ?>
        </div>
    <?php endif; ?>
</div>
