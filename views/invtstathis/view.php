<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtStathistory */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'Invt Stathistories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-stathistory-view">

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
				'label' => $model->attributeLabels()['invt_ID'],
				'value' => $model->invt_ID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['invt_statID'],
				'value' => $model->invt_statID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['date'],
				'value' => $model->date,			
				//'format' => ['date', 'long']
			],
    	],
    ]) ?>
	</div>
</div>
</div>