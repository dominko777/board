<?php

class SiteController extends Controller
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
                'actions'=>array('index','error','search','login','help','contact',
                    'searchType','tost',
                    'searchTypeMaincategory',
                    'searchTypeMaincategoryCategory',
                    'searchTypeMaincategoryCategoryCity'),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('newAdGetSubtypeField','newAdGetFields','test'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * This is the main 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $searchForm = new SearchForm();
        $mainCategories = Main_categories::model()->with('categoriesOrderID')->findAll(array('order'=>'t.orderID ASC'));


        $adsCategoryOne = Ad::model()->with('likes','images','countlikes')->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>1),'limit'=>6, 'order'=>'id DESC'));
        $adsCategoryTwo = Ad::model()->with('likes','images','countlikes')->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>2),'limit'=>6, 'order'=>'id DESC'));
        $adsCategoryThree = Ad::model()->with('likes','images','countlikes')->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>6),'limit'=>6, 'order'=>'id DESC'));
        $adsCategoryFour = Ad::model()->with('likes','images','countlikes')->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>7),'limit'=>6, 'order'=>'id DESC'));
        $adsCategoryFive = Ad::model()->with('likes','images','countlikes')->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>8),'limit'=>6, 'order'=>'id DESC'));

       
		$this->render('index',array( 
            'mainCategories'=>$mainCategories,
            'searchForm'=>$searchForm,
            'adsCategoryOne'=>$adsCategoryOne,
            'adsCategoryTwo'=>$adsCategoryTwo,
            'adsCategoryThree'=>$adsCategoryThree,
            'adsCategoryFour'=>$adsCategoryFour,
            'adsCategoryFive'=>$adsCategoryFive,
        ));
	}

    public function actionHelp()
    {
        // renders the view file 'protected/views/site/_ad_form.php'
        // using the main layout 'protected/views/layouts/main.php'
        $this->render('help');
    }

    /*public function actionTost()
    {
        $code = $_GET['code'];  
        $code = trim($code);
        $code = stripslashes($code);
        $code = htmlspecialchars($code);

        $host='localhost';
        $database='proda99_newbase';  
        $user='proda99_mine';
        $pswd='dominko75';
        $dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
        mysql_select_db($database) or die("Не могу подключиться к базе.");   

        $query = mysql_query("SELECT * FROM traffic where (period=CURDATE() AND code='".$code."')");
        $num_rows = mysql_num_rows($query);
        if ($num_rows==0)
        {
             $query = "INSERT INTO traffic (period, code, raw_count) VALUES (now(), '".$code."', 1)";
             mysql_query($query);
             $count=1;
        }   
        else
        {
            mysql_query("UPDATE traffic SET raw_count=raw_count+1  where (period=CURDATE() AND code='".$code."')");
            while($row = mysql_fetch_object($query)){
               $count=$row->raw_count+1;
            }
        }
        echo $count;   
        $this->render('test');
    }*/

	/**
	 * This is the action to handle external exceptions.
	 */
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

    public function actionTest()
    {

        $this->render('test', array());

    }




	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{

		$this->render('contact');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$service = Yii::app()->request->getQuery('service');
	    if (isset($service)) {
	    $authIdentity = Yii::app()->eauth->getIdentity($service);
	    $authIdentity->redirectUrl = Yii::app()->user->returnUrl; 
	    $authIdentity->cancelUrl = $this->createAbsoluteUrl('site/login');

        		try {
				if ($authIdentity->authenticate()) {
					$identity = new ServiceUserIdentity($authIdentity);

                // Успешный вход
                if ($identity->authenticate()) {
                    Yii::app()->user->login($identity);

                    // Специальный редирект с закрытием popup окна
                    $session = Yii::app()->session;
						$session['eauth_profile'] = $authIdentity->attributes;
                    $authIdentity->redirect();
                }
                else {
                    // Закрываем popup окно и перенаправляем на cancelUrl
                    $authIdentity->cancel();
                }  
				}
				// Something went wrong, redirect back to login page
				$this->redirect(array('site/login'));
			}
			catch (EAuthException $e) {
				// save authentication error to session
				Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());
				// close popup window and redirect to cancelUrl
				$authIdentity->redirect($authIdentity->getCancelUrl());  
			}

	    if ($authIdentity->authenticate()) {
	        $identity = new ServiceUserIdentity($authIdentity);

	        // Успешный вход
	        if ($identity->authenticate()) {
	            Yii::app()->user->login($identity);

	            // Специальный редирект с закрытием popup окна
	            $authIdentity->redirect();
	        }
	        else {
	            // Закрываем popup окно и перенаправляем на cancelUrl
	            $authIdentity->cancel();
	        }
	    }  

	    // Что-то пошло не так, перенаправляем на страницу входа
	    $this->redirect(array('site/login'));
	} 
	}



    public function getOptions($filter, $filter_pair, $searchForm){
         $catalogues = Catalogue::model()->findAll(array('order'=>'orderID ASC','condition'=>'filterID=:filterID','params'=>array(':filterID'=>$filter->id)));
         switch ($filter->types->name) {
             case 'select': if (!empty($filter_pair))
                                 switch ($filter_pair->ftype->name) {
                                     case 'maxmin': echo '<select  onchange="maxmin(\''.$filter_pair->filter_parent->abbr.'\',\''.$filter_pair->filter_child->abbr.'\');" id="'.$filter->abbr.'" name="'.$filter->abbr.'">'; break;
                                     case 'dependable': echo '<select  onchange="dependable(\''.$filter_pair->filter_parent->abbr.'\',\''.$filter_pair->filter_child->abbr.'\');" id="'.$filter->abbr.'" name="'.$filter->abbr.'">'; break;
                                  }
                             else
                                 echo '<select id="'.$filter->abbr.'" name="'.$filter->abbr.'">';

                             $field = SearchForm::getField($searchForm, $filter->abbr);
                             if($field) {
                                 echo '<option  value="">'.$filter->prompt_cn.'</option>';
                                 foreach ($catalogues as $catalogue):
                                     if ($field == $catalogue->orderID)
                                         echo  '<option selected="selected" value="'.$catalogue->orderID.'">'.$catalogue->name.'</option>';
                                     else
                                         echo  '<option value="'.$catalogue->orderID.'">'.$catalogue->name.'</option>';
                                 endforeach;
                             }
                             else
                             {
                                 echo '<option selected="selected" value="">'.$filter->prompt_cn.'</option>';
                                 foreach ($catalogues as $catalogue):
                                                  echo  '<option value="'.$catalogue->orderID.'">'.$catalogue->name.'</option>';
                                 endforeach;
                             }
                             echo '</select>';
                             break;
             
             case 'color':   echo '<div class="sb_advfield noborder colors">';
                                      echo '<a class="sb_color Bianco " title="Bianco" onclick="return select_color(this)" id="color_1" href="#"><div></div></a>';
                                      echo '<a class="sb_color Grigio " title="Grigio" onclick="return select_color(this)" id="color_2" href="#"><div></div></a>';
                                      echo '<a class="sb_color Marrone " title="Marrone" onclick="return select_color(this)" id="color_3" href="#"><div></div></a>';
                                      echo '<a class="sb_color Nero" title="Nero" onclick="return select_color(this)" id="color_4" href="#"><div></div></a>';
                                      echo '<a class="sb_color Rosso " title="Rosso" onclick="return select_color(this)" id="color_5" href="#"><div></div></a>';
                                      echo '<a class="sb_color Giallo " title="Giallo" onclick="return select_color(this)" id="color_6" href="#"><div></div></a>';
                                      echo '<a class="sb_color Verde " title="Verde" onclick="return select_color(this)" id="color_7" href="#"><div></div></a>';
                                      echo '<input type="hidden" value="" name="clr" id="clr">';
                                echo '</div>';
                             break; 
         }
    }

    public function actionNewAdGetSubtypeField($catId){
        $category = Categories::model()->find('orderID=:orderID',array(':orderID'=>$catId));
        $searchForm = new SearchForm();
        $searchForm->ca = $category->orderID;
        $searchForm->st = Ad::SALE;
        $searchForm->type = SearchForm::NEW_AD;
        $searchForm->stepParam = SearchForm::GET_SUBTYPE;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm));
    }

    public function actionEditAdGetSubtypeField($catId){
        $category = Categories::model()->find('orderID=:orderID',array(':orderID'=>$catId));
        $searchForm = new SearchForm();
        $searchForm->ca = $category->orderID;
        $searchForm->st = Ad::SALE;
        $searchForm->type = SearchForm::NEW_AD;
        $searchForm->stepParam = SearchForm::GET_SUBTYPE;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm));
    }

    public function actionNewAdGetFields($catId, $subtypeId){
        $category = Categories::model()->find('orderID=:orderID',array(':orderID'=>$catId));
        $searchForm = new SearchForm();
        $searchForm->ca = $category->orderID;
        $searchForm->st = $subtypeId;
        $searchForm->type = SearchForm::NEW_AD;
        $searchForm->stepParam = SearchForm::GET_FIELDS;
        $this->renderPartial('/fields/_fields', array('searchForm'=>$searchForm));
    }






}
