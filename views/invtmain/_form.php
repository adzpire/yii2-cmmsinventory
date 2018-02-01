<?php

use yii\bootstrap\Html;
//use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;

use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
/*
use dosamigos\ckeditor\CKEditor;
<?= $form->field($model, 'content')->widget(CKEditor::className(), [
                            'preset' => 'full',
                            //'clientOptions' => KCFinder::registered()
                        ]) ?>

use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-main-form">

    <?php /*$form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'invt-main-form',
            'options' => ['enctype' => 'multipart/form-data']
			//'validateOnChange' => true,
            //'enableAjaxValidation' => true,
			//	'enctype' => 'multipart/form-data'
			]);*/ ?>

    <?php $form = ActiveForm::begin([
        'type' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
//        'fieldConfig' => [
//            'errorOptions' => ['encode' => false],
//        ],
    ]); ?>

    <?php Pjax::begin(['id' => 'locpjax']); ?>
    <?php
    if($model->isNewRecord){ ?>
        <?= $form->field($model, 'invt_locationID',[
            'addon' => [
                'append' =>
                    [
                        'content'=>
                            Html::button( Html::icon('refresh'), ['class' => 'btn btn-warning _refreshloclist', 'title' => 'รีเฟรชรายการ', 'data' =>['toggle'=>'tooltip']]).
                            Html::button( Html::icon('plus'), ['value' => Url::to(['createloca']),'class' => 'btn btn-success _locqadd', 'title' => 'เพิ่มสถานที่', 'data' =>['toggle'=>'tooltip']]),
                        'asButton' => true,
                    ]
            ]
        ])->dropDownList($locarray, ['id' => 'invtloclist',]); ?>
    <?php }else{ ?>
        <div class="form-group field-invtmain-invt_locationid required">
            <label class="control-label col-md-2" for="invtmain-invt_locationid">
                <?php echo $model->attributeLabels()['invt_locationID'] ?>
            </label>
            <div class="col-md-10">
                <div class="input-group">
                    <div class="form-control-static">
                        <?php echo $model->invtLocation->loc_name; ?>
                    </div>
                        <span class="input-group-btn">
                            <?php echo Html::button( Html::icon('transfer'), ['value' => Url::to(['changeloc', 'id'=>$model->id]),'class' => 'btn _chngloc', 'title' => 'change location', 'data' =>['toggle'=>'tooltip']]) ?>
                        </span>
                </div>
            </div>
            <div class="col-md-offset-2 col-md-10"><div class="hint-block">คลิ้กปุ่มเพื่อย้ายที่ตั้ง</div></div>
        </div>  
        <?php } ?>
    <?php Pjax::end(); ?>

    <?php Pjax::begin(['id' => 'typepjax']); ?>
    <?= $form->field($model, 'invt_typeID',[
		/*'inputTemplate' => '<div class="input-group">{input}<span class="input-group-btn">'.
		Html::button( Html::icon('refresh'), ['class' => 'btn btn-warning _refreshlist', 'title' => 'refresh list', 'data' =>['toggle'=>'tooltip']]).
		Html::button( Html::icon('plus'), ['value' => Url::to(['createtype']),'class' => 'btn btn-success _invttqadd', 'title' => 'add inventory type', 'data' =>['toggle'=>'tooltip']])
		.'</span></div>',*/
        'addon' => [
            'append' =>
                [
                    'content'=>
                        Html::button( Html::icon('refresh'), ['class' => 'btn btn-warning _refreshlist', 'title' => 'รีเฟรชรายการ', 'data' =>['toggle'=>'tooltip']]).
                        Html::button( Html::icon('plus'), ['value' => Url::to(['createtype']),'class' => 'btn btn-success _invttqadd', 'title' => 'เพิ่มประเภท', 'data' =>['toggle'=>'tooltip']]),
		        'asButton' => true,
                ]
        ]
			])->dropDownList($invttarray, ['id' => 'invttlist',]); ?>
    <?php Pjax::end(); ?>

	<?php /*$form->field($model, 'invt_bdgttypID', [
            'addon' => [
                'append' =>
                    [
                        'content'=>
                            Html::button( Html::icon('refresh'), ['class' => 'btn btn-warning _refreshlist2', 'title' => 'refresh list', 'data' =>['toggle'=>'tooltip']]).
                            Html::button( Html::icon('plus'), ['value' => Url::to(['createbudget']),'class' => 'btn btn-success _bdgttypqadd', 'title' => 'add inventory budget type', 'data' =>['toggle'=>'tooltip']]),
                        'asButton' => true,
                    ]!empty($model->wt_image) ? [
                            'content'=> Html::a( Html::icon('download').' '.Yii::t('kpi/app', 'download'), Yii::getAlias('@webfrontend/uploads/inventory_files/'.$model->invt_image), ['class' => 'btn btn-success', 'target' => '_blank']), 'asButton'=>true
                            ] : false
            ]
			])->dropDownList($bdgttyparray, ['id' => 'bdgttyplist',]);*/ ?>

    <?= $form->field($model, 'invt_bdgttypID')->widget(Select2::classname(), [
        'data' => $bdgttyparray,
        'options' => ['placeholder' => Yii::t('inventory/app', 'PleaseSelect')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php
        if($model->isNewRecord){
            echo $form->field($model, 'invt_statID')->widget(Select2::classname(), [
                'data' => $invtstatarray,
                'options' => ['placeholder' => Yii::t('inventory/app', 'PleaseSelect')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        } else{ ?>
            <?php Pjax::begin(['id' => 'statpjax']); ?>
            <div class="form-group field-invtmain-invt_statID required">
                <label class="control-label col-md-2" for="invtmain-invt_statID">
                    <?php echo $model->attributeLabels()['invt_statID'] ?>
                </label>
                <div class="col-md-10">
                    <div class="input-group">
                        <div class="form-control-static">
                            <?php echo $model->invtStat->invt_sname ?>
                        </div>
                        <span class="input-group-btn">
                            <?php echo Html::button( Html::icon('stats'), ['value' => Url::to(['changestat', 'id'=>$model->id]),'class' => 'btn _chngstat', 'title' => 'change status', 'data' =>['toggle'=>'tooltip']]) ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-10"><div class="hint-block">คลิ้กปุ่มเพื่อเปลี่ยสถานะ</div></div>
            </div>
            <?php Pjax::end(); ?>
    <?php    }    ?>

    <?php //= $form->field($model, 'invt_code')->textInput(['maxlength' => true]) ?>

    <?php
    //if($model->isNewRecord) {
    if(\Yii::$app->controller->action->id != 'batchcheck') {
        echo $form->field($model, 'invt_code', [
            'enableAjaxValidation' => true,
            'errorOptions' => [
                'encode' => false,
                'class' => 'help-block'
            ],
            //'inputOptions' => ['autofocus' => 'autofocus'],
        ])->widget(\yii\jui\AutoComplete::classname(), [
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'เช่น วสส.ว.13-202-002-1/1-56/ง',
                'autofocus' => (isset($id)) ? 'autofocus' : false,
//                'fieldConfig' => [
//                    'errorOptions' => ['encode' => false],
//                ],
            ],
            'clientOptions' => [
                //'source' => $codearr,
                'source' => new JsExpression("function(request, response) {
                    $.getJSON('searchcode', {
                        id: request.term
                    }, response);
                }"),
                'minLength'=>'2',
            ],
        ]);
    }
     /*else{
        echo $form->field($model, 'invt_code', [
            'enableAjaxValidation' => true,
            'addon' => [
                'append' =>
                    [
                        'content' =>
                            Html::button(Html::icon('duplicate'), ['value' => Url::to(['copy']), 'class' => 'btn btn-primary _qcopy', 'title' => 'คัดลอก', 'data' => ['toggle' => 'tooltip']]),
                        'asButton' => true,
                    ]
            ]
        ])->widget(\yii\jui\AutoComplete::classname(), [
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'เช่น วสส.ว.13-202-002-1/1-56/ง',
            ],
            'clientOptions' => [
                'source' => $codearr,
            ],
        ]);
    }*/ ?>

    <?php //$form->field($model, 'invt_name')->textInput(['maxlength' => true])
        echo $form->field($model, 'invt_name')->widget(\yii\jui\AutoComplete::classname(), [
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'เช่น จอมอนิเตอร์, เครื่องคอมพิวเตอร์',
            ],
            'clientOptions' => [
                //'source' => $brndarr,
                'source' => new JsExpression("function(request, response) {
                $.getJSON('searchname', {
                    id: request.term
                }, response);
            }"),
                'minLength'=>'2',
            ],
        ])

    ?>

    <?php //= $form->field($model, 'invt_brand')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'invt_brand')->widget(\yii\jui\AutoComplete::classname(), [
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'เช่น HP, acer',
        ],
        'clientOptions' => [
            //'source' => $brndarr,
            'source' => new JsExpression("function(request, response) {
                $.getJSON('searchbrand', {
                    id: request.term
                }, response);
            }"),
            'minLength'=>'2',
        ],
    ]) ?>

    <?= $form->field($model, 'invt_detail')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'invt_image')->textInput(['maxlength' => true]) ?>
    <?php
