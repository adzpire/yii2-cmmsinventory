<?php

use yii\bootstrap\Html;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-index">
    <?php //print_r($ivntarr);
    //print_r(array_keys($ivntarr, "วสส.06-004-3/500-59/ร"));
    //exit();
    ?>
<?= DynaGrid::widget([
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => [
                'width' => '100px',
            ],
        ],
        'id',
        [
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) use ($ivntarr) {
                if (!empty(array_keys($ivntarr, $data['id']))) {
                    return Html::a(Html::icon('duplicate') . ' มีซ้ำแล้ว คลิ้กเพื่ออัพเดต', ['update', 'id' => array_keys($ivntarr, $data['id'])[0]], ['class' => 'btn btn-danger']);
                } else {
                    return 'ใช้งานได้'; // $data['name'] for array data, e.g. using SqlDataProvider.
                }
            },
            'format' => 'raw',
            'headerOptions' => [
                'width' => '150px',
            ],
        ],
    ],	
    'theme'=>'panel-info',
    'showPersonalize'=>true,
	'storage' => 'session',
	'toggleButtonGrid' => [
		'label' => '<span class="glyphicon glyphicon-wrench">ปรับแต่งตาราง</span>'
	],
    'gridOptions'=>[
        'dataProvider'=>$provider,
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
            'heading' => Html::icon('duplicate') . ' ' . Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
			'after' => false,			
        ],
        'toolbar' =>  [                             
            ['content'=>'{dynagrid}'],
		],
		
    ],
    'options'=>['id'=>'dynagrid-invtbcheck'] // a unique identifier is important
]); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::icon('edit') . ' ' . Html::encode($this->title) ?></span>
            <?= Html::a(Html::icon('list-alt') . ' ' . Yii::t('inventory/app', 'entry'), ['index'], ['class' => 'btn btn-success panbtn']) ?>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'id' => $id,
                'model' => $model,
                'invttarray' => $invttarray,
                'bdgttyparray' => $bdgttyparray,
                'invtstatarray' => $invtstatarray,
                'locarray' => $locarray,
//                'brndarr' => $brndarr,
//                'ocpyarr' => $ocpyarr,
                'bfromarr' => $bfromarr,
//                'codearr' => $codearr,
            ]) ?>
        </div>
    </div>
</div>
