<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_res_gallery".
 *
 * @property integer $gallery_id
 * @property integer $res_id
 * @property string $image
 * @property integer $sortorder
 * @property integer $status
 *
 * @property EdRestaurants $res
 */
class EdResGallery extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['res_id', 'image', 'sortorder', 'status'], 'required'],
            [['res_id', 'sortorder', 'status'], 'integer'],
            [['image'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gallery_id' => 'Gallery ID',
            'res_id' => 'Res ID',
            'image' => 'Image',
            'sortorder' => 'Sortorder',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRes()
    {
        return $this->hasOne(EdRestaurants::className(), ['res_id' => 'res_id']);
    }
}
