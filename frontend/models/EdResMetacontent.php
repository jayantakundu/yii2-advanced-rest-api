<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ed_res_metacontent".
 *
 * @property integer $id
 * @property integer $res_id
 * @property string $shortdesc
 * @property string $description
 * @property string $pagetitle
 * @property string $metatitle
 * @property string $metadesc
 * @property string $metakeyword
 * @property integer $createdby
 * @property string $createddate
 * @property integer $modifiedby
 * @property string $modifieddate
 * @property string $status
 */
class EdResMetacontent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ed_res_metacontent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'shortdesc', 'description', 'pagetitle', 'metatitle', 'metadesc', 'metakeyword', 'createdby', 'createddate', 'modifiedby', 'status'], 'required'],
            [['res_id', 'createdby', 'modifiedby'], 'integer'],
            [['description', 'status'], 'string'],
            [['createddate', 'modifieddate'], 'safe'],
            [['shortdesc', 'pagetitle', 'metakeyword'], 'string', 'max' => 200],
            [['metatitle'], 'string', 'max' => 100],
            [['metadesc'], 'string', 'max' => 300]
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
            'shortdesc' => 'Shortdesc',
            'description' => 'Description',
            'pagetitle' => 'Pagetitle',
            'metatitle' => 'Metatitle',
            'metadesc' => 'Metadesc',
            'metakeyword' => 'Metakeyword',
            'createdby' => 'Createdby',
            'createddate' => 'Createddate',
            'modifiedby' => 'Modifiedby',
            'modifieddate' => 'Modifieddate',
            'status' => 'Status',
        ];
    }
}
