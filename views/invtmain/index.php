<?php

use yii\bootstrap\Html;
use kartik\dynagrid\DynaGrid;

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

        [
            'attribute' => 'id',
            'width' => '50px',
        ],
        [
            'attribute' => 'invt_name',
        ],
        'invt_code',
        [
            'attribute' => 'tname',
            'value' => 'invtType.invt_tname',
            'label' => $searchModel->attributeLabels()['invt_typeID'],
            'filter'=> $filterT,
        ],
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
//            'invt_budgetyear',
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

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{create} {view} {update} {delete}',
            'buttons' => [
                'create' => function ($url, $model, $key) {
                    //return Html::a(Html::icon('duplicate'), $url);
                    return Html::a(Html::icon('duplicate'), $url);
                },
            ],
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
            'heading'=> Html::icon('phone-alt').' '.Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			'after' => false,			
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a(Html::icon('export').' บันทึกเป็น excel', '#', ['data-format' => 'application/vnd.ms-excel', 'data-pjax'=>0, 'class'=>'btn btn-success export-xls', 'title'=>Yii::t('app', 'บันทึกเป็น excel')]).' '.
                Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
            ],                   
            ['content'=>'{dynagrid}'],
            '{export}',
            '{toggleData}', 
		],
		
    ],
    'options'=>['id'=>'dynagrid-invtmindex'] // a unique identifier is important
]); ?>
    
</div>
