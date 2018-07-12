<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Html;
use yii\helpers\Url;
use backend\components\Monav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use kartik\widgets\Growl;

//use kartik\nav\NavX;

AppAsset::register($this);

$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () {
    $("[data-toggle='tooltip']").on('click',function(e){
    e.preventDefault();
  }).tooltip();
});
/* To initialize BS3 popovers set this below */
$(function () {
    $("[data-toggle='popover']").on('click',function(e){
    e.preventDefault();
  }).popover();
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
    $this->registerCssFile("/uploads/adzpireImages/AdzpireCSS.css", [
        'depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
    ?>
</head>
<body style="margin-top: 0px;">
<?php $this->beginBody() ?>
<?php $modul = \Yii::$app->controller->module; ?>
<?php
$this->registerLinkTag([
    //'title' => 'Live News for Yii',
    'rel' => 'shortcut icon',
    'type' => 'image/x-icon',
    'href' => '/media/commsci.ico',
]);
?>
<div class="wrap mywrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img class="cmmslogo" alt="Brand" src="' . '/media/parallax/img/commsci_logo_black.png' . '">' . '<table class="navtablelogo"><tbody>
		  <tr><td>' . Yii::t($modul->id . '/app', 'ระบบข้อมูลพัสดุ/ครุภัณฑ์') . '</td></tr>
		  <tr style="font-size: small;"><td>' . Yii::t($modul->id . '/app', 'ระบบข้อมูลพัสดุ/ครุภัณฑ์ คณะวิทยาการสื่อสาร') . '</td></tr>
		  </tbody></table>',
        'brandUrl' => Url::toRoute('/' . $modul->id),
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-default',
        ],
    ]);
    $menuItems = [
//        ['label' => Html::Icon('plus') . ' ' . Yii::t($modul->id . '/app', 'เพิ่มข้อมูลใหม่'), 'url' => ['invtmain/create']],
        [
            'label' => Html::Icon('plus') . ' ' . Yii::t($modul->id . '/app', 'เพิ่มข้อมูลใหม่'),
            'url' => ['#'],
            'items' => [
                ['label' => Html::Icon('save-file') . ' ' . Yii::t($modul->id . '/app', 'รายการเดียว'), 'url' => ['/inventory/invtmain/create']],
                ['label' => Html::Icon('duplicate') . ' ' . Yii::t($modul->id . '/app', 'หลายรายการ'), 'url' => ['/inventory/invtmain/createbatch']],
//                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($modul->id . '/app', 'รายการประวัติสถานที่'), 'url' => ['/inventory/invtlochis']],
//                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($modul->id . '/app', 'รายการประวัติสถานะ'), 'url' => ['/inventory/invtstathis']],
            ]
        ],
        [
            'label' => Html::Icon('transfer') . ' ' . Yii::t($modul->id . '/app', 'เปลี่ยน/ย้าย'),
            'url' => ['#'],
            'items' => [
                ['label' => Html::Icon('home') . ' ' . Yii::t($modul->id . '/app', 'ย้ายสถานที่'), 'url' => ['/inventory/invtlochis/create']],
                ['label' => Html::Icon('stats') . ' ' . Yii::t($modul->id . '/app', 'เปลี่ยนสถานะ'), 'url' => ['/inventory/invtstathis/create']],
                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($modul->id . '/app', 'รายการประวัติสถานที่'), 'url' => ['/inventory/invtlochis']],
                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($modul->id . '/app', 'รายการประวัติสถานะ'), 'url' => ['/inventory/invtstathis']],
            ]
        ],
        //['label' => Yii::t( $modul->id.'/app', 'lochistory'), 'url' => ['wru/create'],  'options' => ['class' => 'disabled']],
        [
            'label' => Html::Icon('fullscreen') . ' ' . Yii::t('app', 'ระบบที่เกี่ยวข้อง'),
            'url' => ['#'],
            'items' => [
                ['label' => Html::Icon('folder-open') . ' ' . Yii::t('app', 'ระบบเอกสารและแบบฟอร์มออนไลน์'), 'url' => ['/dochub']],
                ['label' => Html::Icon('check') . ' ' . Yii::t('app', 'ระบบตรวจสอบวัสดุครุภัณฑ์ประจำปี'), 'url' => ['/iac']],
            ]
        ],
        ['label' => Html::Icon('folder-open') . ' ' . Yii::t($modul->id . '/app', 'รายงาน'), 'url' => Url::current(), 'options' => ['class' => 'disabled']],
