<?php

class GroupController extends Controller
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
                'actions'=>array('view'),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('new', 'edit'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionNew()
    {
        $this->setPageTitle('Создать группу');
        $model = new Group;
        $model->owner_id = Yii::app()->user->id;
        $model->creation_time = time(); 
        $model->publicity = Group::PUBLIC_TYPE;
        $model->status = '';

        if(isset($_POST['Group']))
        {
            $model->attributes=$_POST['Group'];
            $photo=CUploadedFile::getInstance($model,'photo');
            $extension = substr($photo, strrpos($photo, '.')+1);
            $model->photo = Group::generateImageName($extension);
            if($model->save())  
            {
                $photo->saveAs(Yii::getPathOfAlias('webroot').'/images/groups/'.$model->photo);
                Yii::app()->user->setFlash('success', 'Вы успешно создали группу');
                $this->redirect(Yii::app()->createUrl('group/view',array('id'=>$model->id)));
            }   
        }
        $this->render('new',array( 'model'=>$model));
    }
    public function actionEdit($id)
    {
        $this->setPageTitle('Редактировать группу');
        $model = Group::model()->findByPk($id);
        $oldPhoto = $model->photo;
  
        if(isset($_POST['Group']))
        {
            $model->attributes=$_POST['Group'];
            $photo=CUploadedFile::getInstance($model,'photo');
            $extension = substr($photo, strrpos($photo, '.')+1);
            $model->photo = Group::generateImageName($extension);
            if($model->save())
            {
                unlink(Yii::getPathOfAlias('webroot').'/images/groups/'.$oldPhoto);  
                $photo->saveAs(Yii::getPathOfAlias('webroot').'/images/groups/'.$model->photo);
                $this->redirect(Yii::app()->createUrl('group/view',array('id'=>$model->id)));
            }
        }
        $this->render('edit',array( 'model'=>$model));
    }



    public function actionView($id){   
        $model = Group::model()->findByPk($id);
      /* $criteria = new CDbCriteria;      
       $criteria->join = 'LEFT JOIN 534q_group_products gp ON t.id = gp.ad_id ';
       $criteria->join .= 'LEFT JOIN 534q_group g ON g.group_id = '.$model->id;
	 /*  $criteria->condition = "t.userID=:userID AND published=:published";
	   $criteria->params = array(':userID'=>$user->id, ':published'=>1);
       $criteria->group='t.id';
       $criteria->order= 't.id DESC';
       $criteria->with=array('likes');
        $ads =  new CActiveDataProvider('Ad', array(  
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),;
        )); */

       $criteria = new CDbCriteria;  
       $criteria->join = 'LEFT JOIN 534q_group_products gp ON t.id = gp.ad_id ';
	   $criteria->condition = "gp.group_id=:group_id AND published=:published";
	   $criteria->params = array(':group_id'=>$model->id, ':published'=>1);
       $criteria->group='t.id';  
       $criteria->order= 't.id DESC';
       $criteria->with=array('likes');
       $ads  =  new CActiveDataProvider('Ad', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));




        $this->render('view',array(
                                  'model'=>$model,
                                  'ads'=>$ads  
                             ));
    }

    

}
