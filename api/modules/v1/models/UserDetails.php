<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * UserDetails Model
 *
 * @author Jayanta Kundu created on 08.06.2015
 */
class UserDetails extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_user_details';
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
            [['id', 'name', 'user_id'], 'required']
        ];
    }   
}
