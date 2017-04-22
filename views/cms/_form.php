<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2mod\cms\Widget;
use yii2mod\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model yii2mod\cms\models\CmsModel */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="cms-model-form">
    <div class="row">
        <div class="col-md-10">
            <?php $form = ActiveForm::begin(['id' => 'cms-form']); ?>

            <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

            <?php if (Yii::$app->getModule('cms')->enableMarkdown): ?>
                <?php echo $form->field($model, 'markdown_content')->widget(MarkdownEditor::class, [
                    'editorOptions' => Yii::$app->getModule('cms')->markdownEditorOptions,
                ]); ?>
            <?php else: ?>
                <?php echo $form->field($model, 'content')->widget(Widget::class, Yii::$app->getModule('cms')->froalaEditorOptions); ?>
            <?php endif; ?>

            <?php echo $form->field($model, 'url', [
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon">' . Yii::$app->urlManager->hostInfo . '/' . '</span>{input}</div>',
            ])->textInput(['maxlength' => 255])->hint(Yii::t('yii2mod.cms', 'This one accepts only letters, numbers, dash and slash, i.e. "docs/installation".')); ?>

            <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]); ?>

            <?php echo $form->field($model, 'meta_description')->textarea(['rows' => 6]); ?>

            <?php echo $form->field($model, 'meta_keywords')->textarea(['rows' => 6]); ?>

            <?php echo $form->field($model, 'comment_available')->checkbox()->label(Yii::t('yii2mod.cms', 'Are comments available on the page?')); ?>

            <?php echo $form->field($model, 'status')->dropDownList(CmsStatus::listData()); ?>

            <div class="form-group">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('yii2mod.cms', 'Create') : Yii::t('yii2mod.cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
                <?php echo Html::a(Yii::t('yii2mod.cms', 'Go Back'), ['index'], ['class' => 'btn btn-default']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
