<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
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
    $this->registerCss("
		.wrap > .container {
			 padding: 0px 15px 20px;
		}
		.cmmslogo{
			align-content: left;
			width: 45px;
			padding: 3px;
		}
		.navtablelogo{
			float:right;
		}
		.navbar-brand {
			 padding: 2px 15px;
		}
		.navbar-brand > img {
			 display: inline;
		}
		.breadcrumb>li+li:before {
            content:\"»\";
        }
		/* PADDING VERTICAL */
		.padding-v-xxs {
		padding-top: 5px;
		padding-bottom: 5px;
		}
		.padding-v-xs {
		padding-top: 10px;
		padding-bottom: 10px;
		}
		.padding-v-base {
		padding-top: 15px;
		padding-bottom: 15px;
		}
		.padding-v-md {
		padding-top: 20px;
		padding-bottom: 20px;
		}
		.padding-v-lg {
		padding-top: 30px;
		padding-bottom: 30px;
		}
		.line {
		width: 100%;
		height: 2px;
		margin: 10px 0;
		overflow: hidden;
		font-size: 0;
		}
		.line-xs {
		margin: 0;
		}
		.line-lg {
		margin-top: 15px;
		margin-bottom: 15px;
		}
		.line-dashed {
		background-color: transparent;
		border-bottom: 1px dashed #dee5e7 !important;
		}
		div.required label:after{
			content: \" *\";
			color: red;
		}
		.panbtn{
			float:right;
			margin: -5px 5px 0px 0px;
		}
		.media a{
			color: black;
			text-decoration: none;
		}
		.media:hover {
          background-color: #f5f5f5;
        }
        .menu-large {
            position: static !important;
        }
        .megamenu{
            padding: 20px 0px;
            width:100%;
        }
        .megamenu> li > ul {
            padding: 0;
            margin: 0;
        }
        .megamenu> li > ul > li {
            list-style: none;
        }
        .megamenu> li > ul > li > a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.428571429;
            color: #333333;
            white-space: normal;
        }
        .megamenu> li ul > li > a:hover,
        .megamenu> li ul > li > a:focus {
            text-decoration: none;
            color: #262626;
            background-color: #f5f5f5;
        }
        .megamenu.disabled > a,
        .megamenu.disabled > a:hover,
        .megamenu.disabled > a:focus {
            color: #999999;
        }
        .megamenu.disabled > a:hover,
        .megamenu.disabled > a:focus {
            text-decoration: none;
            background-color: transparent;
            background-image: none;
            filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
            cursor: not-allowed;
        }
        .megamenu.dropdown-header {
            color: #428bca;
            font-size: 18px;
        }
        @media (max-width: 768px) {
            .megamenu{
                margin-left: 0 ;
                margin-right: 0 ;
            }
            .megamenu> li {
                margin-bottom: 30px;
            }
            .megamenu> li:last-child {
                margin-bottom: 0;
            }
            .megamenu.dropdown-header {
                padding: 3px 15px !important;

            }
            .navbar-nav .open .dropdown-menu .dropdown-header{
                color:#fff;
            }
        }
        .alert-custom {
            color: #a15426;
            background-color: #ffffff;
            border: 1px solid #a15426;
        }
     ");
    ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php $moduleID = \Yii::$app->controller->module->id;
