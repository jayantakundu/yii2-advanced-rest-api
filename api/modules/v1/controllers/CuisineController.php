<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\db\Query;


/**
 * Cuisine Controller API
 *
 * @author jayanta kundu created on 11.06.2015
 */
class CuisineController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Cuisine';

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
     * @return Areas 
     * @Note: customize index if you need
     * @author jayanta kundu modified on 10.06.2015
     */
    public function actionIndex(){

	$model = new $this->modelClass;
        $query = $model->find();
	$query->select(['cuisine_id','cuisine_name','cuisine_code']);
        $query->where('cuisine_id IN (select distinct primary_cuisine_id from ed_restaurants)');
        $query->orderBy(['cuisine_id'=>SORT_ASC]);
	return new  ActiveDataProvider([
	    'query' => $query,
	    'pagination' => false
	]);

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
		    'pagination' => [
			'pageSize' => $perpage,
		    ],
		]);
      
	    } catch (Exception $ex) {
		throw new \yii\web\HttpException(500, 'Internal server error');
	    }
	    return $provider;
    }

       

}