//    echo $form->field($model, 'file',[
//        'addon' => [
//            'append' => !empty($model->invt_image) ? [
//                'content'=> Html::a( Html::icon('download').' '.Yii::t('kpi/app', 'download'), Yii::getAlias('@webfrontend/uploads/inventory_files/'.$model->invt_image), ['class' => 'btn btn-success', 'target' => '_blank']), 'asButton'=>true] : false
//        ]])->widget(FileInput::classname(), [
//        //'options' => ['accept' => 'image/*'],
//        'pluginOptions' => [
//            'showPreview' => false,
//            'showCaption' => true,
//            'showRemove' => true,
//            'initialCaption'=> $model->isNewRecord ? '' : $model->invt_image,
//            'showUpload' => false
//        ]
//    ]);
    ?>

    <?php
    echo $form->field($model, 'invt_image')->widget(
        \adzpire\basicfilemanager\widgets\BfmTextInput::className(),
        [
            'browserUrl' => '/basicfilemanager',
            'returnType' => 'basename',
            //'modalOptions' => ['id' => 'modal-post-thumbnail'],
            'options' => [
                'subDir' => 'inventory_files', //บังคับเข้า dir ตามค่า (default='')
                'changeDir' => false, //การอนุญาตให้เปลี่ยน dir ได้ (default=true)
                'createDir' => false, //การอนุญาติให้สร้าง dir ได้ (default=true)
                'upload' => true, //การอนุญาติให้ upload ได้ (default=true)
                'selectFileOnly' => true,
                'hidePreview' => true,
                'resizeOptions' => [
                    'keepratio'=> true,
                    'width' => 800,
                    //'height' => 800,
                ],
            ],
        ]
    );
    ?>

    <?= $form->field($model, 'invt_ppp')->widget(MaskedInput::classname(), [
        'clientOptions' => [
            'alias' =>  'decimal',
            'rightAlign' => false,
            //'groupSeparator' => ',',
            //'autoGroup' => true
        ],
    ]); ?>

    <?php
    echo $form->field($model, 'invt_budgetyear')->widget(DatePicker::classname(), [
        'language' => 'th',
        'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy',
            'startView'=>'years',
            'minViewMode'=>'years',
        ]
    ]);
    ?>
    <?php //= $form->field($model, 'invt_occupyby')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'invt_occupyby')->widget(\yii\jui\AutoComplete::classname(), [
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'เช่น งานอาคารสถานที่, อับดุลอาซิส ดือราแม',
        ],
        'clientOptions' => [
//            'source' => $ocpyarr,
            'source' => new JsExpression("function(request, response) {
                $.getJSON('searchoccupyby', {
                    id: request.term
                }, response);
            }"),
            'minLength'=>'2',
        ],
    ]) ?>

    <?= $form->field($model, 'invt_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'invt_contact')->textInput() ?>

    <?= $form->field($model, 'invt_buyfrom')->widget(\yii\jui\AutoComplete::classname(), [
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'เช่น บริษัท ปัตตานี โอเอ เซนเตอร์',
            'maxlength' => true,
        ],
        'clientOptions' => [
            'source' => $bfromarr,
        ],
    ]) ?>

    <?php
    echo $form->field($model, 'invt_buydate')->widget(DatePicker::classname(), [
        'language' => 'th',
        'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'invt_checkindate')->widget(DatePicker::classname(), [
        'language' => 'th',
        'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'invt_guarunteedateend')->widget(DatePicker::classname(), [
        'language' => 'th',
        'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'invt_takeoutdate')->widget(DatePicker::classname(), [
        'language' => 'th',
        'options' => ['placeholder' => Yii::t('kpi/app', 'enterdate')],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

	<?php	/* adzpire form tips
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
		*/ ?>
    <div class="form-group text-center">
        <?= Html::submitButton(Html::icon('floppy-disk').' '.Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton(Html::icon('share-alt').' '.Yii::t('app', 'บันทึกและคัดลอกต่อ'), ['class' => 'btn btn-default', 'name'=>'save&go']) ?>
        <?php if(!$model->isNewRecord){
		 echo Html::resetButton( Html::icon('refresh').' '.Yii::t('app', 'Reset') , ['class' => 'btn btn-warning']);
		 } ?>

	</div>

    <?php ActiveForm::end(); ?>
<?php
    Modal::begin([
        'header' => 'Quick Op',
        'id' => 'invttmodal',
    ]);
    echo '<div id ="invttmodalcontent"></div>';
    Modal::end();
?>
    <?php
$this->registerJs("
    $('._refreshlist').on('click', function(event){
    event.preventDefault();
        $.ajax({
          url:'".Url::to(['getlist', 'src' => 'invtt'])."',
          type:'POST',
          //dataType:'json',
          //data:data,
          success: function(result){
            //alert(result);
            $( 'select#invttlist' ).html( result );
        }
        });
    });
    $('._refreshloclist').on('click', function(event){
    event.preventDefault();
        $.ajax({
          url:'".Url::to(['getlist', 'src' => 'invtloc'])."',
          type:'POST',
          //dataType:'json',
          //data:data,
          success: function(result){
            //alert(result);
            $( 'select#invtloclist' ).html( result );
        }
        });
    });
    $('._invttqadd').on('click', function(event){
    event.preventDefault();
	$('#invttmodal').modal('show')
	.find('#invttmodalcontent')
	.load($(this).attr('value'));
        return false;//just to see what data is coming to js
    });

    $('._locqadd').on('click', function(event){
    event.preventDefault();
	$('#invttmodal').modal('show')
	.find('#invttmodalcontent')
	.load($(this).attr('value'));
        return false;//just to see what data is coming to js
    });

    $('._chngloc').on('click', function(event){
    event.preventDefault();
	$('#invttmodal').modal('show')
	.find('#invttmodalcontent')
	.load($(this).attr('value'));
        return false;
    });

    $('._chngstat').on('click', function(event){
    event.preventDefault();
	$('#invttmodal').modal('show')
	.find('#invttmodalcontent')
	.load($(this).attr('value'));
        return false;
    });/**/
", View::POS_END);
    ?>
</div>