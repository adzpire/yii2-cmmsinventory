<?php

use yii\bootstrap\Html;
//use yii\grid\GridView;

use kartik\grid\GridView;

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
    <?= GridView::widget([
        //'id' => 'kv-grid-demo',
        'dataProvider' => $provider,
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
        'responsive' => true,
        'hover' => true,
        'toolbar' => false,
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => Html::icon('duplicate') . ' ' . Html::encode($this->title),
        ],
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
