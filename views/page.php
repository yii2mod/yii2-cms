<?php

/* @var $this \yii\web\View */
/* @var $model \yii2mod\cms\models\CmsModel */
/* @var $commentWidgetParams array */

use yii\helpers\ArrayHelper;
use yii2mod\comments\widgets\Comment;

$this->params['bodyClass'] = $model->url;
$this->title = $model->metaTitle;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metaKeywords]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->metaDescription]);
?>
<div class="static-page">
    <h1><?php echo $model->title; ?></h1>
    <?php echo $model->getContent(); ?>
    <?php if ($model->commentAvailable): ?>
        <?php echo Comment::widget(ArrayHelper::merge(
            [
                'model' => $model,
                'relatedTo' => 'cms page: ' . $model->url,
            ],
            $commentWidgetParams
        )); ?>

    <?php endif; ?>
</div>