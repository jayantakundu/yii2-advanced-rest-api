<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_res_critic".
 *
 * @property integer $id
 * @property integer $res_id
 * @property integer $critic_id
 * @property string $short_review
 * @property string $review_text
 * @property string $insider_tips
 * @property integer $rating
 * @property string $createddate
 *
 * @property EdRestaurants $res
 */
class EdResCritic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ed_res_critic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'critic_id', 'short_review', 'review_text', 'insider_tips', 'rating', 'createddate'], 'required'],
            [['res_id', 'critic_id', 'rating'], 'integer'],
            [['review_text', 'insider_tips'], 'string'],
            [['createddate'], 'safe'],
            [['short_review'], 'string', 'max' => 130]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_id' => 'Res ID',
            'critic_id' => 'Critic ID',
            'short_review' => 'Short Review',
            'review_text' => 'Review Text',
            'insider_tips' => 'Insider Tips',
            'rating' => 'Rating',
            'createddate' => 'Createddate',
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
