<?php

class MainController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

   public $layout='protected/modules/backend/views/layouts/main';
   
 
    public function accessRules()
    {
                return array(
                             array('allow', // allow admin user to perform 'admin' and 'delete' actions
                                'actions'=>array('delete','index','stats'), 
                                'roles'=>array('admin'), 
                                ),   
                            array('deny', // deny all users
                                 'users' => array('*'),
                            ),

                  );
     }
     
     
     
       
       public function actionDelete($id)
       {  
          $ad = Ad::model()->find('id=:id',array(':id'=>$id)); 
          $oldAd = $ad;
           if ($ad->delete()) {
            $this->photoremove($oldAd);
      //      if (!isset($_GET['ajax'])) {
      //  $this->redirect(Yii::app()->getRequest()->urlReferrer);
 //   }
          $this->render('success_deletion');
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





	public function actionIndex()
	{ 
        $searchForm = new SearchForm(); 
        $activeCity = '';
        $activeCategory = '';
        $type = '';
        $activeProperty = '';
        $activeMainCategory = '';


          

        if (!isset($searchForm->mc))
            $mainCategoryParam = Yii::app()->request->getParam('mc');
        else
            $mainCategoryParam = $searchForm->mc;


        if (!isset($searchForm->ca))
            $categoryParam = Yii::app()->request->getParam('ca');
        else
            $categoryParam = $searchForm->ca;


        if (!isset($searchForm->st))
            $searchTypeParam = Yii::app()->request->getParam('st');
        else
            $searchTypeParam = $searchForm->st;


        if (!isset($searchForm->c))
            $cityParam = Yii::app()->request->getParam('c');
        else
            $cityParam = $searchForm->c;


        if (!$searchForm->condition)
            $conditionParam = Yii::app()->request->getParam('condition');
        else
            $conditionParam = $searchForm->condition;

        if (!$searchForm->photos)
            $photosParam = Yii::app()->request->getParam('photos');
        else
            $photosParam = $searchForm->photos;


        $typeParam = Yii::app()->request->getParam('type');
        $propertyParam = Yii::app()->request->getParam('f');

        $cities = City::model()->findAll(array('order'=>'orderID ASC'));

        $search_params = array();
        $vehiclePriceMinParam = Yii::app()->request->getParam('pm');
        $vehiclePriceMaxParam = Yii::app()->request->getParam('pma');
        $nameParam = Yii::app()->request->getParam('q');
        $criteria = new CDbCriteria;


        $criteria->select = 't.*, cat.name AS categoryName, city.name AS cityName, ai.adID AS pho';
        $criteria->join = 'LEFT JOIN 534q_main_categories main_cat ON main_cat.id = t.mainCategoryID ';
        $criteria->join = 'LEFT JOIN 534q_categories cat ON cat.id = t.categoryID ';
        $criteria->join .= 'LEFT JOIN 534q_city city ON city.id = t.cityID ';
        $criteria->join .= 'LEFT JOIN 534q_ad_image ai ON ai.adID = t.id';
        $criteria->group = 't.id';
  

      //  $criteria->with = array('images');
        $criteria->order= 't.id DESC';

        if($searchTypeParam)
        {
            $criteria->addCondition('t.subtypeID=:subtypeID');
            if ($searchTypeParam == Ad::SALE)
                $search_params[':subtypeID'] = Ad::SALE_VALUE;
            if ($searchTypeParam == Ad::WANTED)
                $search_params[':subtypeID'] = Ad::WANTED_VALUE;
            $searchForm->st = $searchTypeParam;
        }

        if($cityParam)
        {
            $activeCity = City::model()->find('transName=:transName',array(':transName'=>$cityParam));
            $criteria->addCondition('t.cityID=:cityID');
            $search_params[':cityID'] = $activeCity->id;
            $searchForm->c = $activeCity->transName;
        }


        if($nameParam)
        {
            $title = addcslashes($nameParam, '%_');
            $criteria->addCondition('t.name LIKE :title');
            $search_params[':title'] = "%$title%";
            $searchForm->q = $nameParam;
        }


        $main_categories=Main_categories::model()->with('categoriesOrderID')->findAll(array('order'=>'t.orderID ASC'));

        if($categoryParam)
        {
            $activeCategory = Categories::model()->find('transName=:transName',array(':transName'=>$categoryParam));
            $criteria->addCondition('t.categoryID=:categoryID');
            $search_params[':categoryID'] = $activeCategory->id;
            $searchForm->ca = $activeCategory->transName;
        }

        if($mainCategoryParam)
        {
            $activeMainCategory = Main_categories::model()->find('transName=:transName',array(':transName'=>$mainCategoryParam));
            $criteria->addCondition('t.mainCategoryID=:mainCategoryID');
            $search_params[':mainCategoryID'] = $activeMainCategory->id;
            $searchForm->mc = $activeMainCategory->transName;
        }  

        if($typeParam)
        {
            $type = Type::model()->find('transName=:transName',array(':transName'=>$typeParam));
            $criteria->addCondition('t.typeID=:typeID');
            $search_params[':typeID'] = $type->id;
            $searchForm->t = $type->transName;
        }

        if($conditionParam)
        {
            $criteria->addCondition('t.condition=:condition');
            if ($searchTypeParam == Ad::NEW_CONDITION_VALUE)
                $search_params[':condition'] = Ad::NEW_CONDITION_VALUE;
            if ($searchTypeParam == Ad::BU_CONDITION_VALUE)
                $search_params[':condition'] = Ad::BU_CONDITION_VALUE;
            $search_params[':condition'] = $conditionParam;
            $searchForm->condition = $conditionParam;
        }

        if($photosParam)
        {
            $criteria->addCondition('ai.id IS NOT NULL');
            $searchForm->photos = $photosParam;
        }



        if($propertyParam)
        {
            if ($propertyParam != Ad::ALL_PROPERTY) {
                $criteria->addCondition('t.property=:propery');
                if ($propertyParam == Ad::PRIVATE_PROPERTY)
                {
                    $search_params[':propery'] = Ad::PRIVATE_PROPERTY;
                    $activeProperty = Ad::PRIVATE_PROPERTY;
                }
                elseif($propertyParam == Ad::COMPANY_PROPERTY)
                {
                    $search_params[':propery'] = Ad::COMPANY_PROPERTY;
                    $activeProperty = Ad::COMPANY_PROPERTY;
                }
                $searchForm->f = $propertyParam;
            }
        }


        // $criteria->addCondition('t.moderation = :moderation');
        // $search_params[':moderation'] = 1;
        $criteria->addCondition('t.published = :published');

        $search_params[':published'] = 1;


        $criteria->params = $search_params;


        $ads =  new CActiveDataProvider('Ad', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));

        if($categoryParam)
        {
           /* $tops = Top::model()->findAll('finishDate>:finishDate',array(':finishDate'=>date('Y-m-d  H:i:s')));
            $top_array = array();
            foreach ($tops as $top)
                array_push($top_array, $top->adID);
            $topCriteria = new CDbCriteria;
            $topCriteria->condition = $criteria->condition;
            $topCriteria->params = $search_params;
            $topCriteria->join = $criteria->join;
            $topCriteria->addInCondition('t.id', $top_array);
            $topCriteria->order = 'RAND()';
            $topAds = Ad::model()->with('images')->together()->findAll($topCriteria);



            $showcases = Showcase::model()->findAll('finishDate>:finishDate',array(':finishDate'=>date('Y-m-d  H:i:s')));
            $showcase_array = array();
            foreach ($showcases as $showcase)
                array_push($showcase_array, $showcase->adID);
            $showcaseCriteria = new CDbCriteria;
            $showcaseCriteria->condition = $criteria->condition;
            $showcaseCriteria->params = $search_params;
            $showcaseCriteria->join = $criteria->join;
            $showcaseCriteria->addInCondition('t.id', $showcase_array);
            $showcaseCriteria->order = 'RAND()';
            $showcaseCriteria->limit = '3';
            $showcaseAds = Ad::model()->with('images')->together()->findAll($showcaseCriteria);*/
        }
        else
        {
            $topAds = array();
            $showcaseAds = array();
        }




        $this->render('search',
                array(
                    'searchForm'=>$searchForm,
                    'cities'=>$cities,
                    'activeCity'=>$activeCity,
                    'categoryParam'=>$categoryParam,
                    'main_categories'=>$main_categories,
                    'activeMainCategory'=>$activeMainCategory,
                    'ads'=>$ads,
                 //   'topAds'=>$topAds,
                 //   'showcaseAds'=>$showcaseAds,
                    'activeCategory'=>$activeCategory,
                    'type'=>$type,
                    'activeSubtype'=>$searchForm->st,
                    'activeProperty'=>$activeProperty,
                ));
	
	} 
}