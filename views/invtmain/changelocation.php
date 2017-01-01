<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
/*
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtLochistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-lochistory-form">
    <?php //$formAction = \yii\helpers\Url::to([$this->context->id.'/'.$this->context->action->id]); ?>
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => isset($full) ? false : 'invt-lochistory-form',
       // 'action' => $formAction,
        //'validateOnChange' => true,
        //'enableAjaxValidation' => true,
        //	'enctype' => 'multipart/form-data'
    ]); ?>

    <div class="form-group">
        <label class="control-label  col-sm-3">
            <?php echo 'last location';//$model->attributeLabels()['invt_locationID'] ?>
        </label>
        <div class="col-sm-6">
            <div class="form-control-static">
                <?php echo $model->invtLocation->loc_name; ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label  col-sm-3">
            <?php echo 'inventoryname';//$model->attributeLabels()['invt_locationID'] ?>
        </label>
        <div class="col-sm-6">
            <div class="form-control-static">
                <?php echo $model->invt_name; ?>
            </div>
        </div>
    </div>

    <?php

    /*echo $form->field($model, 'invt_ID')->widget(Select2::classname(), [
        //'initValueText' => $cityDesc,  set the initial display text
        'options' => ['placeholder' => 'พิมพ์ 3 ตัวอักษรขึ้นไปเพื่อค้นหา ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'กำลังค้นหา...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['invtlist']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(invt_ID) { return invt_ID.text; }'),
            'templateSelection' => new JsExpression('function (invt_ID) { return invt_ID.text; }'),
        ],
    ]);*/
    ?>
    <?php
    echo $form->field($model, 'invt_locationID')->widget(Select2::classname(), [
        'data' => $locarray,
        'options' => ['placeholder' => Yii::t('inventory/app', 'PleaseSelect')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php 		/* adzpire form tips
		$form->field($model, 'wu_tel', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]);
		//file field
				echo $form->field($model, 'file',[
		'addon' => [

'append' => !empty($model->wt_image) ? [
			'content'=> Html::a( Html::icon('download').' '.Yii::t('kpi/app', 'download'), Url::to('@backend/web/'.$model->wt_image), ['class' => 'btn btn-success', 'target' => '_blank']), 'asButton'=>true] : false
    ]])->widget(FileInput::classname(), [
			//'options' => ['accept' => 'image/*'],
			'pluginOptions' => [
				'showPreview' => false,
				'showCaption' => true,
				'showRemove' => true,
				'initialCaption'=> $model->isNewRecord ? '' : $model->wt_image,
				'showUpload' => false
			]
]);
		*/
    ?>     <div class="form-group text-center">
        <?= Html::submitButton(Html::icon('floppy-disk').' '.Yii::t('inventory/app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php
            echo Html::resetButton( Html::icon('refresh').' '.Yii::t('inventory/app', 'Reset') , ['class' => 'btn btn-warning']);
        ?>

    </div>

    <?php ActiveForm::end(); ?>
    <?php

    $this->registerJs("
$('form#invt-lochistory-form').on('beforeSubmit', function(event){

	var form = $(this);
	$.post(
		form.attr('action'),
		form.serialize()
	).done(function(result){
		if(result == 1){
			form.trigger('reset');
			$('#invttmodal').modal('hide');
			$.pjax.reload({container:'#locpjax'});
			alert('".Yii::t('kpi/app', 'locChanged')."');
		}else{
			alert(result);
		}
	}).fail(function(result){
		alert('server error');
	});
	return false;
});
", View::POS_END);


    ?>
</div>
