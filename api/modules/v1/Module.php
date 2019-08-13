<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 20.05.2019
 * Time: 23:09
 */

namespace api\modules\v1;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}