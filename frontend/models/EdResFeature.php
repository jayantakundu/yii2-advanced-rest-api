<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_res_feature".
 *
 * @property integer $id
 * @property integer $features_id
 * @property integer $res_id
 * @property integer $status
 *
 * @property EdRestaurants $res
 * @property EdFeatures $features
 */
class EdResFeature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ed_res_feature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['features_id', 'res_id', 'status'], 'required'],
            [['features_id', 'res_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'features_id' => 'Features ID',
            'res_id' => 'Res ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatures()
    {
        return $this->hasOne(EdFeatures::className(), ['features_id' => 'features_id']);
    }
}
