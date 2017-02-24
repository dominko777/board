<?php

class AdController extends Controller
{

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
                'actions'=>array('getCarModel','view','shop','GetCategories','GetSearchCategories'),
                'users'=>array('*'),
            ), 
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('like','makesold','edit','adajaxvalidation','getTypes','favorite', 'delete','validateEdit','photoremove','showadimages','verify','edit','new','validate','getcategoryinteresttypes','photoUpload'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionView($name){

        $ad = Ad::model()->with(array('isliked'=>array('condition'=>'userID=:userID', 'params'=>array(':userID'=>Yii::app()->user->id))),
            'countlikes','city','mcategory', 'categories','user','images')->find('t.transName=:transName',array(':transName'=>$name));
        $userAds = Ad::model()->with('likes','images')->findAll(array('condition'=>'t.id != :id AND userID=:userID','params'=>array(':id'=>$ad->id, ':userID'=>$ad->userID),'limit'=>'4','order'=>'RAND()'));
        $similarAds = Ad::model()
                ->with('likes', 'images')
                ->findAll(array('condition'=>'t.id != :id AND mainCategoryID=:mainCategoryID','params'=>array(':id'=>$ad->id, ':mainCategoryID'=>$ad->mainCategoryID),'limit'=>'4','order'=>'RAND()'));

        // поиск или создание live пользователя
         if (Yii::app()->user->isGuest)
		$this->createLive($ad);
        else if ($ad->userID != Yii::app()->user->id)
        	$this->createLive($ad);
	

        $this->render('view', array('similarAds'=>$similarAds,'userAds'=>$userAds, 'ad'=>$ad));
    }

	public function actionNew()
	{
        $main_categories=Main_categories::model()->findAll(array('order'=>'t.orderID ASC'));
        $user=User::model()->findByPk(Yii::app()->user->id);
        $model = new Ad;
        if(isset($_POST['Ad']))
        {
            // populate input data to $a and $b
            $model->attributes=$_POST['Ad'];
            $model->published=1;
            if($model->validate())
            {
                // use false parameter to disable validation
                if ($model->save())
                {

                }
            }
        }

		$this->render('_ad_form',
            array('main_categories'=>$main_categories,
                  'model'=>$model,
                  'edit'=>false,
                  'user'=>$user,
            )
        );
	}
    
  
	public function actionLike($name){ 
        $ad = Ad::model()->find('t.transName=:transName',array(':transName'=>$name));
        $adLike = AdLike::model()->find('adID=:adID AND userID=:userID',array(':adID'=>$ad->id,':userID'=>Yii::app()->user->id));
        if (empty($adLike)){
            $newAdLike = new AdLike();
            $newAdLike->adID = $ad->id;
            $newAdLike->userID = Yii::app()->user->id;
            if ($newAdLike->save())
            {
                $likeWasSaved = true;
            }

        }
        else
        {   
            if ($adLike->delete())
            {
                $likeWasSaved = false; 
            }
        }
        $response = array('likeWasSaved'=>$likeWasSaved);
        echo json_encode($response);

    }
	
    private function createLive($ad){
    		$newLive = new Live();
    	        $newLive->adID = $ad->id;
		$newLive->liveUserId = LiveUser::getLiveUserId();
		$newLive->date = date("Y-m-d H:i:s"); 
		$newLive->save();
    }

    public function actionVerify($id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*,type.name AS typeName, cat.name AS categoryName,mc.name AS mainCategoryName, city.name AS cityName, user.fio AS userFio, user.email AS userEmail';

        $criteria->join = ' LEFT JOIN 534q_main_categories mc ON mc.id = t.mainCategoryID ';
        $criteria->join .= 'LEFT JOIN 534q_categories cat ON cat.id = t.categoryID ';
        $criteria->join .= 'LEFT JOIN 534q_type type ON type.id = t.typeID ';
        $criteria->join .= 'LEFT JOIN 534q_city city ON city.id = t.cityID ';
        $criteria->join .= 'LEFT JOIN 534q_user user ON t.userID = user.id ';
        $criteria->order= 't.id DESC';
        $criteria->condition = 't.transName=:transName';
        $criteria->params = array(':transName'=>$id);
        $criteria->with = array('images');
        $ad = Ad::model()->find($criteria);

        if(isset($_POST['Ad']))
        {
            //$ad->published=$_POST['Ad']['published'];
            $ad->published=1;
            if($ad->update())
            {
                $urlPublish = Yii::app()->createurl('ad/user',array('id'=>Yii::app()->user->getUrlID()));
                $this->redirect($urlPublish);
            }
        }


        $main_categories=Main_categories::model()->findAll(array('order'=>'t.orderID ASC'));

        $this->render('verify',
            array('main_categories'=>$main_categories,
                  'ad'=>$ad,
            )
        );
    }

    public function actionDelete()
    {
        $ad = Ad::model()->find('transName=:transName',array(':transName'=>$_POST['id']));
        $oldAd = $ad;
        if ($ad->delete()) {

            $response = array('modelDeleted'=>true);
            echo json_encode($response);
            $this->photoremove($oldAd);   
        }

    }


    public function photoremove($ad){

        $photos = AdImage::model()->findAll('adID=:adID',array(':adID'=>$ad->id));
        foreach ($photos as $model)
        {      
            $firstSequence = substr($model->image, 0,3);
            $secondSequence = substr($model->image, 3,3);
            $thirdSequence = substr($model->image, 6,3);
            $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            $thumbDir = Yii::getPathOfAlias('webroot').'/images/bigthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            $dzthumbDir = Yii::getPathOfAlias('webroot').'/images/dzthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            if ($model->delete())
            {
                unlink($uploaddir.$model->image);
                unlink($thumbDir.$model->image);
                unlink($dzthumbDir.$model->image);
            }
       }
    }

    public function actionPhotoremove(){
        $id_img = $_GET['id_img'];
        $model = AdImage::model()->findByPk($id_img);
        $firstSequence = substr($model->image, 0,3);
        $secondSequence = substr($model->image, 3,3);
        $thirdSequence = substr($model->image, 6,3);
        $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
        $thumbDir = Yii::getPathOfAlias('webroot').'/images/bigthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
        $dzthumbDir = Yii::getPathOfAlias('webroot').'/images/dzthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
        if ($model->delete())
        {
            unlink($uploaddir.$model->image);
            unlink($thumbDir.$model->image);
            unlink($dzthumbDir.$model->image);
        }
    }



    public function actionEdit($id)  
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, cat.name AS categoryName, city.name AS cityName, user.fio AS userFio, user.email AS userEmail';
        $criteria->join = 'LEFT JOIN 534q_categories cat ON cat.id = t.categoryID ';
        $criteria->join .= 'LEFT JOIN 534q_city city ON city.id = t.cityID ';
        $criteria->join .= 'LEFT JOIN 534q_user user ON t.userID = user.id';
        $criteria->order= 't.id DESC';
        $criteria->condition = 't.transName=:transName';
        $criteria->params = array(':transName'=>$id);
        $model = Ad::model()->find($criteria);
        $main_categories=Main_categories::model()->findAll(array('order'=>'t.orderID ASC'));
        $this->render('_ad_form',
            array('model'=>$model,
                  'main_categories'=>$main_categories,
                   'edit'=>true)
        );
    }

    public function actionValidate(){

        $model = new Ad;


        $model->scenario='ad_scenario';
        if(isset($_POST['Ad']))
        {
            $model->attributes=$_POST['Ad'];
            $model->time = time();  
            $model->moderation = 0;
            $model->userID = Yii::app()->user->id;
            $model->published = 0;

            if (empty($model->cityID))
                $model->cityID = '';
            else
                $model->cityID = City::model()->find('t.orderID=:orderID',array(':orderID'=>$model->cityID))->id;

            if (empty($model->mainCategoryID))
                $model->mainCategoryID = '';
            else
                $model->mainCategoryID = Main_categories::model()->find('t.transName=:transName',array(':transName'=>$model->mainCategoryID))->id;

            if (empty($model->categoryID))
                $model->categoryID = 0;
            else
                $model->categoryID = Categories::model()->find('t.transName=:transName',array(':transName'=>$model->categoryID))->id;

            if (empty($model->typeID))
                $model->typeID = 0;
            else
                $model->typeID = Type::model()->find('t.transName=:transName',array(':transName'=>$model->typeID))->id;

            if($model->validate())
            {
                // use false parameter to disable validation
                if ($model->save())
                {
                    echo json_encode(array('transName'=>$model->transName));
                }
            }
            else
                echo CJSON::encode($model->getErrors());
        }
    }

    public function actionValidateEdit(){
        if(isset($_POST['Ad']))
        {
            $model = Ad::model()->find('transName=:transName',array(':transName'=>$_POST['Ad']['transName']));
            $model->scenario='ad_scenario';
            $model->attributes=$_POST['Ad'];
            if (empty($model->cityID))
                $model->cityID = '';
            else
                $model->cityID = City::model()->find('t.orderID=:orderID',array(':orderID'=>$model->cityID))->id;

            if (empty($model->mainCategoryID))
                $model->mainCategoryID = '';
            else
                $model->mainCategoryID = Main_categories::model()->find('t.transName=:transName',array(':transName'=>$model->mainCategoryID))->id;

            if (empty($model->categoryID))
                $model->categoryID = 0;
            else
                $model->categoryID = Categories::model()->find('t.transName=:transName',array(':transName'=>$model->categoryID))->id;

            if (empty($model->typeID))
                $model->typeID = 0;
            else
                $model->typeID = Type::model()->find('t.transName=:transName',array(':transName'=>$model->typeID))->id;


            if($model->validate())
            {
                // use false parameter to disable validation
                if ($model->update())
                {
                    echo json_encode(array('transName'=>$model->transName));
                }
            }
            else
                echo CJSON::encode($model->getErrors());
        }
    }

   /* public function actionPhotoUpload()
    {
       // $resultsStack = array();
        if ($_FILES['file']) {
            $file_ary = $this->reArrayFiles($_FILES['file']);
            foreach ($file_ary as $file) {
                /$this->upload($file['name'], $file['type'], $file['size'], $file['tmp_name'], $_POST['Ad']['urlID']);
              //  array_push($resultsStack, $res);
            }
           // echo json_encode($resultsStack);
        }
    }*/


    public function actionPhotoUpload()
    {
        $fName = $_FILES['file']['name'];
        $fType = $_FILES['file']['type'];
        $fSize = $_FILES['file']['size'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $adUrlID = $_POST['Ad']['transName'];

        $model = new AdImage();
        $erroris = false;
        $etype = '0';
        $imageID = '';
        $imgArray[] = array();
        if (!empty($_FILES)) {
            $name = $fName;
            $tempFile = $tmp_name;
            $model->adID = Ad::model()->find('transName=:transName',array(':transName'=>$adUrlID))->id;
            $extension = substr($name, strrpos($name, '.')+1);
            $model->image = AdImage::generateImageName($extension);

            $firstSequence = substr($model->image, 0,3);
            $secondSequence = substr($model->image, 3,3);
            $thirdSequence = substr($model->image, 6,3);
            $uploaddir = Yii::getPathOfAlias('webroot').'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            $thumbDir = Yii::getPathOfAlias('webroot').'/images/bigthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
            $dzthumbDir = Yii::getPathOfAlias('webroot').'/images/dzthumbs/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';

            $size = $fSize;
            if (AdImage::model()->count('adID=:adID', array(':adID' => $model->adID)) < 5)
            {
                if (($size < 5000000) && ($size>0))
                {
                //    if ((($extension == "png")
                //            || ($extension == "jpeg")
                //            || ($extension == "jpg") || ($extension == "JPG")) &&
                //        (($fType == "image/jpeg") || ($fType == "image/png")))
                //    {
                        if (is_uploaded_file($tempFile)) {
                            $uploadfile = $uploaddir . $model->image;
                            if($model->save())
                            {
                                if(!is_dir($uploaddir)) {
                                    if (mkdir($uploaddir, 0755, true));
                                }

                                if(!is_dir($thumbDir)) {
                                    if (mkdir($thumbDir, 0755, true));
                                }

                                if(!is_dir($dzthumbDir)) {
                                    if (mkdir($dzthumbDir, 0755, true));
                                }

                                move_uploaded_file($tempFile, $uploadfile);
                                $thumb=Yii::app()->phpThumb->create($uploadfile);
                                $thumb->adaptiveResize(128,96);
                                $thumb->save($thumbDir . $model->image);

                                $thumb=Yii::app()->phpThumb->create($uploadfile);
                                $thumb->adaptiveResize(120,120);
                                $thumb->save($dzthumbDir . $model->image);

                                $erroris = false;
                                $imageID = $model->id;
                            }
                            else {
                                $erroris = true;
                                $etype = Yii::t('messages', 'Try again');
                            }
                        }
                        else {
                            $erroris = true;
                            $etype = Yii::t('messages', 'Try again');
                        }
                //    }
                 //   else {
                 //       $erroris = true;
                 //       $etype = Yii::t('messages', 'Image formats only: jpg, jpeg and png');
                 //   }
                } 
                else
                {
                    $erroris = true;
                    $etype = Yii::t('messages', 'Files  - if < 5Mb');
                }
            } 
            else {
                $erroris = true;
                $etype =  Yii::t('messages', 'You can upload only 5 photos');
            }
        }

        $result = array(
            'erroris' => $erroris,
            'etype' => $etype,
            'imageID'=>$imageID,
            'imgArray'=>$imgArray,
        );
        echo json_encode($result);
    }





    public function actionGetCategories(){
        $categories = Categories::model()->findAll(array('order'=>'t.name ASC','condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>$_POST['Ad']['mainCategoryID'])));
        $data=CHtml::listData($categories,'id','name');    
        echo CHtml::tag('option',
            array('value'=>''),CHtml::encode(Yii::t('messages', 'Select subcategory')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }

    public function actionGetSearchCategories(){
        $mc = Main_categories::model()->find('transName=:transName',array(':transName'=>$_GET['cmTransName']));
        if (empty($mc))
            echo '<option selected="selected" value="">Выберите подкатегорию</option>';
        else
        {
            $categories = Categories::model()->findAll(array('order'=>'t.name ASC','condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>$mc->id)));
            $data=CHtml::listData($categories,'transName','name');
            echo CHtml::tag('option',
                array('value'=>''),CHtml::encode(Yii::t('messages', 'Select subcategory')),true);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',
                    array('value'=>$value),CHtml::encode($name),true);
            }
        }
    }

    /*function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }*/

    public function actionShowadimages($id){

        $imgArray = array();
        $ad = Ad::model()->findByPk($id);
        $images = AdImage::model()->findAll('adID=:adID', array(':adID' => $ad->id));
        $i=0;
        foreach ($images as $image)
        {
            $imgArray[$image -> id] = $image -> image;
            $i++;
        }
        $result[] = array(
            'imgArray'=>$imgArray,
        );
        echo json_encode($result);
    }




    public function viewAdGetFields($ad){
        $searchForm = new SearchForm();
        $searchForm->ca = $ad->categoryID;
        $searchForm->st = $ad->subtypeID;
        $searchForm->type = SearchForm::VIEW_AD;
        $searchForm->stepParam = SearchForm::GET_FIELDS;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm,'ad'=>$ad));
    }

    public function editAdGetSubtypes($ad){
        $searchForm = new SearchForm();
        $searchForm->ca = $ad->categoryID;
        $searchForm->st = $ad->subtypeID;
        $searchForm->type = SearchForm::EDIT_AD;
        $searchForm->stepParam = SearchForm::GET_SUBTYPE;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm));
    }

    public function editAdGetFields($ad){
        $searchForm = new SearchForm();
        $searchForm->ca = $ad->categoryID;
        $searchForm->st = $ad->subtypeID;
        $searchForm->type = SearchForm::EDIT_AD;
        $searchForm->stepParam = SearchForm::GET_FIELDS;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm,'ad'=>$ad));
    }










    public function actionFavorite($favTransName){
        $ad = Ad::model()->find('transName=:transName',array(':transName'=>$favTransName));
        $favorite = new Favorite();
        $favorite->adID = $ad->id;
        $favorite->userID = Yii::app()->user->id;
        if ($favorite->save())
            echo $ad->transName;
    }

    public function actionGetTypes($caTransName){
        $category = Categories::model()->find('transName=:transName',array(':transName'=>$caTransName));
        $types = Type::model()->findAll(array('order'=>'t.name ASC','condition'=>'categoryID=:categoryID','params'=>array(':categoryID'=>$category->id)));
        $data=CHtml::listData($types,'transName','name');
        echo CHtml::tag('option',
            array('value'=>''),CHtml::encode(Yii::t('messages', 'Select type')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }


   
    public function actionAdajaxvalidation()
        {
                if(isset($_POST['ajax']) && $_POST['ajax']==='ad-form')
                {
                        if (empty($_POST['Ad']['id']))
                            $model = new Ad;
                        else
                            $model = Ad::model()->findByPk($_POST['Ad']['id']);
                        $model->userID = Yii::app()->user->id;
                        $model->time = time();
                        $model->published = 1;
                        $model->scenario = 'ad_scenario';
                        $model->attributes = $_POST['Ad'];
                        $errors = CActiveForm::validate($model);  
                        if ($errors !== '[]') {
                           echo $errors;
                           Yii::app()->end();
                        }
                        else
                        {
                            if (empty($_POST['Ad']['id']))
                            {
                                if ($model->save())
                                {
                                    $ad = Ad::model()->findByPk($model->id);
                                    $response = array('message'=>true, 'id'=>$ad->id,'transName'=>$ad->transName);
                                    echo json_encode($response);
                                }
                            }
                            else
                                if ($model->update())
                                {
                                     $response = array('message'=>true, 'id'=>$model->id,'transName'=>$model->transName);
                                     echo json_encode($response);
                                }
                            }

                        
                }
        }


       public function actionMakesold($id){
           $ad = Ad::model()->findByPk($id);
           $ad->soldStatus = 1;
           $ad->soldTime = time();
           if ($ad->save())
           {
               $response = array('modelSaved'=>true);
               echo json_encode($response);   
           }
       }

}
