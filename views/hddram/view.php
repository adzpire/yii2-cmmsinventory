<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtHddram */

$this->params['breadcrumbs'][] = ['label' => 'หน้ารายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-hddram-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.'Delete', ['ลบ', 'id' => $model->id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูล?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.'แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary panbtn']) ?>
		<?= Html::a( Html::icon('open-file').' '.'สร้างใหม่', ['create'], ['class' => 'btn btn-info panbtn']) ?>
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
				'label' => $model->attributeLabels()['invt_id'],
				'value' => $model->invt_id,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['hdd_exist'],
				'value' => $model->hdd_exist,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ram_exist'],
				'value' => $model->ram_exist,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['comment'],
				'value' => $model->comment,			
				//'format' => ['date', 'long']
			],
    	],
    ]) ?>
	</div>
</div>
</div>