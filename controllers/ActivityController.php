<?php

class ActivityController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('error'),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('index','users','sold'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
	{
        $this->processPageRequest('page');
        $criteria = new CDbCriteria;
        $criteria->select = 't.time, t.name, t.time, u.fio AS userLogin, u.avatar AS userAvatar, u.urlID AS userUrlID';
        $criteria->join .= ' LEFT JOIN 534q_relationship r ON r.followed_id = t.userID '; 
        $criteria->join .= ' LEFT JOIN 534q_user u ON r.followed_id = u.id ';
        $criteria->condition = 'r.follower_id=:follower_id AND t.time != 0';
        $criteria->params = array(':follower_id'=>Yii::app()->user->id);
        $criteria->order = 't.time DESC';
        $criteria->with = 'images';
        $newAds = new CActiveDataProvider('Ad', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' =>'page',
                'pageSize' => 10,
            ),
        ));

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_index_ajax', array(
                'newAds'=>$newAds,
            ));
            Yii::app()->end();
        }
        else
           $this->render('index',
                array('newAds'=>$newAds));
    }

 
 

    public function actionSold()
	{
        $this->processPageRequest('page');
        $criteria = new CDbCriteria;
        $criteria->select = 't.time, t.name, t.time, u.fio AS userLogin, u.avatar AS userAvatar, u.urlID AS userUrlID';
        $criteria->join .= ' LEFT JOIN 534q_relationship r ON r.followed_id = t.userID ';
        $criteria->join .= ' LEFT JOIN 534q_user u ON r.followed_id = u.id ';
        $criteria->condition = 'r.follower_id=:follower_id AND soldTime != 0';
        $criteria->params = array(':follower_id'=>Yii::app()->user->id);
        $criteria->order = 't.soldTime DESC';
        $soldAds = new CActiveDataProvider('Ad', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' =>'page',
                'pageSize' => 10,
            ),
        ));

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_sold_ajax', array(
                'soldAds'=>$soldAds,
            ));
            Yii::app()->end();
        }
        else
           $this->render('sold',
                array('soldAds'=>$soldAds));
    }

    public function actionUsers()
	{
        $this->processPageRequest('page'); 
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, u.fio AS userLogin, u.avatar AS userAvatar, u.urlID AS userUrlID';
        $criteria->join .= ' LEFT JOIN 534q_user u ON t.follower_id = u.id ';
        $criteria->condition = 't.followed_id=:followed_id';
        $criteria->params = array(':followed_id'=>Yii::app()->user->id);
        $criteria->order = 't.time DESC';
        $followers = new CActiveDataProvider('Relationship', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' =>'page',
                'pageSize' => 10,
            ),
        ));

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_users_ajax', array(
                'followers'=>$followers,
            ));
            Yii::app()->end();
        }
        else
           $this->render('users', 
                array('followers'=>$followers));
    }

    public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
}
 
