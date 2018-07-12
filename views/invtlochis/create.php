<?php

use yii\bootstrap\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtLochistory */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'ย้ายสถานที่'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-lochistory-create">

    <div class="panel panel-primary">
		<div class="panel-heading">
			<span class="panel-title"><?= Html::icon('edit').' '.Html::encode($this->title) ?></span>
			<?= Html::a( Html::icon('list-alt').' '.Yii::t('inventory/app', 'รายการ'), ['index'], ['class' => 'btn btn-success panbtn']) ?>
		</div>
		<div class="panel-body">
		 <?= $this->render('_form', [
            'model' => $model,
            'locarray' => $locarray,
		 	'userlist' => $userlist,
		 ]) ?>
		</div>
	</div>

</div>
