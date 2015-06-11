<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Customer Model
 *
 * @author Jayanta Kundu created on 08.06.2015
 */
class Customer extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_customer';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['cust_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['cust_id', 'email', 'password'], 'required']
        ];
    }   
}
