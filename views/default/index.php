<?php
use backend\components\PanelLinkWidget;
use yii\helpers\Url;
use yii\bootstrap\Html;

?>
<?= PanelLinkWidget::widget([
    'setdiv' => [
        'divwidth' => 'col-lg-2 col-sm-3',
        //'divoffset' => 'col-sm-offset-1 col-lg-offset-2',
    ],
    'items' => [
        ['label' => 'สร้างพัสดุใหม่', 'icon' => 'plus-sign', 'url' => 'invtmain/create'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        /*['label' => 'สร้างพัสดุใหม่', 'icon' => 'plus-sign', 'url' => 'invtmain/create'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'สร้างพัสดุใหม่', 'icon' => 'plus-sign', 'url' => 'invtmain/create'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
        ['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],*/
    ],
]); ?>