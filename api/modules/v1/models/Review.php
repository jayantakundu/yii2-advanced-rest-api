<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Review Model
 *
 * @author Jayanta Kundu created on 04.06.2015
 *
 * @property Customer $revCustomer
 * @property CustomerDetails $revCustDetails
 */
class Review extends ActiveRecord 
{
   public $rating;
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
	return 'ed_review';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['review_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['review_id', 'res_id', 'review_title'], 'required'],
	    [['rating'], 'safe']
        ];
    } 

    public function fields()
    {
	
	$fields = ['review_id','review_title','review_value','res_rating','submitteddate'];
        //add new fields
        $fields = array_merge(
            $fields,
            [ 
		'cust_name' =>function ($model) { 
		    return (isset($model->revCustDetails->name))?$model->revCustDetails->name:'';
		},
		'cust_image' =>function ($model) { 
		    return (isset($model->revCustDetails->image))?$model->revCustDetails->image:'';
		},
            ]
        ); 
      	return $fields;

    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevCustomer()
    {
        return $this->hasOne(Customer::className(), ['cust_id' => 'submittedby']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevCustDetails()
    {
        return $this->hasOne(CustomerDetails::className(), ['cust_id' => 'submittedby']);
    }
}
