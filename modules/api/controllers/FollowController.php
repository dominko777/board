<?php
class FollowController extends ApiController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'postOnly + Create',
            'postOnly + like'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('Listuser','List','delete','Create','Like'),
                'users'=>array('*'),  
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array(),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionList()
    {
        if ($_GET['type']=='followed')
        {
            $criteria = new CDbCriteria;
            $criteria->condition='follower_id=:follower_id';
            $criteria->params=array(':follower_id'=>$this->getUser()->id);
            $criteria->with = array('followed');
            $criteria->order= 't.id DESC';  
            $relations = Relationship::model()->findAll($criteria);
            $followIdsArray = array();
            foreach ($relations as $relation){
                array_push($followIdsArray, $relation->followed->id);
            }
        }
        elseif ($_GET['type']=='following'){
            $criteria = new CDbCriteria;
            $criteria->condition='followed_id=:followed_id';
            $criteria->params=array(':followed_id'=>$this->getUser()->id);
            $criteria->with = array('follower');
            $criteria->order= 't.id DESC';
           $relations = Relationship::model()->findAll($criteria);
            $followIdsArray = array();
            foreach ($relations as $relation){
                array_push($followIdsArray, $relation->follower->id);
            }
        }

 
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$followIdsArray);
        $criteria->order= 't.fio ASC';

        $jSonActiveDataProvider = new JSonActiveDataProvider('User', array(
                'criteria'=>$criteria,
                'pagination'=>array('currentPage'=>$_GET['page'],'pageSize'=>20)));
        $this->_sendResponse(200, $jSonActiveDataProvider->getJsonData());
    }


    public function actionListuser()
    {
        if ($_GET['type']=='followed')
        {
            $criteria = new CDbCriteria;
            $criteria->condition='follower_id=:follower_id';
            $criteria->params=array(':follower_id'=>$_GET['user']);
            $criteria->with = array('followed');
            $criteria->order= 't.id DESC';
            $relations = Relationship::model()->findAll($criteria);
            $followIdsArray = array();
            foreach ($relations as $relation){
                array_push($followIdsArray, $relation->followed->id);
            }
        }
        elseif ($_GET['type']=='following'){
            $criteria = new CDbCriteria;
            $criteria->condition='followed_id=:followed_id';
            $criteria->params=array(':followed_id'=>$_GET['user']);
            $criteria->with = array('follower');
            $criteria->order= 't.id DESC';
           $relations = Relationship::model()->findAll($criteria);
            $followIdsArray = array();
            foreach ($relations as $relation){
                array_push($followIdsArray, $relation->follower->id);
            }
        }  


        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$followIdsArray);
        $criteria->order= 't.fio ASC';

        $jSonActiveDataProvider = new JSonActiveDataProvider('User', array(
                'criteria'=>$criteria,
                'pagination'=>array('currentPage'=>$_GET['page'],'pageSize'=>20)));
        $this->_sendResponse(200, $jSonActiveDataProvider->getJsonData());
    }

    public function actionCreate()
    {   
        $relation = new Relationship();
        $relation->follower_id = $this->getUser()->id;
        $relation->followed_id = $_GET['id'];
        $relation->time = time();  
        if ($relation->save())
            $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($relation)));
    }

    public function actionDelete()
    {  
        $relation = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>$this->getUser()->id, ':followed_id'=>$_GET['id']));
        $oldRelation = $relation;  
        if ($relation->delete())
            $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($oldRelation)));

    }

     public function actionLike()
    {
        $userId =  $this->getUser()->id;
        $like = AdLike::model()->find('userID=:userID AND adID=:adID',array(':userID'=>$userId,':adID'=>$_POST['adID']));
        if (empty($like))
        {
            $like = new AdLike();
            $like->userID = $this->getUser()->id;
            $like->adID = $_POST['adID'];
            if ($like->save())
                $this->_sendResponse(200, CJSON::encode(array('like'=>"true")));
        }
        else
            if ($like->delete())
                $this->_sendResponse(200, CJSON::encode(array('like'=>"false")));

    }




}
 
