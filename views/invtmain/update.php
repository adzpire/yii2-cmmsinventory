<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMain */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'Invt Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('inventory/app', 'Update');
?>
<div class="invt-main-update">

<div class="panel panel-warning">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('edit').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.Yii::t('inventory/app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => Yii::t('inventory/app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.Yii::t('inventory/app', 'createnew'), ['create'], ['class' => 'btn btn-info panbtn']) ?>
	</div>
	<div class="panel-body">
	<?= $this->render('_form', [
	  	'model' => $model,
		'invttarray' => $invttarray,
		'bdgttyparray' => $bdgttyparray,
		'invtstatarray' => $invtstatarray,
		'locarray' => $locarray,
		'brndarr' => $brndarr,
		'ocpyarr' => $ocpyarr,
		'bfromarr' => $bfromarr,
		'codearr' => $codearr,
	]) ?>
	</div>
</div>

</div>
