<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtBudgettypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-budgettype-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'invt_bname') ?>

    <?= $form->field($model, 'invt_bdetail') ?>

    <div class="form-group">
        <?= Html::submitButton(Html::icon('search').' '.Yii::t('inventory/app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Html::icon('refresh').' '.Yii::t('inventory/app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
