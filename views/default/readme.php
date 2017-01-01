<?php
use yii\helpers\Markdown;

//$body = Yii::$app->controller->renderPartial('@backend/modules/inventory/docs/guide/basic-usage.md');
$body = Yii::$app->controller->renderPartial('@vendor/docs/guide/basic-usage.md');
echo Markdown::process($body, 'extra');