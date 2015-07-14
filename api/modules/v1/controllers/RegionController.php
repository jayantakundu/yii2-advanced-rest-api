<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\db\Query;


/**
 * Region Controller API
 *
 * @author jayanta kundu created on 11.06.2015
 */
class RegionController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Region';

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
     * @return Regions
     * @Note: customize index if you need
     * @author jayanta kundu modified on 10.06.2015
     */
    public function actionIndex(){
	$perpage = 5;
	$model = new $this->modelClass;
        $query = $model->find();
       
        if (!empty($_GET) && array_key_exists('city_id', $_GET)) {
	    $query->where(['city_id'=>$_GET['city_id'],'status'=>1]);

	    if(array_key_exists('per-page', $_GET)){ $perpage = $_GET['per-page'];}
	}else{
   		throw new \yii\web\HttpException(404, 'city required');
        }
     
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
		    'pagination' => false,
		]);
      
	    } catch (Exception $ex) {
		throw new \yii\web\HttpException(500, 'Internal server error');
	    }
	    return $provider;
    }

       

}


