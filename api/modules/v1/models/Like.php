<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Like Model
 *
 * @author Jayanta Kundu created on 08.06.2015
 */
class Like extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_like';
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
            [['id', 'type', 'type_id'], 'required']
        ];
    }   
}
