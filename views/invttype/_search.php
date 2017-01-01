<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'invt_tname') ?>

    <?= $form->field($model, 'invt_tdetail') ?>

    <div class="form-group">
        <?= Html::submitButton(Html::icon('search').' '.Yii::t('inventory/app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Html::icon('refresh').' '.Yii::t('inventory/app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