//print_r($module->id);
?>
<?php
$this->registerLinkTag([
    //'title' => 'Live News for Yii',
    'rel' => 'shortcut icon',
    'type' => 'image/x-icon',
    'href' => '/media/commsci.ico',
]);
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img class="cmmslogo" alt="Brand" src="' . '/media/parallax/img/commsci_logo_black.png' . '">' . '<table class="navtablelogo"><tbody>
		  <tr><td>' . Yii::t($moduleID . '/app', 'ระบบข้อมูลพัสดุ/ครุภัณฑ์') . '</td></tr>
		  <tr style="font-size: small;"><td>' . Yii::t($moduleID . '/app', 'ระบบข้อมูลพัสดุ/ครุภัณฑ์ คณะวิทยาการสื่อสาร') . '</td></tr>
		  </tbody></table>',
        'brandUrl' => Url::toRoute('/' . $moduleID),
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-default',
        ],
    ]);
    $menuItems = [
        ['label' => Html::Icon('plus') . ' ' . Yii::t($moduleID . '/app', 'เพิ่มข้อมูลใหม่'), 'url' => ['invtmain/create']],
        [
            'label' => Html::Icon('transfer') . ' ' . Yii::t($moduleID . '/app', 'เปลี่ยน/ย้าย'),
            'url' => ['#'],
            'items' => [
                ['label' => Html::Icon('home') . ' ' . Yii::t($moduleID . '/app', 'ย้ายสถานที่'), 'url' => ['/inventory/invtlochis/create']],
                ['label' => Html::Icon('stats') . ' ' . Yii::t($moduleID . '/app', 'เปลี่ยนสถานะ'), 'url' => ['/inventory/invtstathis/create']],
                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($moduleID . '/app', 'รายการประวัติสถานที่'), 'url' => ['/inventory/invtlochis']],
                ['label' => Html::Icon('resize-horizontal') . ' ' . Yii::t($moduleID . '/app', 'รายการประวัติสถานะ'), 'url' => ['/inventory/invtstathis']],
            ]
        ],
        //['label' => Yii::t( $moduleID.'/app', 'lochistory'), 'url' => ['wru/create'],  'options' => ['class' => 'disabled']],
        [
            'label' => Html::Icon('fullscreen') . ' ' . Yii::t('app', 'ระบบที่เกี่ยวข้อง'),
            'url' => ['#'],
            'items' => [
                ['label' => Html::Icon('scissors') . ' ' . Yii::t('app', 'ระบบเอกสารและแบบฟอร์มออนไลน์'), 'url' => ['/dochub']],
                ['label' => Html::Icon('check') . ' ' . Yii::t('app', 'ระบบตรวจสอบวัสดุครุภัณฑ์ประจำปี'), 'url' => ['/iac']],
            ]
        ],
        ['label' => Html::Icon('folder-open') . ' ' . Yii::t($moduleID . '/app', 'รายงาน'), 'url' => Url::current(), 'options' => ['class' => 'disabled']],
