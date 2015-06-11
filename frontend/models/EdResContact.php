<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_res_contact".
 *
 * @property integer $id
 * @property integer $res_id
 * @property string $contactperson
 * @property string $designation
 * @property string $email
 * @property string $cc_email
 * @property string $type
 * @property string $phone_number
 * @property string $mobile_number
 * @property integer $status
 *
 * @property EdRestaurants $res
 */
class EdResContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ed_res_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'contactperson', 'designation', 'email', 'cc_email', 'type', 'phone_number', 'mobile_number', 'status'], 'required'],
            [['res_id', 'status'], 'integer'],
            [['type'], 'string'],
            [['contactperson', 'mobile_number'], 'string', 'max' => 50],
            [['designation'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['cc_email'], 'string', 'max' => 250],
            [['phone_number'], 'string', 'max' => 60]
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
            'contactperson' => 'Contactperson',
            'designation' => 'Designation',
            'email' => 'Email',
            'cc_email' => 'Cc Email',
            'type' => 'Type',
            'phone_number' => 'Phone Number',
            'mobile_number' => 'Mobile Number',
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
