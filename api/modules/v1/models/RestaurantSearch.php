<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Restaurant;
use \yii\db\ActiveRecord;

/**
 * RestaurantSearch represents the model behind the search .
 */
class RestaurantSearch extends Restaurant
{
    public $critic_rating;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['res_id'], 'integer'],
            [['critic_rating'], 'safe'],
        ];
    }
    


    public function fields()
    {
	$fields = ['res_id','name','action_url','costfortwo','reservation','critics_review','status','visibility'];
        //add new fields
        $fields = array_merge(
            $fields,
            [ 
                'image_url'=> function ($model) {
		    if(!empty($model->resImage)){
			 return 'eazymedia/restaurant/'.$model->res_id.'/'.$model->resImage->image;
		     }else{ return '';}
		},
                
		'primary_cuisine'=>function ($model) {
		    return (isset($model->primaryCuisine->cuisine_name))?$model->primaryCuisine->cuisine_name:'';
		},
               
  		'location'=>function ($model) { $loc = Location::find()->where(['loc_id' =>$model->loc_id])->one();
		    return (isset($loc->name))?$loc->name:'';
		},

		'location_link'=>function ($model) { $loc = Location::find()->where(['loc_id' =>$model->loc_id])->one();
		    return (isset($loc->action_url))?$loc->action_url:'';
		},
                
		'critic_name' =>function ($model) { 
		    if(isset($model->resCritic->critic_id) && $model->resCritic->critic_id>0){return UserDetails::find()->select(['caption_name'])->where(['user_id' => $model->resCritic->critic_id])->one()->caption_name; }else{return '';};
		},

		'short_review'=>function ($model) { 
		    return (isset($model->resCritic->short_review))?$model->resCritic->short_review:'';
		    
		},

		'critic_rating'=>function ($model) { 
		    return (isset($model->resCritic->rating))?$model->resCritic->rating:'0';
		},
  		
		'user_rating' =>function ($model) { 
		    return Review::find()->select(['res_rating'])->where(['res_id' => $model->res_id,'activation_status'=>'Active'])->average('res_rating');
		},

		'deal'=>function ($model) { 
		    $query = RestaurantDeal::find()->where(['res_id' =>$model->res_id,'status'=>1]);
		    $deal= $query->andWhere('now() BETWEEN dealfrom AND dealto')->one();
		    if(!empty($deal)){ return $deal->title;}else{ return '';}
		},
            ]
        );
         
      return $fields;

    }

   
}
