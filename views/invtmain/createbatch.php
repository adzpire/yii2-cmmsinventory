<?php

use yii\bootstrap\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMain */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'รายการ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-create">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::icon('edit') . ' ' . Html::encode($this->title) ?></span>
            <?= Html::a(Html::icon('list-alt') . ' ' . Yii::t('inventory/app', 'รายการ'), ['index'], ['class' => 'btn btn-success panbtn']) ?>
        </div>
        <div class="panel-body">
            <div class="invt-main-form">

                <?php $form = ActiveForm::begin([
                    'type' => 'horizontal',
//        'fieldConfig' => [
//            'errorOptions' => ['encode' => false],
//        ],
                ]); ?>
                <div class="form-group">
                    <?php echo Html::label('รหัส', '', ['class' => 'control-label col-md-2']); ?>
                    <div class="col-md-10">
                        <?php echo Html::textInput('template', '',['class'=> 'form-control', 'placeholder'=>'เช่น วสส. ว.01-123-*-55/ง']); ?>
                    </div>
                    <div class="col-md-offset-2 col-md-10"></div>
                    <div class="col-md-offset-2 col-md-10"><div class="help-block">เครื่องหมาย * เป็นจุดที่สร้างตัวเลข เช่น 1/70</div></div>
                </div>
                <div class="form-group">
                    <?php echo Html::label('จำนวน', '', ['class' => 'control-label col-md-2']); ?>
                    <div class="col-md-10">
                        <?php echo Html::textInput('genid', '',['class'=> 'form-control']); ?>
                    </div>
                    <div class="col-md-offset-2 col-md-10"></div>
                    <div class="col-md-offset-2 col-md-10"><div class="help-block"></div></div>
                </div>

                <div class="form-group text-center">
                    <?= Html::submitButton(Html::icon('play').' ต่อไป', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
