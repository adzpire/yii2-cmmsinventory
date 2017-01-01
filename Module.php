<?php

namespace backend\modules\inventory;

use Yii;
/**
 * inventory module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\inventory\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$app->formatter->locale = 'th_TH';
        Yii::$app->formatter->calendar = \IntlDateFormatter::TRADITIONAL;
		parent::init();

        $this->params['adminModule'] = [5,18];
		$this->layout = 'inventory';
		$this->params['ModuleVers'] = '1.1';
		$this->params['title'] = 'ฐานข้อมูลพัสดุ/ครุภัณฑ์';
        // custom initialization code goes here
    }
}
