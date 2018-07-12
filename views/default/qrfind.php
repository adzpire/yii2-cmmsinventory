<?php

use yii\bootstrap\Html;
use kartik\dynagrid\DynaGrid;
use Da\QrCode\QrCode;
use Da\QrCode\Label;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= DynaGrid::widget([
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        // [
        //     'attribute' => 'id',
        //     'width' => '50px',
		// ],
		'invt_code',
        [
			'attribute' => 'invt_name',
			'filter' => false
        ],
        [
			'attribute' => 'invt_brand',
			'filter' => false
		],
		[
			'attribute' => 'invt_detail',
			'format' => 'ntext',
			'filter' => false
        ],
        [
			'attribute' => 'invt_name',
			'value' => function ($model, $key, $index, $column) {
                $label = (new Label($model->invt_code))->updateFontSize(8);
                // $label = '2amigos';
				$qrCode = (new QrCode(Url::to(['default/qrproc', 'id' => $model->id], true)))->setLabel($label)
				->setSize(130)->setMargin(5)->useForegroundColor(0, 0, 0);
				return $qrCode->writeDataUri();
			},
			'format' => ['image',['class' => 'img-thumbnail']],
			'label' => 'QR code',
			'filter' => false,
		],
        //'invt_statID',

        // 'invt_name',
        // 'invt_brand',
        // 'invt_detail:ntext',
        // 'invt_image',
        // 'invt_ppp',
        // 'invt_budgetyear',
        // 'invt_occupyby',
        // 'invt_note:ntext',
        // 'invt_contact',
        // 'invt_buyfrom',
        // 'invt_buydate',
        // 'invt_checkindate',
        // 'invt_guarunteedateend',
        // 'invt_takeoutdate',
        // 'invt_date',

        // [
        //     'class' => 'yii\grid\ActionColumn',
        //     'template' => '{create} {view} {update} {delete}',
        //     'buttons' => [
        //         'create' => function ($url, $model, $key) {
        //             //return Html::a(Html::icon('duplicate'), $url);
        //             return Html::a(Html::icon('duplicate'), $url);
        //         },
        //     ],
        //     'order'=>DynaGrid::ORDER_FIX_RIGHT,
        // ],
    ],	
    'theme'=>'panel-info',
    'showPersonalize'=>true,
	'storage' => 'session',
	'toggleButtonGrid' => [
		'label' => '<span class="glyphicon glyphicon-wrench">ปรับแต่งตาราง</span>'
	],
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        // 'showPageSummary'=>true,
        // 'floatHeader'=>true,
		'pjax'=>true,
		'hover'=>true,
		'pager' => [
			'firstPageLabel' => Yii::t('app', 'รายการแรกสุด'),
			'lastPageLabel' => Yii::t('app', 'รายการท้ายสุด'),
		],
		'resizableColumns'=>true,
        'responsiveWrap'=>false,
        'responsive'=>true,
        'panel'=>[
            'heading'=> Html::icon('tags').' '.Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			'after' => false,			
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a(Html::icon('plus').' เลือกชั่วคราว', ['selitem'], ['class'=>'btn btn-primary', 'title'=>Yii::t('app', 'เพิ่ม')]).' '.
                (!empty($qritem) ? Html::a(Html::icon('minus').' ยกเลิกการเลือกชั่วคราว', ['qrfind'], ['class'=>'btn btn-danger', 'id' => 'delButton', 'title'=>Yii::t('app', 'เพิ่ม'), 'data-pjax'=>0]) : false).' '.
                Html::a(Html::icon('export').' บันทึกเป็น pdf', '#', ['data-format' => 'application/pdf', 'data-pjax'=>0, 'class'=>'btn btn-success export-pdf', 'title'=>Yii::t('app', 'บันทึกเป็น pdf')])
            ],                   
            ['content'=>'{dynagrid}'],
            '{export}',
            '{toggleData}', 
		],		
    ],
    'options'=>['id'=>'dynagrid-invtmindex'] // a unique identifier is important
]); ?>
    
</div>
<?php
$this->registerJs("
$(document).on('click', '#delButton', function (e) {
    // e.preventDefault();    
    $.ajax({
        type: 'POST',
        url : ['delsession'],
        success : function(data) {
        //    alert(data);
            if(data == '') {
                alert('ลบเรียบร้อย');
            }
        }
    });
    // return false;
});
", View::POS_READY);

?>