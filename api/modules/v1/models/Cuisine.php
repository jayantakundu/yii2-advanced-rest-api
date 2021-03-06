<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Cuisine Model
 *
 * @author Jayanta Kundu created on 04.06.2015
 */
class Cuisine extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_cuisine';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['cuisine_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['cuisine_id', 'cuisine_name', 'cuisine_code'], 'required']
        ];
    }   
}
