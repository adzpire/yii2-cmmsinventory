<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\FormInvttakeItems */

$this->params['breadcrumbs'][] = ['label' => 'หน้ารายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-invttake-items-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.'Delete', ['ลบ', 'id' => $model->ID], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูล?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.'แก้ไข', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary panbtn']) ?>
		<?= Html::a( Html::icon('open-file').' '.'สร้างใหม่', ['create'], ['class' => 'btn btn-info panbtn']) ?>
	</div>
	<div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
 			[
				'label' => $model->attributeLabels()['ID'],
				'value' => $model->ID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['finvttakemainID'],
				'value' => $model->finvttakemainID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['InvtID'],
				'value' => $model->InvtID,			
				//'format' => ['date', 'long']
			],
    	],
    ]) ?>
	</div>
</div>
</div>