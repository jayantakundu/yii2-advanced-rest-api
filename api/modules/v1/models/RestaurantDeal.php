<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * RestaurantDeal Model
 *
 * @author Jayanta Kundu created on 04.06.2015
 */
class RestaurantDeal extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_restaurant_deals';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['id', 'res_id', 'title'], 'required']
        ];
    }   
}
