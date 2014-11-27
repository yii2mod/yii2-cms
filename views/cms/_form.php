<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\imperavi\Widget;
use \yii2mod\cms\models\enumerables\CmsStatus;

/* @var $this yii\web\View */
/* @var $model yii2mod\cms\models\CmsModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'content')->widget(Widget::className(), [
        'options' => [
            'minHeight' => 200,
        ]
    ])
    ?>
    <?php echo $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'metaTitle')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'metaDescription')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'metaKeywords')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'status')->dropDownList(CmsStatus::$list) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
