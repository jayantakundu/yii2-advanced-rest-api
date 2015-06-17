<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

use yii\db\Query;

use api\modules\v1\models\RestaurantSearch;
use api\modules\v1\models\RestaurantFeature;
use api\modules\v1\models\RestaurantGallery;
use api\modules\v1\models\RestaurantMenu;
use api\modules\v1\models\Review;

/**
 * Restaurant Controller API
 *
 * @author jayanta kundu created on 02.06.2015
 */
class RestaurantController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Restaurant';

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
    
   
    /**
     * @return Restaurants
     * @Note: customize index if you need
     * @author jayanta kundu modified on 04.06.2015
     */
    public function actionIndex(){
        $model = new RestaurantSearch();
        $query = $model->find(); 
	$query->joinWith(['resCritic' => function ($query) {
        	$query->orderBy('ed_res_critic.rating DESC');} 
		]);
	$perpage = 5;
        //print_r($_GET);exit;
       
        if (!empty($_GET) && array_key_exists('city_id', $_GET)) {
	    // apply city filter and status active filter here
            $query->where(['city_id'=>$_GET['city_id'],'status'=>'1']);

	    foreach ($_GET as $key => $value) {
	      
              if($key!='page' && $key!='per-page' && $key!='city_id'){

		if($key =='costfortwo'){
		// costfortwo customize here

			$param=explode('-',$value); 
			if(!empty($param[0]) && !empty($param[1]))
			{
			   $query->andWhere('costfortwo BETWEEN '.$param[0].' AND '.$param[1]);
			}

		}else if($key =='feature_ids'){
		// feature customize here
			$fetquery = new Query;
			$fetquery->from('ed_restaurant_features');
			$fetquery->select(['res_id']);
			$list = $fetquery->andFilterWhere(['IN', 'features_id', explode(',',$_GET['feature_ids'])])->all(); 
                        $resids = [];
                        foreach($list as $key=>$each){
			  $resids[] = $each['res_id']; 
			}
                        //print_r(count($resids));exit;

			$query->andFilterWhere(['IN','res_id', $resids]);

		}else if ($model->hasAttribute($key)) { 
		// add all model attribute filter here
                    $query->andWhere([$key=>$value]);

		}else{ 
   			//throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
		}

	      }else if($key =='per-page'){
		$perpage = $value; // customise perpage 
	      }		
	    }
            
	    // nearby customize here
	    if(array_key_exists('lat', $_GET) && array_key_exists('long', $_GET)){
		
			$query->having('(POW((69.1*(longitude-"'.$_GET['long'].'")*cos('.$_GET['lat'].'/57.3)),"2")+POW((69.1*(latitude-"'.$_GET['lat'].'")),"2")*1.609344) <=5');
                   
		}
         }else{ 
   		throw new \yii\web\HttpException(404, 'city required');
	 }

	    try {
			
			$provider = new ActiveDataProvider([
			    'query' => $query,
                            'sort'=> ['defaultOrder' => ['reservation'=>SORT_DESC,'critics_review'=>SORT_DESC]],
			    'pagination' => [
				'pageSize' => $perpage,
			    ],
			]);
		
      
	    } catch (Exception $ex) {
		throw new \yii\web\HttpException(500, 'Internal server error');
	    }

	    if ($provider->getCount() <= 0) {
		throw new \yii\web\HttpException(404, 'No entries found with this query string');
	    } 
	    else {
		return $provider;
	    }
	
    }

       

  /**
   * @return Restaurant Reviews
   * @Note: customize index if you need
   * @author jayanta kundu modified on 04.06.2015
   */
   public function actionReview($id)
   {
	$perpage = 5;
       
        if (!empty($_GET)) {
	    foreach ($_GET as $key => $value) {
              if($key=='per-page'){$perpage = $value;}
	    }
	}

	$model=new Review();	
	$query = $model->find()->where(['res_id' => $id,'activation_status'=>'Active']);
        
	$provider = new ActiveDataProvider([
			    'query' => $query,
                            'sort'=> ['defaultOrder' => ['submitteddate'=>SORT_DESC]],
			    'pagination' => [
				'pageSize' => $perpage,
			    ],
			]);

	return $provider;
   }

  /**
   * @return Restaurant Galleries
   * @Note: customize index if you need
   * @author jayanta kundu modified on 08.06.2015
   */
   public function actionGallery($id)
   {
	
	$model=new RestaurantGallery();
	$query = $model->find()->where(['res_id' => $id,'status'=>1]);
	$provider = new ActiveDataProvider([
			    'query' => $query,
                            'sort'=> ['defaultOrder' => ['sortorder'=>SORT_ASC]],
			]);

	return $provider;
   }

  /**
   * @return Restaurant Menus
   * @Note: customize index if you need
   * @author jayanta kundu modified on 08.06.2015
   */
   public function actionMenu($id)
   {
	
	$model=new RestaurantMenu();
	$query = $model->find()->where(['res_id' => $id]);
	$provider = new ActiveDataProvider([
			    'query' => $query,
                            'sort'=> ['defaultOrder' => ['sortorder'=>SORT_ASC]],
			]);

	return $provider;
   }


}


