<?php
class AdController extends ApiController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'postOnly + Create',
            'postOnly + Update',  
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('Create','Update','sold','delete','View'),
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




    public function actionCreate()
    {

        $ad = new Ad();
        $ad->scenario='ad_scenario';
        $ad->name = urldecode($_POST['name']);
        $ad->text = urldecode($_POST['desc']);
        $ad->price = $_POST['price'];
        if (isset($_POST['main_category'])) $ad->mainCategoryID = $_POST['main_category'];
        if (isset($_POST['sub_category'])) $ad->categoryID = $_POST['sub_category'];
        $ad->userID = $this->getUser()->id;
        $ad->time = time();
        $ad->published = 1;

        if ($ad->save())
        {
            $imagesArray = array();
            $i=0;
            if ((isset($_FILES['image_1']['tmp_name'])))
            {
                $i++;
                $imagesArray = $imagesArray + array($i=>$_FILES['image_1']['tmp_name']);
            }
            if ((isset($_FILES['image_2']['tmp_name'])))
            {
                $i++;
                $imagesArray = $imagesArray + array($i=>$_FILES['image_2']['tmp_name']);
            }
            if ((isset($_FILES['image_3']['tmp_name'])))
            {
                $i++;
                $imagesArray = $imagesArray + array($i=>$_FILES['image_3']['tmp_name']);
            }
            $cc=0;
            foreach ($imagesArray as $key=>$value)  
            {   $cc++;
                $model = new AdImage();
                $model->adID = $ad->id;

                $model->image = AdImage::generateImageName("jpg");
                $firstSequence = substr($model->image, 0,3);
                $secondSequence = substr($model->image, 3,3);
                $thirdSequence = substr($model->image, 6,3);
                $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';

                if($model->save())
                       {
                               if(!is_dir($uploaddir)) {
                                        if (mkdir($uploaddir, 0755, true))
                                            move_uploaded_file($value, $uploaddir.$model->image);
                               }

                       }
  
            }    
         //   $this->_sendResponse(200, CJSON::encode(array('data'=>array('saved'=>$cc))));
            $this->_sendResponse(200, CJSON::encode(array('data'=>array('saved'=>'true'))));
        }
        else
              $this->_sendResponse(200, CJSON::encode(array('data'=>$ad->getErrors())));
        }



    public function actionView()
    {
        // Check if id was submitted via GET
        if(!isset($_GET['id']))
            $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
 
            $model = Ad::model()->with('user','likes','images')->findByPk($_GET['id']);

        // Did we find the requested model? If not, raise an error
        if(is_null($model))
            $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
        else 
            $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($model)));
    }

    
    public function actionUpdate()
    {
        $user = $this->getUser();   
        $ad = Ad::model()->findByPk($_POST['adID']);  
        $ad->setScenario( 'ad_scenario' );  
        $ad->name = urldecode($_POST['name']);
        $ad->text = urldecode($_POST['desc']);   
        $ad->price = trim($_POST['price']);  
        if (isset($_POST['main_category'])) $ad->mainCategoryID = $_POST['main_category'];
        if (isset($_POST['sub_category'])) $ad->categoryID = $_POST['sub_category'];
        $ad->userID = $user->id;  
        if ($ad->validate())
        {
            if ($ad->update()) {
                $imagesArray = array();
                $i=0;
                if ((isset($_FILES['image_1']['tmp_name'])))
                {
                    $i++;
                    $imagesArray = $imagesArray + array($i=>$_FILES['image_1']['tmp_name']);
                }
                if ((isset($_FILES['image_2']['tmp_name'])))
                {
                    $i++;
                    $imagesArray = $imagesArray + array($i=>$_FILES['image_2']['tmp_name']);
                }
                if ((isset($_FILES['image_3']['tmp_name'])))
                {
                    $i++;
                    $imagesArray = $imagesArray + array($i=>$_FILES['image_3']['tmp_name']);
                }
                $oldAd = $ad;
                $this->photoremove($oldAd);
                foreach ($imagesArray as $key=>$value)
                {
                    $model = new AdImage();
                    $model->adID = $ad->id;

                    $model->image = AdImage::generateImageName("jpg");
                    $firstSequence = substr($model->image, 0,3);
                    $secondSequence = substr($model->image, 3,3);
                    $thirdSequence = substr($model->image, 6,3);
                    $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';

                    if($model->save())
                           {
                                   if(!is_dir($uploaddir)) {
                                            if (mkdir($uploaddir, 0755, true))
                                                move_uploaded_file($value, $uploaddir.$model->image);
                                   }

                           }

                }
            }
            $this->_sendResponse(200, CJSON::encode(array('data'=>array('saved'=>'true'))));
        }  
        else
              $this->_sendResponse(200, CJSON::encode(array('data'=>$ad->getErrors())));   
        }



    public function photoremove($ad){

        $photos = AdImage::model()->findAll('adID=:adID',array(':adID'=>$ad->id));
        foreach ($photos as $model)
        {
            $firstSequence = substr($model->image, 0,3);
            $secondSequence = substr($model->image, 3,3);
            $thirdSequence = substr($model->image, 6,3);
            $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            if ($model->delete())
                unlink($uploaddir.$model->image);  
       }
    }

    public function actionSold()
    {
        $ad = Ad::model()->findByPk($_GET['id']);  
        $ad->scenario='ad_scenario';
        $ad->soldStatus = 1;
        $ad->soldTime = time();    
        if ($ad->userID == $this->getUser()->id)
        if($ad->update()){  
           $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($ad))); 
        }
 
    }

    public function actionDelete()
    {
        $ad = Ad::model()->findByPk($_GET['id']);
        $oldAd = $ad;
        if ($ad->userID == $this->getUser()->id)
        if($ad->delete()){
            {
                $this->photoremove($oldAd);  
                $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($oldAd)));
            }
        }

    }
}
