<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * CustomerDetails Model
 *
 * @author Jayanta Kundu created on 08.06.2015
 */
class CustomerDetails extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_customer_details';
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
            [['id', 'name', 'cust_id'], 'required']
        ];
    }   
}
