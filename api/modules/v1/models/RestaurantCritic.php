<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * RestaurantCritic Model
 *
 * @author Jayanta Kundu created on 04.06.2015
 */
class RestaurantCritic extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_res_critic';
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
            [['id', 'res_id', 'critic_id'], 'required']
        ];
    }   
}
