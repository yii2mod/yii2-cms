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
            'formatting' => ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'span'],
            'formattingAdd' => [
                [
                    'tag' => 'span',
                    'title' => 'Color Green',
                    'class' => 'green',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Color Gray',
                    'class' => 'gray',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Font Size 10px',
                    'class' => 'font-size-10',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Font Size 15px',
                    'class' => 'font-size-15',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Font Size 20px',
                    'class' => 'font-size-20',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Font Size 25px',
                    'class' => 'font-size-25',
                ],
                [
                    'tag' => 'span',
                    'title' => 'Font Size 30px',
                    'class' => 'font-size-30',
                ],
            ],
        ],
        'id' => 'content',
    ]);
    ?>

    <?php echo $form->field($model, 'url', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">' . Yii::$app->urlManager->hostInfo . '/' . '</span>{input}</div>',
    ])->textInput(['maxlength' => 255])->hint(Yii::t('modcms', 'This one accepts only letters, numbers, dash and slash, i.e. "docs/installation".')); ?>

    <?php echo $form->field($model, 'metaTitle')->textInput(['maxlength' => 255]); ?>

    <?php echo $form->field($model, 'metaDescription')->textarea(['rows' => 6]); ?>

    <?php echo $form->field($model, 'metaKeywords')->textarea(['rows' => 6]); ?>

    <?php echo $form->field($model, 'status')->dropDownList([
        Yii::t('modcms', CmsStatus::$$list[CmsStatus::ENABLED]),
        Yii::t('modcms', CmsStatus::$$list[CmsStatus::DISABLED]),
    ]); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('modcms', 'Create') : Yii::t('modcms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('modcms', 'Cancel'), ['index'], ['class' => 'btn btn-default']); ?>
        <?php if (!$model->isNewRecord) : ?>
            <?php echo Html::a(Yii::t('modcms', 'Revert Content To Default'), ['revert', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
