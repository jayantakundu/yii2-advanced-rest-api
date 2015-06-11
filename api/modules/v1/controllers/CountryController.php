<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country'; 

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();

    	unset($actions['index']);
        // disable the "index" actions

        // customize the data provider preparation with the "prepareDataProvider()" method 
        //$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;

    }  

    public function actionIndex()
    {   
	
        $model = new $this->modelClass; 
        
        $query = $model->find();
      
        return $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
		'pageSize' => 5,
	    ],
        ]);
       
       
    } 


   public function actionSs()
    {
    echo 'index';exit;
    } 
   
   public function actionYy()
    {
    echo 'szssss';exit;
    //return User::findOne($id);
    }    
}


