<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;
use kartik\dynagrid\DynaGrid;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\FormInvttakeMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
.grid-view td {
    white-space: unset;
}
');
?>
<div class="form-invttake-main-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?= DynaGrid::widget([
    'columns' => [
		//['class' => 'yii\grid\SerialColumn'],

		[
			'attribute' => 'ID',
			'headerOptions' => [
				'width' => '50px',
			],
		],
		[
			'attribute' => 'staffID',
			'value' => 'staff.fullname',
			'label' => 'ผู้ขอ',
		],
		[
			'attribute' => 'LocationID',
			'value' => 'location.loc_name',
			'label' => 'สถานที่ใช้',
		],
		[
			'attribute' => 'date',
			'format' => ['date'],
		],
			[
				'class' => 'yii\grid\ActionColumn',
				'buttons' => [
					'view' => function ($url, $model, $key) {
							return Html::a(Html::icon('eye-open'), $url, ['class' => 'text-success', 'data-pjax' => 0, 'title'=>'แก้ไข']);
					},
					'delete' => function ($url, $model, $key) {
							return Html::a(Html::icon('trash'), $url, ['class' => 'text-danger', 'data-pjax' => 0]);
					},
				],
				'headerOptions' => [
					'width' => '70px',
				],
				'order'=>DynaGrid::ORDER_FIX_RIGHT,
				/*'visibleButtons' => [
					'view' => Yii::$app->user->id == 122,
					'update' => Yii::$app->user->id == 19,
					'delete' => function ($model, $key, $index) {
									return $model->status === 1 ? false : true;
								}
					],
				'visible' => Yii::$app->user->id == 19,*/
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
            'heading'=> Html::icon('tags').' '.Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			'after' => false,			
        ],
        'toolbar' =>  [
            ['content'=>
				Html::a(Html::icon('plus').' สร้างใหม่', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'เพิ่ม')]).' '.
                Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
            ],                   
            ['content'=>'{dynagrid}'],
            '{export}',
            '{toggleData}', 
		],
		
    ],
    'options'=>['id'=>'dynagrid-invttakeindex'] // a unique identifier is important
]); ?>

</div>
