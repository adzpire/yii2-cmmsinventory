<?php

use yii\bootstrap\Html;
//use yii\grid\GridView;

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        //'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'width' => '50px',
            ],
            [
                'attribute' => 'invt_name',
            ],
            [
                'attribute' => 'tname',
                'value' => 'invtType.invt_tname',
                'label' => $searchModel->attributeLabels()['invt_typeID'],
            ],
            [
                'attribute' => 'lname',
                'value' => 'invtLocation.loc_name',
                'label' => $searchModel->attributeLabels()['invt_locationID'],
            ],
            [
                'attribute' => 'sname',
                'value' => 'invtStat.invt_sname',
                'label' => $searchModel->attributeLabels()['invt_statID'],
            ],
            'invt_budgetyear',
            //'invt_statID',
            // 'invt_code',
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
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create}',
                'buttons' => [
                    'create' => function ($url, $model, $key) {
                        //return Html::a(Html::icon('duplicate'), $url);
                        return Html::a(Html::icon('duplicate'), $url);
                    },
                ],
                //'header' => 'รับทราบ',
            ],
        ],
        'pager' => [
            'firstPageLabel' => Yii::t('inventory/app', 'รายการแรกสุก'),
            'lastPageLabel' => Yii::t('inventory/app', 'รายการท้ายสุด'),
        ],
        'responsive' => true,
        'hover' => true,
        'toolbar' => [
            ['content' =>
                Html::a(Html::icon('plus'), ['create'], ['class' => 'btn btn-success', 'title' => Yii::t('kpi/app', 'Add Book')]) . ' ' .
                Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kpi/app', 'Reset Grid')])
            ],
            //'{export}',
            '{toggleData}',
        ],
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => Html::icon('user') . ' ' . Html::encode($this->title),
        ],
    ]); ?>
    <?php /* adzpire grid tips
		[
		'attribute' => 'we_date',
		'value' => 'we_date',
			'filter' => \yii\jui\DatePicker::widget([
				'model'=>$searchModel,
				'attribute'=>'we_date',
				//'language' => 'ru',
				'dateFormat' => 'yyyy-M-dd',
				'options' => [
					'class' => 'form-control',
					'placeholder' => 'choose date...'
				]
			]),
			//'format' => 'html',			
			'format' => ['date']

		],	
		[
			'attribute' => 'we_creator',
			'value' => 'weCr.userPro.nameconcatened'
		],
	 */
    ?>
    <?php Pjax::end(); ?>
</div>
