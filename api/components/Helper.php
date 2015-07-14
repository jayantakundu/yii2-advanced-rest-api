<?php 
namespace app\components;

use Yii;
use yii\base\Component;
 	
class Helper extends component {
    
  /**
   * @return getErrors
   * @Note: customize getErrors if you need
   * @author jayanta kundu created on 11.07.2015
   */
   public function getErrors($model_errors){  
		$i = 0; 
		foreach($model_errors as $key=>$message){ 
			$errors[$i]['field']=$key;
			$errors[$i]['message']=$message[0];
			$i++;
		}; 
		return $errors;
	}
    }


}
