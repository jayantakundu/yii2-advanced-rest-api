<?php

namespace api\modules\v1\models;

use api\modules\v1\models\RestaurantGallery;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "ed_restaurants".
 *
 * @author jayanta kundu
 *
 * @property integer $res_id
 * @property integer $primary_cuisine_id
 * @property integer $restaurant_type_id
 * @property integer $res_group_id
 * @property integer $category_id
 * @property string $action_url
 * @property string $name
 * @property string $companyname
 * @property string $websiteUrl
 * @property double $costfortwo
 * @property string $address
 * @property string $phone_number
 * @property string $mobile_number
 * @property integer $region_id
 * @property integer $area_id
 * @property integer $subarea_id
 * @property integer $city_id
 * @property integer $loc_id
 * @property double $latitude
 * @property double $longitude
 * @property integer $critics_review
 * @property integer $reservation
 * @property string $speciality
 * @property string $note
 * @property string $alias
 * @property integer $urlupdate
 * @property integer $edtop
 * @property string $zomato_link
 * @property integer $status
 * @property integer $visibility
 * @property integer $inactive_reason
 * @property integer $old_cuisine_id
 *
 * @property ResContact[] $edResContacts
 * @property RestaurantCritic $resCritic
 * @property RestaurantFeature $resFeatures
 * @property RestaurantGallery[] $resGalleries
 * @property RestaurantTiming $resTiming
 * @property Cuisine $primaryCuisine
 * @property RestaurantGallery $resImage
 * @property Favorite $resFavorite
 */
class Restaurant extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ed_restaurants';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['res_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['res_id','name','action_url'], 'required']
        ];
    }
    
    public function fields()
    {
	//parent fields
        //$fields = parent::fields();
        $fields = ['res_id','name','action_url','address','critics_review','reservation','latitude','longitude','status','visibility'];
        //add new fields
        $fields = array_merge(
            $fields,
            [
                'image_url'=> function ($model) { 
		    return 'eazymedia/restaurant/'.$model->res_id.'/'.$model->resImage->image;
		},
          
		'res_number'=>function ($model) {
                    if($model->mobile_number!=''){
		    	return $model->phone_number . ' , ' . $model->mobile_number;
                    }else{ return $model->phone_number; }
		},
                
		'primary_cuisine'=>function ($model) {
		    return $model->primaryCuisine->cuisine_name;
		},
               
		'critic_name' =>function ($model) { 
		    if($model->resCritic->critic_id>0){return UserDetails::find()->select(['caption_name'])->where(['user_id' => $model->resCritic->critic_id])->one()->caption_name; }else{return '';};
		},

		'review_text'=>function ($model) { 
		    return $model->resCritic->review_text;
		    
		},
		
		'insider_tips'=>function ($model) { 
		    return $model->resCritic->insider_tips;
		    
		},

		'critic_rating' =>function ($model) { 
		    return $model->resCritic->rating;
		},
	
		'user_rating' =>function ($model) { 
		    return Review::find()->select(['res_rating'])->where(['res_id' => $model->res_id,'activation_status'=>'Active'])->average('res_rating');
		},
		
		'timings'=>function ($model) { 
		    return $model->resTiming->timing;
		    
		},
		
		'deal'=>function ($model) { 
		    $query = RestaurantDeal::find()->where(['res_id' =>$model->res_id,'status'=>1]);
		    $deal= $query->andWhere('now() BETWEEN dealfrom AND dealto')->one();
		    if(!empty($deal)){ return $deal->title;}else{ return '';}
		},

		'favorites'=>function ($model) { 
		    $cnt = Favorite::find()->where(['type_id' =>$model->res_id,'type'=>'restaurant'])->count();
		    if(($cnt>0)){ return $cnt;}else{ return '0';}
		},

		'likes'=>function ($model) { 
		    $cnt = Like::find()->where(['type_id' =>$model->res_id,'type'=>'restaurant'])->count();
		    if(($cnt>0)){ return $cnt;}else{ return '0';}
		},
            ]
        );
             return $fields;

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResContacts()
    {
        return $this->hasMany(ResContact::className(), ['res_id' => 'res_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResCritic()
    {
        return $this->hasOne(RestaurantCritic::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResFeatures()
    {
        return $this->hasOne(RestaurantFeature::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResGalleries()
    {
        return $this->hasMany(RestaurantGallery::className(), ['res_id' => 'res_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResImage() {
        return $this->hasOne(RestaurantGallery::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResTiming()
    {
        return $this->hasOne(RestaurantTiming::className(), ['res_id' => 'res_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrimaryCuisine()
    {
        return $this->hasOne(Cuisine::className(), ['cuisine_id' => 'primary_cuisine_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getresFavorite()
    {
        return $this->hasMany(Favorite::className(), ['type_id' => 'res_id']);
    }


}
