<?php

use yii\bootstrap\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtMain */

$this->params['breadcrumbs'][] = ['label' => Yii::t('inventory/app', 'Invt Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-main-create">

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
                'brndarr' => $brndarr,
                'ocpyarr' => $ocpyarr,
                'bfromarr' => $bfromarr,
                'codearr' => $codearr,
            ]) ?>
        </div>
    </div>

</div>
