<?php
namespace api\modules\v1;

/**
 * API V1 Module
 * 
 * @author jayanta kundu <jayantakundu89@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();        
    }
}
