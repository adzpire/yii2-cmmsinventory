<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMain */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'Invt Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.Yii::t('inventory/app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => Yii::t('inventory/app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.Yii::t('inventory/app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary panbtn']) ?>
	</div>
	<div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
 			[
				'label' => $model->attributeLabels()['id'],
				'value' => $model->id,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_locationID'],
				'value' => $model->invtLocation->loc_name,
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_typeID'],
				'value' => $model->invtType->invt_tname,
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_bdgttypID'],
				'value' => $model->invtBdgttyp->invt_bname,
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_statID'],
				'value' => $model->invtStat->invt_sname,
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_code'],
				'value' => $model->invt_code,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_name'],
				'value' => $model->invt_name,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_brand'],
				'value' => $model->invt_brand,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_detail'],
				'value' => $model->invt_detail,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_image'],
				'value' => '/uploads/inventory_files/'.$model->invt_image,
				'format' => ['image',['width' => '100%']]
			],
     			[
				'label' => $model->attributeLabels()['invt_ppp'],
				'value' => $model->invt_ppp,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_budgetyear'],
				'value' => $model->invt_budgetyear,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_occupyby'],
				'value' => $model->invt_occupyby,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_note'],
				'value' => $model->invt_note,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_contact'],
				'value' => $model->invt_contact,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_buyfrom'],
				'value' => $model->invt_buyfrom,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_buydate'],
				'value' => $model->invt_buydate,			
				'format' => ['date']
			],
     			[
				'label' => $model->attributeLabels()['invt_checkindate'],
				'value' => $model->invt_checkindate,			
				'format' => ['date']
			],
     			[
				'label' => $model->attributeLabels()['invt_guarunteedateend'],
				'value' => $model->invt_guarunteedateend,			
				'format' => ['date']
			],
     			[
				'label' => $model->attributeLabels()['invt_takeoutdate'],
				'value' => $model->invt_takeoutdate,			
				'format' => ['date']
			],
     			[
				'label' => $model->attributeLabels()['created_at'],
				'value' => $model->created_at,
				'format' => ['datetime']
			],
    	],
    ]) ?>
	</div>
</div>
</div>