<?php
/**
 * @package yii2mod\cms
 * @var object \yii2mod\cms\models\CmsModel $model
 */

$this->params['bodyClass'] = $model->url;
?>

<div class="static-page">
    <?php
    $this->title = $model->metaTitle;
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->metaKeywords]);
    $this->registerMetaTag(['name' => 'description', 'content' => $model->metaDescription]);
    ?>
    <h1><?php echo $model->title; ?></h1>
    <?php echo $model->getContent(); ?>
</div>


