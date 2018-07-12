<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\web\View;
use kartik\dynagrid\DynaGrid;
use yii\widgets\Pjax;
/* @var $this  */
/* @var $model backend\modules\inventory\models\FormInvttakeMain */

$this->params['breadcrumbs'][] = ['label' => 'หน้ารายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'อัพเดต';
$this->registerCss('
.grid-view td {
    white-space: unset;
}
');

?>
    <div class="panel panel-warning">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::icon('edit').' ข้อมูลเบื้องต้น' ?></span>
        </div>
        <div class="panel-body">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'staffID',
                        'label' => 'ข้าพเจ้า',
                        'value' => $model->staff->fullname,
                        //'format' => ['date', 'long']
                    ],
                    [
                        'attribute' => 'LocationID',
                        'label' => 'ขอเบิกสิ่งของไปที่',
                        'value' => $model->location->loc_name,
                        //'format' => ['date', 'long']
                    ],
                    [
                        'attribute' => 'date',
                        'label' => $model->attributeLabels()['date'],
                        'format' => 'date',
                    ],
                ],
            ]);
            echo '<div class="text-center">'.Html::a( Html::icon('list-alt').'แก้ไขผู้ขอ', ['update', 'id' => $model->ID], ['class' => 'btn btn-default']).'</div>';
            ?>
        </div>
    </div>

<?php Pjax::begin(['id' => 'itempjax']); ?>
<?= DynaGrid::widget([
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
//                'InvtID',
        [
            'attribute' => 'invt.shortdetail',
            'label' => 'ชื่อสิ่งของ',
        ],
        'invt.invt_code',
        [
            'attribute' => 'invt.invtLocation.loc_name',
            'label' => 'สถานที่',
        ],
        [
            'class' => 'kartik\grid\CheckboxColumn',
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
        ],
    ],	
    'theme'=>'panel-primary',
    'showPersonalize'=>true,
	'storage' => 'session',
	'toggleButtonGrid' => [
		'label' => '<span class="glyphicon glyphicon-wrench">ปรับแต่งตาราง</span>'
	],
    'gridOptions'=>[
        'dataProvider'=> $checkdataProvider,
        'filterModel' => $checkModel,
        'id' => 'kv-grid-demo2',
        // 'floatHeader'=>true,
		// 'pjax'=>true,
		'hover'=>true,
		'pager' => [
			'firstPageLabel' => Yii::t('app', 'รายการแรกสุด'),
			'lastPageLabel' => Yii::t('app', 'รายการท้ายสุด'),
		],
		'resizableColumns'=>true,
        'responsiveWrap'=>false,
        'responsive'=>true,
        'panel'=>[
            'heading'=> Html::icon('play').' '.Html::encode('เลือกรายการสิ่งของที่ต้องการเบิก'),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			'after'=> '<div class="text-center">'.Html::a(Html::icon('print') . ' ' . Yii::t('app', 'พิมพ์แบบฟอร์ม'), ['pdf', 'id' => $model->ID], ['class' => 'btn btn-info', 'data-pjax' => 0]).'</div>',
        ],
        'toolbar' =>  [
            ['content' =>
                    Html::a(Html::icon('minus') . ' ' . Yii::t('app', 'ลบที่เลือก'), ['#'], ['class' => 'btn btn-danger', 'id' => 'delButton', 'data-pjax' => 0])
                ],                  
            ['content'=>'{dynagrid}'],
		],
		
    ],
    'options'=>['id'=>'dynagrid-invttakedetial1'] // a unique identifier is important
]); ?>
<?= DynaGrid::widget([
    'columns' => [
        //                'id',
                    [
                        'attribute' => 'invt_name',
                    ],
                    'attribute' => 'invt_code',
                    [
                        'attribute' => 'lname',
                        'value' => 'invtLocation.loc_name',
                        'label' => $searchModel->attributeLabels()['invt_locationID'],
                        'filter'=> $filterL,
                    ],
                    [
                        'attribute' => 'sname',
                        'value' => 'invtStat.invt_sname',
                        'label' => $searchModel->attributeLabels()['invt_statID'],
                        'filter'=> $filterS,
                    ],
                    [
                        'attribute' => 'invt_budgetyear',
                        'value' => function($model){
                            return $model->invt_budgetyear.' <span class="text-danger">('.($model->invt_budgetyear+543).')</span>';
                        },
                        'format' => 'html',
                    ],
                    'invt_occupyby',
        
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'order'=>DynaGrid::ORDER_FIX_RIGHT,
                    ],
                ],	
    'theme'=>'panel-info',
    'showPersonalize'=>true,
	'storage' => 'session',
	'toggleButtonGrid' => [
		'label' => '<span class="glyphicon glyphicon-wrench">ปรับแต่งตาราง</span>'
	],
    'gridOptions'=>[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'kv-grid-demo',
        // 'floatHeader'=>true,
		// 'pjax'=>true,
		'hover'=>true,
		'pager' => [
			'firstPageLabel' => Yii::t('app', 'รายการแรกสุด'),
			'lastPageLabel' => Yii::t('app', 'รายการท้ายสุด'),
		],
		'resizableColumns'=>true,
        'responsiveWrap'=>false,
        'responsive'=>true,
        'panel'=>[
            'heading' => Html::icon('tags') . ' รายการสิ่งของ',
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			],
        'toolbar' =>  [
            ['content' =>
                Html::a(Html::icon('plus') . ' ' . Yii::t('app', 'บันทึกที่เลือก'), ['#'], ['class' => 'btn btn-success', 'id' => 'addButton', 'data-pjax' => 0])
            ],                 
            ['content'=>'{dynagrid}'],
		],
		
    ],
    'options'=>['id'=>'dynagrid-invttakedetial2'] // a unique identifier is important
]); ?>
<?php Pjax::end(); ?>
<?php

$this->registerJs("
$(document).on('click', '#addButton', function (e) {
    e.preventDefault();
    var HotId = $('#kv-grid-demo').yiiGridView('getSelectedRows');
    if(HotId.length > 0){
        $.ajax({
            type: 'POST',
            url : ['seladd'],
            data : {row_id: HotId, id: ".$model->ID."},
            success : function(data) {
                if($('#itempjax').length == 0) {
                    alert('nooooo');
                }else{
                    alert('เรียบร้อย');
                    $.pjax.reload({container:'#itempjax'});
                }
            }
        });
    }else{
       alert('empty');
    }
});
$(document).on('click', '#delButton', function (e) {
    e.preventDefault();
    var HotId = $('#kv-grid-demo2').yiiGridView('getSelectedRows');
    if(HotId.length > 0){
        $.ajax({
            type: 'POST',
            url : ['delinvtlist'],
            data : {row_id: HotId},
            success : function(data) {
                if($('#itempjax').length == 0) {
                    alert('nooooo');
                }else{
                    alert('เรียบร้อย');
                    $.pjax.reload({container:'#itempjax'});
                }
            }
        });
    }else{
       alert('empty');
    }
});
", View::POS_READY);

?>