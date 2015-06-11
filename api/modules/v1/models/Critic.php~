<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Location Model
 *
 * @author Jayanta Kundu created on 04.06.2015
 */
class Location extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_locations';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['loc_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['loc_id', 'name', 'action_url'], 'required']
        ];
    }   
}
