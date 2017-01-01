<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'invt_locationID') ?>

    <?= $form->field($model, 'invt_typeID') ?>

    <?= $form->field($model, 'invt_bdgttypID') ?>

    <?= $form->field($model, 'invt_statID') ?>

    <?php // echo $form->field($model, 'invt_code') ?>

    <?php // echo $form->field($model, 'invt_name') ?>

    <?php // echo $form->field($model, 'invt_brand') ?>

    <?php // echo $form->field($model, 'invt_detail') ?>

    <?php // echo $form->field($model, 'invt_image') ?>

    <?php // echo $form->field($model, 'invt_ppp') ?>

    <?php // echo $form->field($model, 'invt_budgetyear') ?>

    <?php // echo $form->field($model, 'invt_occupyby') ?>

    <?php // echo $form->field($model, 'invt_note') ?>

    <?php // echo $form->field($model, 'invt_contact') ?>

    <?php // echo $form->field($model, 'invt_buyfrom') ?>

    <?php // echo $form->field($model, 'invt_buydate') ?>

    <?php // echo $form->field($model, 'invt_checkindate') ?>

    <?php // echo $form->field($model, 'invt_guarunteedateend') ?>

    <?php // echo $form->field($model, 'invt_takeoutdate') ?>

    <?php // echo $form->field($model, 'invt_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Html::icon('search').' '.Yii::t('inventory/app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Html::icon('refresh').' '.Yii::t('inventory/app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
