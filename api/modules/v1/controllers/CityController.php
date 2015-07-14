<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\db\Query;


/**
 * City Controller API
 *
 * @author jayanta kundu created on 11.06.2015
 */
class CityController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\City';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();

    	unset($actions['index']);
        // disable the "index" actions

        return $actions;

    }

    /**
     * @return Cities
     * @Note: customize index if you need
     * @author jayanta kundu modified on 10.06.2015
     */
    public function actionIndex(){
	$perpage = 5;
       
        if (!empty($_GET)) {
	    if(array_key_exists('per-page', $_GET)){ $perpage = $_GET['per-page'];}
	}

	    $model = new $this->modelClass;
        $query = $model->find();
        
	return $this->prepareDataProvider($query,$perpage);
   }    
   
  /**
   * @return prepareDataProvider
   * @Note: customize prepareDataProvider if you need
   * @author jayanta kundu created on 11.06.2015
   */
    private function prepareDataProvider($query,$perpage){
	if($perpage>30){ $perpage =30;}
	else if($perpage<=0){ $perpage =5;}

	try {  
		$provider = new ActiveDataProvider([
		    'query' => $query,
		    'pagination' => false
		]);
      
	    } catch (Exception $ex) {
		throw new \yii\web\HttpException(500, 'Internal server error');
	    }
	    return $provider;
    }

       

}


