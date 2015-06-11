<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

/**
 * RestaurantGallery Model
 *
 * @author jayanta kundu
 *
 * @property integer $gallery_id
 * @property integer $res_id
 * @property string $image
 * @property integer $sortorder
 * @property integer $status
 *
 * @property Restaurant $res
 */
class RestaurantGallery extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
     public static function tableName()
     {
	return 'ed_res_gallery';
     }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['gallery_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['gallery_id','res_id','image', 'sortorder', 'status'], 'required']
        ];
    }

        public function fields()
    {
	$fields = ['gallery_id', 'sortorder', 'status'];
        //add new fields
        $fields = array_merge(
            $fields,
            [ 
                'image'=> function ($model) {
			 return 'eazymedia/restaurant/'.$model->res_id.'/'.$model->image;
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
