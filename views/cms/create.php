<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model yii2mod\cms\models\CmsModel */

$this->title = Yii::t('yii2mod', 'Create Page', [
    'modelClass' => 'Cms Model',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii2mod', 'Cms Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-model-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
