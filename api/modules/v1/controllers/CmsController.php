<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\db\Query;


/**
 * Cms Controller API
 *
 * @author jayanta kundu created on 03.07.2015
 */
class CmsController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Cms';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();

	//unset($actions['create']);
        // disable actions

        return $actions;

    }

   
       
}

