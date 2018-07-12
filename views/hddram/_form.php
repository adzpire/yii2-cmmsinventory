<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
/*
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtHddram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-hddram-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'invt-hddram-form',
			//'fieldConfig' => [
			//'horizontalCssClasses' => [
				//'label' => 'col-md-4',
				//'wrapper' => 'col-sm-8',
				//],
			//],
			//'validateOnChange' => true,
            //'enableAjaxValidation' => true,
			//	'enctype' => 'multipart/form-data'
			]); ?>


	<?php 
		echo $form->field($model, 'invt_id')->widget(Select2::classname(), [
            'initValueText' => ($model->isNewRecord ? false : $model->invt->shortdetail),  //set the initial display text
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
                'templateResult' => new JsExpression('function(ird_ivntID) { return ird_ivntID.text; }'),
                'templateSelection' => new JsExpression('function (ird_ivntID) { return ird_ivntID.text; }'),
            ],
        ]);
	?>
    <?= $form->field($model, 'hdd_exist')->textInput() ?>

    <?= $form->field($model, 'ram_exist')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

<?php 		/* adzpire form tips
		$form->field($model, 'wu_tel', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]);
		//file field
				echo $form->field($model, 'file',[
		'addon' => [
       
'append' => !empty($model->wt_image) ? [
			'content'=> Html::a( Html::icon('download').' '.Yii::t('app', 'download'), Url::to('@backend/web/'.$model->wt_image), ['class' => 'btn btn-success', 'target' => '_blank']), 'asButton'=>true] : false
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
        <?= Html::submitButton(Html::icon('floppy-disk').' '.'บันทึก', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php if(!$model->isNewRecord){
		 echo Html::resetButton( Html::icon('refresh').' '.'เริ่มใหม่' , ['class' => 'btn btn-warning']); 
		 } ?>
		 
	</div>

    <?php ActiveForm::end(); ?>

</div>
