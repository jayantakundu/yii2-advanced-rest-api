<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Favorite Model
 *
 * @author Jayanta Kundu created on 08.06.2015
 */
class Favorite extends ActiveRecord 
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_favorite';
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
