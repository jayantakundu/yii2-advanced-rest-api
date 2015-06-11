<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

/**
 * RestaurantMenu Model
 *
 * @author jayanta kundu
 *
 *
 * @property Restaurant $res
 */
class RestaurantMenu extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
     public static function tableName()
     {
	return 'ed_restaurant_menu';
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
            [['id','res_id','menu_image', 'sortorder'], 'required']
        ];
    }

        public function fields()
    {
	$fields = ['id', 'sortorder'];
        //add new fields
        $fields = array_merge(
            $fields,
            [ 
                'menu_image'=> function ($model) {
			 return 'eazymedia/restaurant/'.$model->res_id.'/menu/'.$model->menu_image;
		},
            ]
        );
         
      return $fields;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRes()
    {
        return $this->hasOne(Restaurant::className(), ['res_id' => 'res_id']);
    }   
}
