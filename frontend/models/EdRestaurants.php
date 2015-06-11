<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_restaurants".
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
 * @property EdInvoiceSetting $edInvoiceSetting
 * @property EdResContact[] $edResContacts
 * @property EdResCritic[] $edResCritics
 * @property EdResFeature[] $edResFeatures
 * @property EdResGallery[] $edResGalleries
 * @property EdResTiming[] $edResTimings
 * @property EdRestaurantType $restaurantType
 * @property EdCuisine $primaryCuisine
 */
class EdRestaurants extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['primary_cuisine_id', 'restaurant_type_id', 'res_group_id', 'category_id', 'region_id', 'area_id', 'subarea_id', 'city_id', 'loc_id', 'critics_review', 'reservation', 'urlupdate', 'edtop', 'status', 'visibility', 'inactive_reason', 'old_cuisine_id'], 'integer'],
            [['action_url', 'name', 'companyname', 'websiteUrl', 'costfortwo', 'address', 'phone_number', 'mobile_number', 'city_id', 'latitude', 'longitude', 'critics_review', 'reservation', 'speciality', 'note', 'alias', 'urlupdate', 'edtop', 'zomato_link', 'status', 'visibility', 'inactive_reason', 'old_cuisine_id'], 'required'],
            [['costfortwo', 'latitude', 'longitude'], 'number'],
            [['speciality', 'note'], 'string'],
            [['action_url', 'websiteUrl', 'zomato_link'], 'string', 'max' => 300],
            [['name', 'companyname'], 'string', 'max' => 100],
            [['address', 'alias'], 'string', 'max' => 200],
            [['phone_number'], 'string', 'max' => 60],
            [['mobile_number'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'res_id' => 'Res ID',
            'primary_cuisine_id' => 'Primary Cuisine ID',
            'restaurant_type_id' => 'Restaurant Type ID',
            'res_group_id' => 'Res Group ID',
            'category_id' => 'Category ID',
            'action_url' => 'Action Url',
            'name' => 'Name',
            'companyname' => 'Companyname',
            'websiteUrl' => 'Website Url',
            'costfortwo' => 'Costfortwo',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'mobile_number' => 'Mobile Number',
            'region_id' => 'Region ID',
            'area_id' => 'Area ID',
            'subarea_id' => 'Subarea ID',
            'city_id' => 'City ID',
            'loc_id' => 'Loc ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'critics_review' => 'Critics Review',
            'reservation' => 'Reservation',
            'speciality' => 'Speciality',
            'note' => 'Note',
            'alias' => 'Alias',
            'urlupdate' => 'Urlupdate',
            'edtop' => 'Edtop',
            'zomato_link' => 'Zomato Link',
            'status' => 'Status',
            'visibility' => 'Visibility',
            'inactive_reason' => 'Inactive Reason',
            'old_cuisine_id' => 'Old Cuisine ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdInvoiceSetting()
    {
        return $this->hasOne(EdInvoiceSetting::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdResContacts()
    {
        return $this->hasMany(EdResContact::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdResCritics()
    {
        return $this->hasMany(EdResCritic::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdResFeatures()
    {
        return $this->hasMany(EdResFeature::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdResGalleries()
    {
        return $this->hasMany(EdResGallery::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdResTimings()
    {
        return $this->hasMany(EdResTiming::className(), ['res_id' => 'res_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantType()
    {
        return $this->hasOne(EdRestaurantType::className(), ['id' => 'restaurant_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrimaryCuisine()
    {
        return $this->hasOne(EdCuisine::className(), ['cuisine_id' => 'primary_cuisine_id']);
    }
}
