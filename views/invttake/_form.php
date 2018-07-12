<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\Url;
/*
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\FormInvttakeMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-invttake-main-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'form-invttake-main-form',
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
    <div class="col-md-12">
        <h4 class="text-center">ใบเบิกครุภัณฑ์จากงานพัสดุ</h4>
    </div>
    <div class="col-md-6 col-md-offset-6">
        <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
            'language' => 'th',
            'options' => ['placeholder' => 'enterdate'],
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]]) ?>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'staffID', [
                'horizontalCssClasses' => [
                    'label' => 'col-md-3',
                    'wrapper' => 'col-md-9',
                ],
            ])->label('ข้าพเจ้า')->widget(Select2::classname(), [
                'data' => $staff,
                'options' => ['placeholder' => Yii::t('app', 'ค้นหา/เลือก')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => '
                function() {
                    var str = $(this).val();
                    console.log(str);
                    $.ajax({
                        url: "'.Url::to(['/dochub/default/posinfo']).'?id="+str,
                        success: function(data){
                            var json = $.parseJSON(data);
                            $("._posinfo").html(json[0]);
                        }
                    });
                }',
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            ตำแหน่ง <mark class="_posinfo"> <?php echo $model->isNewRecord ? '-' : $model->staff->position->name_th; ?> </mark>
        </div>
    </div>
    <div class="col-md-11 col-md-offset-1">
        <?php
        echo $form->field($model, 'LocationID', [
            'horizontalCssClasses' => [
                'label' => 'col-md-4',
                'wrapper' => 'col-md-5',
            ],
        ])->widget(Select2::classname(), [
            'data' => $loclist,
            'options' => ['placeholder' => 'ระบุสถานที่'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label('มีความประสงค์ขอเบิกครุภัณฑ์เพื่อใช้ประจำที่');
        ?>
    </div>


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
        <?= Html::submitButton(Html::icon('play').' '.'ต่อไป', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php if(!$model->isNewRecord){
            echo Html::a(Html::icon('list') . ' ' . Yii::t('app', 'เพิ่มรายการ'), ['detail', 'id' => $model->ID], ['class' => 'btn btn-success _qdetail']);
            echo ' '.Html::resetButton( Html::icon('refresh').' '.'เริ่มใหม่' , ['class' => 'btn btn-warning']);
		 } ?>
		 
	</div>

    <?php ActiveForm::end(); ?>

</div>
