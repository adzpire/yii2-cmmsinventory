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
        ['label' => 'แจ้งซ่อม', 'icon' => 'wrench', 'url' => ['/ir/default/quickcreate', 'id' =>$id]],
        ['label' => 'ย้ายสถานที่', 'icon' => 'home', 'url' => ['invtlochis/create']],
        ['label' => 'เปลี่ยนสถานะ', 'icon' => 'stats', 'url' => ['invtstathis/create']],
        /*['label' => 'รายการพัสดุ', 'icon' => 'list', 'url' => 'invtmain/index'],
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