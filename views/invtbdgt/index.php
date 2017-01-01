<?php

use yii\bootstrap\Html;
//use yii\grid\GridView;

use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtBudgettypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-budgettype-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
		//'id' => 'kv-grid-demo',
		'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => '50px',
                ]
            ],
            'invt_bname',
            'invt_bdetail:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => [
                    'width' => '50px',
                ]
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
		'pager' => [
			'firstPageLabel' => Yii::t('inventory/app', '1stPagi'),
			'lastPageLabel' => Yii::t('inventory/app', 'lastPagi'),
		],
		'responsive'=>true,
		'hover'=>true,
		'toolbar'=> [
			['content'=>
				Html::a(Html::icon('plus'), ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('kpi/app', 'Add Book')]).' '.
				Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('kpi/app', 'Reset Grid')])
			],
			//'{export}',
			'{toggleData}',
		],
		'panel'=>[
			'type'=>GridView::TYPE_INFO,
			'heading'=> Html::icon('bitcoin').' '.Html::encode($this->title),
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
