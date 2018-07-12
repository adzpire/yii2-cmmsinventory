<?php

use yii\bootstrap\Html;
use kartik\dynagrid\DynaGrid;
use Da\QrCode\QrCode;
use Da\QrCode\Label;
use yii\helpers\Url;
use yii\web\View;
/* @var $this  */
/* @var $searchModel backend\modules\inventory\models\InvtMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-index">

    <?php print_r($qritem); ?>
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        //return Html::a(Html::icon('duplicate'), $url);
                        return Html::a(Html::icon('eye-open'), ['invtmain/view', 'id' => $key]);
                    },
                ],
            //     'order'=>DynaGrid::ORDER_FIX_RIGHT,
        ],
        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function($model, $key, $index, $column) use ($qritem) {
                if(!empty($qritem)){
                    $bool = in_array($model->id, $qritem); 
                    return ['checked' => $bool];
                }
            }
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
                Html::a(Html::icon('plus').' เพิ่มชั่วคราว', Url::current(), ['class'=>'btn btn-primary', 'id' => 'addButton', 'title'=>Yii::t('app', 'เพิ่ม'), 'data-pjax'=>0]).' '.
                (!empty($qritem) ? Html::a(Html::icon('minus').' ยกเลิกการเลือกชั่วคราว', ['#'], ['class'=>'btn btn-danger', 'id' => 'delButton', 'title'=>Yii::t('app', 'เพิ่ม'), 'data-pjax'=>0]).' '.
                 Html::a(Html::icon('print').' พิมพ์ที่เลือก', ['qrfind'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'เพิ่ม'), 'data-pjax'=>0]) : false)
            ],                   
            //['content'=>'{dynagrid}'],
            //'{export}',
            '{toggleData}', 
        ],		
        'id' => 'kv-grid-demo',
    ],
    'options'=>['id'=>'dynagrid-invtmindex'] // a unique identifier is important
]); ?>
    
</div>
<?php
$this->registerJs("
$(document).on('click', '#addButton', function (e) {
    // e.preventDefault();
    var HotId = $('#kv-grid-demo').yiiGridView('getSelectedRows');
    if(HotId.length > 0){
        $.ajax({
            type: 'POST',
            url : ['addsession'],
            data : {row_id: HotId},
            success : function(data) {
            //    alert(data);
                if(data == '') {
                    alert('บันทึกเรียบร้อย');
                    // $.pjax.reload({container:'#apprpjax'});
                }else{
                    alert('save error');
                }
            }
        });
    }else{
       alert('empty');
    }
    // return false;
});
$(document).on('click', '#delButton', function (e) {
    e.preventDefault();    
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
    return false;
});
", View::POS_READY);

?>