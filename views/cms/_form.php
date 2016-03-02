<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\imperavi\Widget;
use \yii2mod\cms\models\enumerables\CmsStatus;

/* @var $this yii\web\View */
/* @var $model yii2mod\cms\models\CmsModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'content')->widget(Widget::className(), [
        'options' => [
            'minHeight' => 200,
            'replaceDivs' => false,
            'formatting' => ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'span']
        ],
        'id' => 'content',
    ]);
    ?>

    <?php echo $form->field($model, 'url', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">' . Yii::$app->urlManager->hostInfo . '/' . '</span>{input}</div>',
    ])->textInput(['maxlength' => 255])->hint(Yii::t('yii2mod.cms', 'This one accepts only letters, numbers, dash and slash, i.e. "docs/installation".')); ?>

    <?php echo $form->field($model, 'metaTitle')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'metaDescription')->textarea(['rows' => 6]); ?>

    <?php echo $form->field($model, 'metaKeywords')->textarea(['rows' => 6]); ?>

    <?php echo $form->field($model, 'commentAvailable')->checkbox()->label(Yii::t('app', 'Are comments available on the page?')); ?>

    <?php echo $form->field($model, 'status')->dropDownList(CmsStatus::listData()); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('yii2mod.cms', 'Create') : Yii::t('yii2mod.cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('yii2mod.cms', 'Go Back'), ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
