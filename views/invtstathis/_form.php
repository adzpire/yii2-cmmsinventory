<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\DatePicker;
/*
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtStathistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-stathistory-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'invt-stathistory-form',
			//'validateOnChange' => true,
            //'enableAjaxValidation' => true,
			//	'enctype' => 'multipart/form-data'
			]); ?>
    <?php if(!$model->isNewRecord){ ?>
        <div class="form-group">
            <label class="control-label  col-sm-3">
                สถานะล่าสุด
            </label>
            <div class="col-sm-6">
                <div class="form-control-static">
                    <?php echo $model->invtStat->invt_sname; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    echo $form->field($model, 'invt_ID')->widget(Select2::classname(), [
        'initValueText' => ($model->isNewRecord ? false : $model->invt->invt_name),  //set the initial display text
        'options' => ['placeholder' => 'พิมพ์ ชื่อ/ยี่ห้อรุ่น/รหัส 3 ตัวอักษรขึ้นไปเพื่อค้นหา ...'],
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
    ]);
    ?>

    <?php
    echo $form->field($model, 'invt_statID')->dropDownList($statlist);
    ?>

	<?php $model->date = $model->isNewRecord ? date('Y-m-d') : $model->date;
	echo $form->field($model, 'date')->widget(DatePicker::classname(), [
		'language' => 'th',
		'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
		'type' => DatePicker::TYPE_COMPONENT_APPEND,
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'yyyy-mm-dd'
		]
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
        <?= Html::submitButton($model->isNewRecord ?  Html::icon('floppy-disk').' '.Yii::t('inventory/app', 'Save') :  Html::icon('floppy-disk').' '.Yii::t('inventory/app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php if(!$model->isNewRecord){
		 echo Html::resetButton( Html::icon('refresh').' '.Yii::t('inventory/app', 'Reset') , ['class' => 'btn btn-warning']); 
		 } ?>
		 
	</div>

    <?php ActiveForm::end(); ?>

</div>
