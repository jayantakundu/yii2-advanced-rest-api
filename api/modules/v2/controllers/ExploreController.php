<?php

namespace api\modules\v2\controllers;

use Yii;
use api\modules\v1\controllers\ExploreController as BaseExploreController;
use yii\base\DynamicModel;

use api\modules\v1\models\Restaurant;
use api\modules\v1\models\DealBucket;
/**
 * Explore Controller v2 API
 *
 * @author jayanta kundu created on 23.07.2015
 */
class ExploreController extends BaseExploreController
{
    /**
     * @return explores by city
     * @Note: customize index if you need
     * @author jayanta kundu modified on 10.06.2015
     */
    public function actionIndex(){
        $request = new DynamicModel(['city_id']);
        $request->addRule(['city_id'], 'required');
        $request->attributes = $_GET;
        if ($request->validate()){
            $restaurant = new Restaurant();
            $dealbucket = new DealBucket();

            $model = new $this->modelClass;
            $query = $model->find();
            $query->orderBy(['sort'=>SORT_ASC]);
            $data = [];
            foreach($query->All() as $key=>$row){
                if($row->type=='cuisine'){
                    $outlets = $restaurant->find()->where(['primary_cuisine_id'=>$row->type_id])->count();
                    $data2['name'] = $row->name;
                    $data2['type'] = 'primary_cuisine_id';
                    $data2['id'] = $row->type_id;
                    $data2['count'] = $outlets;
                    $data2['photoUrl'] = Yii::$app->easyImage->iosExploreSrcOf(IMAGE_PATH.'explore/'.$row->image);
                    $data['items'][] = $data2; unset($data2);
                }
            }

            $bucket_query = $dealbucket->getDeals($_GET['city_id']);//print_r($bucket_query->All());exit;
            foreach($bucket_query->All() as $key=>$row){
                $data2['name'] = $row->title;
                $data2['type'] = 'bucket_id';
                $data2['id'] = $row->id;
                $data2['count'] = $row->rescount;
                $data2['photoUrl'] = Yii::$app->easyImage->iosExploreSrcOf(IMAGE_PATH.'deals/'.$row->image);
                $data['items'][] = $data2; unset($data2);

            }
            $totalCount = $restaurant->find()->where(['status'=>1, 'visibility'=>1, 'city_id'=>$_GET['city_id']])->count();
            $data['totalCount'] = $totalCount;
            return $data;
        }else{
            $i = 0;
            foreach($request->getErrors() as $key=>$message){
                $errors[$i]['field']=$key;
                $errors[$i]['message']=$message[0];
                $i++;
            };
            return $errors;
        }
    }
 
 
       
}

