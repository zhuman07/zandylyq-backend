<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 05.06.2019
 * Time: 22:45
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\base\Module;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
        Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
        Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Origin,  Access-Control-Allow-Headers, Authorization, X-Requested-With');
        Yii::$app->getResponse()->getHeaders()->set('Content-type:', '*');

        if (Yii::$app->getRequest()->getMethod() == 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET');
            Yii::$app->end();
        }
    }
}