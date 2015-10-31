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
     * @author jayanta kundu created on 10.06.2015
     */
    public function actionIndex(){ 
	$perpage = 10;
        $model = new RestaurantSearch();
        $query = $model->find(); 
	$query->joinWith(['resCritic' => function ($query) {}]);
        // set default sort order here
	$query->orderBy(['reservation'=>SORT_DESC,'critics_review'=>SORT_DESC,'ed_res_critic.rating'=>SORT_DESC]);
        //print_r($_GET);exit;
       
        if (!empty($_GET) && array_key_exists('city_id', $_GET)) {
	    // apply city filter and status active filter here
            $query->where(['city_id'=>$_GET['city_id'],'status'=>'1','visibility'=>1]);
	    // customise perpage 
            if(array_key_exists('per-page', $_GET)){
		$perpage = $_GET['per-page'];
            }
	    // location customise here region_id, area_id, subarea_id, group_id
            if(array_key_exists('region_id', $_GET)){
		$query->andWhere(['region_id'=>$_GET['region_id']]);
            }
	    if(array_key_exists('area_id', $_GET)){
		$query->andWhere(['area_id'=>$_GET['area_id']]);
            }
	    if(array_key_exists('subarea_id', $_GET)){
		$query->andWhere(['subarea_id'=>$_GET['subarea_id']]);
            }
            if(array_key_exists('region_id', $_GET)){
		$query->andWhere(['group_id'=>$_GET['group_id']]);
            }
            // primary_cuisine_id customise here
            if(array_key_exists('primary_cuisine_id', $_GET)){
		$query->andWhere(['primary_cuisine_id'=>$_GET['primary_cuisine_id']]);
            }
            // costfortwo customize here
	    if(array_key_exists('costfortwo', $_GET)){
		$param=explode('-',$_GET['costfortwo']); 
		if(!empty($param[0]) && !empty($param[1]))
		{
		   $query->andWhere('costfortwo BETWEEN '.$param[0].' AND '.$param[1]);
		}
            }
	    // keyword by name, address customise here
	    if(array_key_exists('keyword', $_GET)){
		$query->andWhere('name like "%'.$_GET['keyword'].'%" OR address like "%'.$_GET['keyword'].'%" ');
            }
	    // nearby customize here
	    if(array_key_exists('lat', $_GET) && array_key_exists('long', $_GET)){
		$this->setNearbyQuery($query,$_GET['lat'],$_GET['long']);                      
	    }
         }else{ 
   		throw new \yii\web\HttpException(404, 'city required');
	 }
	 return $this->prepareDataProvider($query,$perpage);
	
    }
  /**
   * @return Nearby Restaurants
   * @Note: customize index if you need
   * @author jayanta kundu modified on 11.06.2015
   */
   public function actionNearby()
   {
	$perpage = 5;
        $model = new $this->modelClass;
        //print_r($_GET);exit;
       
        if (!empty($_GET) && array_key_exists('city_id', $_GET)) {
	     $query = $model->find(); 
	     $query->joinWith(['resCritic' => function ($query) {}]);
	     // apply city filter and status active filter here
             $query->where(['city_id'=>$_GET['city_id'],'status'=>'1']);
		
		if(array_key_exists('per-page', $_GET)){ $perpage = $_GET['per-page'];}
		if(array_key_exists('lat', $_GET) && array_key_exists('long', $_GET)){
                	$this->setNearbyQuery($query,$_GET['lat'],$_GET['long']);
           	}else{ 
   		throw new \yii\web\HttpException(404, 'latitude , longitude required');
	        }
         }else{ 
   		throw new \yii\web\HttpException(404, 'city required');
	 }
	
	return $this->prepareDataProvider($query,$perpage);
	    
   }
 /**
   * @return near by query
   * @Note: customize setperpage if you need
   * @author jayanta kundu created on 11.06.2015
   */ 
   private function setNearbyQuery($query,$lat,$long){
	// set calculated distance to distance fields
	$query->select(['ed_restaurants.*' ,'(POW( ( 69.1 * ( longitude - "'.$_GET['long'].'" ) * cos( '.$_GET['lat'].' / 57.3 ) ) , "2" ) + POW( ( 69.1 * ( latitude - "'.$_GET['lat'].'" ) ) , "2" ) * (1.609344)) AS `distance` ']);
	$query->having('distance<=5');
	// overwrite sort order here
	$query->orderBy(['reservation'=>SORT_DESC,'critics_review'=>SORT_DESC,'distance'=>SORT_ASC,'ed_res_critic.rating'=>SORT_DESC]);
         
	return $query;
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
   
  /**
   * @return perpage
   * @Note: customize setperpage if you need
   * @author jayanta kundu created on 11.06.2015
   */    
   private function setperpage($perpage){
	if($perpage>30){ return '30';}
	else if($perpage<=0){ return '5';}
	else{ return $perpage;}
    }
  /**
   * @return prepareDataProvider
   * @Note: customize prepareDataProvider if you need
   * @author jayanta kundu created on 11.06.2015
   */
    private function prepareDataProvider($query,$perpage){
        $perpage = $this->setperpage($perpage);
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
	    if ($provider->getCount() <= 0) {
		throw new \yii\web\HttpException(404, 'No entries found with this query string');
	    } 
	    else {
		return $provider;
	    }
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        //if(!empty($result['items'])) {
            if($action->id=='index') {
                $city = City::findOne(['id'=>$_GET['city_id']]);
                if(empty($this->pagetitle)){$this->pagetitle = $city->name;}
                $result['pageUrl'] = WEBSITE_URL.'/'.$city->code.'/restaurants'.$this->pageUrl;
                $result['pageTitle'] = $this->pagetitle;
            }
        //}
        return $result;
    }

}