//        [
//            'label' => Html::Icon('bookmark') . ' ' . Yii::t($moduleID . '/app', 'ข้อมูล'),
//            'url' => ['#'],
//            'items' => [
//                ['label' => Html::Icon('play') . ' ' . Yii::t($moduleID . '/app', 'Invt Mains')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'add'), 'url' => ['/inventory/invtmain/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'index'), 'url' => ['/inventory/invtmain']],
//                '<li class="divider"></li>',
//                //['label' => Yii::t( $moduleID.'/app', 'Invt Mains'), 'url' => ['/inventory/invtmain']],
//                //['label' => Yii::t( $moduleID.'/app', 'Invt Budgettypes'), 'url' => ['/inventory/invtbdgt']],
//                ['label' => Html::Icon('bitcoin') . ' ' . Yii::t($moduleID . '/app', 'Invt Budgettypes')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), 'url' => ['/inventory/invtbdgt/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), 'url' => ['/inventory/invtbdgt']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('stats') . ' ' . Yii::t($moduleID . '/app', 'Invt Statuses')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), 'url' => ['/inventory/invtstat/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), 'url' => ['/inventory/invtstat']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('tag') . ' ' . Yii::t($moduleID . '/app', 'Invt Types')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), 'url' => ['/inventory/invttype/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), 'url' => ['/inventory/invttype']],
//                '<li class="divider"></li>',
//                ['label' => Html::Icon('home') . ' ' . Yii::t($moduleID . '/app', 'Main Locations')],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), 'url' => ['/inventory/loc/create']],
//                ['label' => Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), 'url' => ['/inventory/loc']],
//                '<li class="divider"></li>',
//            ]
//        ],
        '
        <li class="dropdown menu-large">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::Icon('bookmark') . ' ' . Yii::t($moduleID . '/app', 'ข้อมูล').'<span class="caret caret-right"></span></a>
        <ul class="dropdown-menu megamenu row">
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('play') . ' ' . Yii::t($moduleID . '/app', 'พัสดุ/ครุภัณฑ์').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), ['/inventory/invtmain/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), ['/inventory/invtmain']).'</li>
                </ul>
                <ul>
                    <li class="dropdown-header">'.Html::Icon('home') . ' ' . Yii::t($moduleID . '/app', 'สถานที่').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), ['/location/loc/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), ['/location/loc']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('bitcoin') . ' ' . Yii::t($moduleID . '/app', 'ประเภทเงินพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), ['/inventory/invtbdgt/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), ['/inventory/invtbdgt']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('stats') . ' ' . Yii::t($moduleID . '/app', 'สถานะพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), ['/inventory/invtstat/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), ['/inventory/invtstat']).'</li>
                </ul>
            </li>
            <li class="col-sm-3">
                <ul>
                    <li class="dropdown-header">'.Html::Icon('tag') . ' ' . Yii::t($moduleID . '/app', 'ประเภทพัสดุ').'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'เพิ่ม'), ['/inventory/invttype/create']).'</li>
                    <li>'.Html::a(Html::Icon('menu-right') . ' ' . Yii::t($moduleID . '/app', 'รายการ'), ['/inventory/invttype']).'</li>
                </ul>
            </li>
        </ul>
        </li>
        ',
        ['label' => Html::Icon('info-sign') . ' ' . Yii::t($moduleID . '/app', 'คำแนะนำการใช้'), 'url' => ['default/readme']],
    ];
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => Yii::t( $moduleID.'/app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Html::Icon('log-in') . ' ' . Yii::t($moduleID . '/app', 'เข้าสู่ระบบ'), 'url' => Yii::$app->user->loginUrl];
    } else {
        $menuItems[] = [
            'label' => Html::Icon('option-horizontal') . ' ' . Yii::t($moduleID . '/app', 'อื่นๆ'),
                'url' => ['#'],
                'items' =>
                    //['label' => Html::Icon('dashboard') . ' ' . Yii::t($moduleID . '/app', 'office'), 'url' => ['/']],
                    [
                        '<li>'
                        .Html::a(Html::Icon('dashboard') . ' ' . Yii::t($moduleID . '/app', 'office') , ['/'])
                        .'</li>',
                        '<li>'
                        . Html::a(Html::Icon('globe') . ' ' . Yii::t('app', 'หน้าเว็บไซต์หลัก'), '/')
                        . '</li>',
                        '<li>'
                        . Html::beginForm(['/site/logout', 'url' => Url::current()], 'post')
                        . Html::submitButton(
                            Html::Icon('log-out') . ' ' . Yii::t($moduleID . '/app', 'ออกจากระบบ') . ' (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link']
                        )
                        . Html::endForm()
                        . '</li>',
                    ],
            ];
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout', 'url' => Url::current()], 'post')
//            . Html::submitButton(
//                Html::Icon('log-out') . ' ' . Yii::t($moduleID . '/app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link']
//            )
//            . Html::endForm()
//            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container-fluid">
        <?php
        $cookies = Yii::$app->request->cookies;

        if (($cookie = $cookies->get('inventorymoduleversion')) !== null) {
            if ($cookie->value != Yii::$app->controller->module->params['ModuleVers']) {
                $delcookies = Yii::$app->response->cookies;
                $delcookies->remove('inventorymoduleversion');
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
                'url' => Url::toRoute('/' . $moduleID),
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
        <p>© 2016 PSU YII DEV <span class="label label-danger"><?php echo Yii::$app->controller->module->params['ModuleVers']; ?></span>
            <?php echo '  '.Yii::t( 'app', 'พบปัญหาในการใช้งาน ติดต่อ - ').Html::icon('envelope'); ?> :  <?php echo Html::mailto('อับดุลอาซิส ดือราแม', 'abdul-aziz.d@psu.ac.th'); ?><?php echo ' '.Html::icon('earphone').' : '.Yii::t( 'app', 'โทรศัพท์ภายใน : 2618'); ?>
            <a href="#" data-toggle="tooltip" title="<?php echo Yii::t( 'app', 'responsive_web'); ?>"><img src="<?php echo '/uploads/adzpireImages/responsive-icon.png'; ?>" width="30" height="30" /></a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
