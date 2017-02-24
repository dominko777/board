<?php
class HelpController extends ApiController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    { 
        return array( 
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('listMainCategories',
                    'listSubCategories'),
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

    
 

    public function actionListMainCategories()
    {
        $models = Main_categories::model()->findAll();
   
        // Did we get some results?
        if(empty($models)) {
            // No 
            $this->_sendResponse(200,
                    sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
        } else {
            $defaultRow = array('id'=>0,'name'=>'Выберите категорию','transName'=>'','orderID'=>0);
            $rows[] = $defaultRow;
            foreach($models as $model)
            {
                $rows[] = $model->attributes; 
            }
            $this->_sendResponse(200, CJSON::encode($rows));
        }
    }


    public function actionListSubCategories($mainCategoryID)
    {
        $models = Categories::model()->findAll('mainCategoryID=:mainCategoryID',array(':mainCategoryID'=>$mainCategoryID));

        // Did we get some results?
        if(empty($models)) {
            // No
            $this->_sendResponse(200,
                    sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
        } else {
            $defaultRow = array('id'=>0,'name'=>'Выберите подкатегорию','transName'=>'','orderID'=>0);
            $rows[] = $defaultRow;
            foreach($models as $model)
            {
                $rows[] = $model->attributes;
            }
            $this->_sendResponse(200, CJSON::encode($rows));
        }
    }


      


}