//        [
//            'label' => Html::Icon('bookmark') . ' ' . Yii::t($modul->id . '/app', 'ข้อมูล'),
//            'url' => ['#'],
//            'items' => [
//                ['label' => Html::Icon('play') . ' ' . Yii::t($modul->id . '/app', 'Invt Mains')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'add'), 'url' => ['/inventory/invtmain/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'index'), 'url' => ['/inventory/invtmain']],
//                '<li class="divider"></li>',
//                //['label' => Yii::t( $modul->id.'/app', 'Invt Mains'), 'url' => ['/inventory/invtmain']],
//                //['label' => Yii::t( $modul->id.'/app', 'Invt Budgettypes'), 'url' => ['/inventory/invtbdgt']],
//                ['label' => Html::Icon('bitcoin') . ' ' . Yii::t($modul->id . '/app', 'Invt Budgettypes')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), 'url' => ['/inventory/invtbdgt/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), 'url' => ['/inventory/invtbdgt']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('stats') . ' ' . Yii::t($modul->id . '/app', 'Invt Statuses')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), 'url' => ['/inventory/invtstat/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), 'url' => ['/inventory/invtstat']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('tag') . ' ' . Yii::t($modul->id . '/app', 'Invt Types')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), 'url' => ['/inventory/invttype/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), 'url' => ['/inventory/invttype']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('home') . ' ' . Yii::t($modul->id . '/app', 'Main Locations')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), 'url' => ['/inventory/loc/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), 'url' => ['/inventory/loc']],
//                '<li class="divider"></li>',
//            ]
//        ],
        '
        <li class="dropdown menu-large">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::Icon('bookmark') . ' ' . Yii::t($modul->id . '/app', 'ข้อมูล').'<span class="caret caret-right"></span></a>
        <ul class="dropdown-menu megamenu row">
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('play') . ' ' . Yii::t($modul->id . '/app', 'พัสดุ/ครุภัณฑ์').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), ['/inventory/invtmain/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), ['/inventory/invtmain']).'</li>
                </ul>
                <ul>
                    <li class="dropdown-header">'.Html::Icon('home') . ' ' . Yii::t($modul->id . '/app', 'สถานที่').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), ['/location/loc/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), ['/location/loc']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('bitcoin') . ' ' . Yii::t($modul->id . '/app', 'ประเภทเงินพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), ['/inventory/invtbdgt/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), ['/inventory/invtbdgt']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('stats') . ' ' . Yii::t($modul->id . '/app', 'สถานะพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), ['/inventory/invtstat/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), ['/inventory/invtstat']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('tag') . ' ' . Yii::t($modul->id . '/app', 'ประเภทพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'เพิ่ม'), ['/inventory/invttype/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($modul->id . '/app', 'รายการ'), ['/inventory/invttype']).'</li>
                </ul>
            </li>
        </ul>
        </li>
        ',
        ['label' => Html::Icon('info-sign') . ' ' . Yii::t($modul->id . '/app', 'คำแนะนำการใช้'), 'url' => ['default/readme']],
    ];
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => Yii::t( $modul->id.'/app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems1[] = ['label' => Html::Icon('log-in') . ' ' . Yii::t($modul->id . '/app', 'เข้าสู่ระบบ'), 'url' => Yii::$app->user->loginUrl];
    } else {
        $menuItems1[] = [
            'label' => Html::Icon('option-horizontal') . ' ' . Yii::t($modul->id . '/app', 'อื่นๆ'),
                'url' => ['#'],
                'items' =>
                    //['label' => Html::Icon('dashboard') . ' ' . Yii::t($modul->id . '/app', 'office'), 'url' => ['/']],
                    [
                        '<li>'
                        .Html::a(Html::Icon('dashboard') . ' ' . Yii::t($modul->id . '/app', 'office') , ['/'])
                        .'</li>',
                        '<li>'
                        . Html::a(Html::Icon('globe') . ' ' . Yii::t('app', 'หน้าเว็บไซต์หลัก'), '/')
                        . '</li>',
                        '<li>'
                        . Html::beginForm(['/site/logout', 'url' => Url::current()], 'post')
                        . Html::submitButton(
                            Html::Icon('log-out') . ' ' . Yii::t($modul->id . '/app', 'ออกจากระบบ') . ' (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link']
                        )
                        . Html::endForm()
                        . '</li>',
                    ],
            ];
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout', 'url' => Url::current()], 'post')
//            . Html::submitButton(
//                Html::Icon('log-out') . ' ' . Yii::t($modul->id . '/app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link']
//            )
//            . Html::endForm()
//            . '</li>';
    }
    echo Monav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    echo Monav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems1,
    ]);
    NavBar::end();
    ?>
    <div class="container-fluid">
        <?php
        $cookies = Yii::$app->request->cookies;

        if (($cookie = $cookies->get($modul->params['modulecookies'])) !== null) {
            if ($cookie->value != $modul->params['ModuleVers']) {
                $delcookies = Yii::$app->response->cookies;
                $delcookies->remove($modul->params['modulecookies']);
            }
        } else {
            if(\Yii::$app->controller->action->id != 'changelog') {
                echo $this->render('/_version');
            }
        }
        ?>

        <?= Breadcrumbs::widget([
            'encodeLabels' => false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => Html::Icon('home'),
                'url' => Url::toRoute('/' . $modul->id),
            ],
        ]) ?>
        <?= Alert::widget() ?>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                //'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'center',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
        <?= $content ?>
        <?php /*if(isset($this->blocks['block1'])){
			$this->blocks['block1'];
		 }else{
			echo 'no block';
		 }*/ ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p>© 2016 - <?php echo date('Y'); ?> PSU YII DEV <span class="label label-danger"><?php echo $modul->params['ModuleVers']; ?></span>
            <?php echo '  '.Yii::t( 'app', 'พบปัญหาในการใช้งาน ติดต่อ - ').Html::icon('envelope'); ?> :  <?php echo Html::mailto('อับดุลอาซิส ดือราแม', 'abdul-aziz.d@psu.ac.th'); ?><?php echo ' '.Html::icon('earphone').' : '.Yii::t( 'app', 'โทรศัพท์ภายใน : 2618'); ?>
            <a href="#" data-toggle="tooltip" title="<?php echo Yii::t( 'app', 'responsive_web'); ?>"><img src="<?php echo '/uploads/adzpireImages/responsive-icon.png'; ?>" width="30" height="30" /></a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
