<?php

class AccountController extends Controller
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
                'actions'=>array('mail','followers','following','user','form','confirm','verifyemail','error','login','logout','reset_password','newpass_info','password','password_success'),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('follow','uploadavatar','avatar','profile','myads','favorites','deleteFavorite'),
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

    public function actionAvatar()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $this->render('avatar',array('user'=>$user));
    }


    /*public function actionMail()
    {

        $criteria=new CDbCriteria;
      //  $criteria->condition='email=:email or email=:email2';
      //  $criteria->params=array(':email2'=>'g3484673@tbbbbbbbbbbbbbbbbbbbbbbb.com','email'=>'platon444@inbox.ru');
        $users=User::model()->findAll($criteria);
        $i = 1;
        foreach ($users as $user) {
            echo "<p>$i. ".$user->email."</p>";
            $name='=?UTF-8?B?'.base64_encode('Продалайк').'?=';
                    $subject='=?UTF-8?B?'.base64_encode('Увеличьте ваши продажи с помощью Продалайк').'?=';
            $headers  = 
                'MIME-Version: 1.0'."\r\n".
                'Content-type: text/html; charset=utf-8'."\r\n".
                "From: $name <{site@prodalike.com.ua}>\r\n".
                "Reply-To: {site@prodalike.com.ua}\r\n".
                'X-Mailer: PHP/'.phpversion();

             $fio = $user->fio;
             $body = "<p>Здравствуйте, $fio.</p><p>Давно Вас не было видно на нашем сайте обьявлений. С радостью ждем Вас и ваших обьявлений!</p>".
                     "<p>Сайт Продалайк.</p>". 
                     "<p><a href=\"http://prodalike.com.ua\">http://prodalike.com.ua/</a></p>";  
             mail($user->email,$subject,$body,$headers); 
             $i++;
        }
    }*/

    public function actionUploadavatar ()
    {
        $fName = $_FILES['file']['name'];
        $fType = $_FILES['file']['type'];
        $fSize = $_FILES['file']['size'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $userUrlID = $_GET['urlID'];   

        $model = User::model()->find('urlID=:urlID',array(':urlID'=>$userUrlID));
        $oldImage = $model->avatar;
        $model->scenario = 'avatar_scenario';
        $erroris = false;
        $etype = '0';
        $imageID = '';
        $imgArray[] = array();
        if (!empty($_FILES)) {
            $name = $fName;
            $tempFile = $tmp_name;

            $extension = substr($name, strrpos($name, '.')+1);
            $model->avatar = AdImage::generateImageName($extension);

            $firstSequence = substr($model->avatar, 0,3);
            $secondSequence = substr($model->avatar, 3,3);
            $thirdSequence = substr($model->avatar, 6,3);
            $uploaddir = Yii::getPathOfAlias('webroot').'/images/avatars/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';


            $size = $fSize;

                if (($size < 3145728) && ($size>0))
                {
                    if ((
                            ($extension == "jpeg")
                            || ($extension == "jpg") || ($extension == "JPG")) &&
                        (($fType == "image/jpeg") || ($fType == "image/png")))
                    {
                        if (is_uploaded_file($tempFile)) {
                            $uploadfile = $uploaddir . $model->avatar;
                            if ($oldImage!='default.jpg') $this->avatarremove($oldImage);
                            if($model->save())
                            {
                                if(!is_dir($uploaddir)) {  
                                    if (mkdir($uploaddir, 0755, true));
                                }
                                move_uploaded_file($tempFile, $uploadfile);
                                $erroris = false;
                                $imageID = $model->id;

                            }
                            else {

                                $erroris = true;
                                $etype = Yii::t('messages', 'Model is not saved');
                            }
                        }
                        else {
                            $erroris = true;
                            $etype = Yii::t('messages', 'Temp file is not uploaded');
                        }
                    } 
                    else {
                        $erroris = true;
                        $etype = Yii::t('messages', 'Image formats only: jpg, jpeg');
                    }
                }
                else
                {
                    $erroris = true;
                    $etype = Yii::t('messages', 'Files  - if < 3Mb');
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

    private function avatarremove($oldImage){
        $firstSequence = substr($oldImage, 0,3);
        $secondSequence = substr($oldImage, 3,3);
        $thirdSequence = substr($oldImage, 6,3);
        $uploaddir = Yii::getPathOfAlias('webroot').'/images/avatars/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
        unlink($uploaddir.$oldImage);   
    }

	public function actionForm()
    {  
        $this->setPageTitle(Yii::t('messages', 'Name of site') . ' - '.Yii::t('account', 'Registration'));
        $model=new User('register');
        $activationKey = sha1(mt_rand(10000,99999).time().$model->email);
        $model->activation_key=$activationKey;
        $model->role="user";

        if(isset($_POST['User']))
        {
            // populate input data to $a and $b
            $model->attributes=$_POST['User'];
            $model->email = trim($model->email);
            $model->last_visit_date=date('Y-m-d');
            $model->register_date=date('Y-m-d');
            if($model->validate())
            {
                // use false parameter to disable validation
                if ($model->save())
                {
                    $activationLink = Yii::app()->createAbsoluteUrl('account/verifyemail', array('code'=>$activationKey));
                    $email = Yii::app()->email;
                    $email->to = $model->email;
                    $email->subject = Yii::t('messages', 'Registration on').' '. Yii::t('messages', 'Name of site');
                    $email->from= Yii::t('messages', 'Name of site').'<'.Yii::app()->params['email'].'>';
                    $email->replyTo = Yii::app()->params['email'];
                    $email->message = Yii::t('messages', 'Hello').'<br><br>'.
                        Yii::t('messages', 'You have registered on').' '.Yii::t('messages', 'Name of site').'.<br><br>'.
                        Yii::t('messages', 'Now you have to approve your account').'<br><br>'.
                        Yii::t('messages', 'You have to follow this link to activate your account').': '."<a href=\"".$activationLink."\">".$activationLink."</a>".'<br><br>'.
                        Yii::t('messages', 'To login on').' '.Yii::t('messages', 'Name of site').' '.Yii::t('messages', 'use').':<br><br>'.
                        Yii::t('messages', 'Login').': '.$model->email.'<br><br>'.
                        Yii::t('messages', 'If you have questions contact us via email').': '.Yii::app()->params['email'].'<br><br>';
                    $email->Send();
                    $url = Yii::app()->createUrl('account/confirm');
                    $this->redirect($url);
                }
            }
        } 
        $this->render('form',array(
            'model'=>$model,
        ));
    }

    public function actionConfirm()
    {
        $this->render('confirm',array());
    }


    public function actionVerifyemail($code)
    {
        $user=User::model()->find('activation_key=:key', array(':key'=>$code));
        if ($user)
        {
            $activation_msg = Yii::t('messages', 'You have successfuly activated your account. Now you can login.');  
            $user->scenario = "activation";
            $user->activation_key=1;
            $user->activate_type=1;
            $user->update();
        } 
        else
            $activation_msg = Yii::t('account', Yii::t('messages','You have successfuly activated your account. Now you can login.'));

        $this->render('verify_email',array('activation_msg'=>$activation_msg));
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

    public function actionProfile(){
        $model = User::model()->findByPk(Yii::app()->user->id);
        $model->scenario='profile';
        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save())
            {
                Yii::app()->user->setFlash('success', Yii::t('messages', 'You successfully change profile'));
            }

        }

        $this->render('profile', array(
            'user'=>$model
        ));
    }

    public function actionLogin()
    {


            $this->setPageTitle(Yii::t('messages', 'Name of site') . ' - '. Yii::t('account','Login'));
            $model=new LoginForm;
 
            // collect user input data
            if(isset($_POST['LoginForm']))
            {
                $model->attributes=$_POST['LoginForm'];
                $model->rememberMe = true;
                if($model->validate() && $model->login())
                {
                    $user = User::model()->find('id=:userID', array(':userID'=>Yii::app()->user->getId()));
                    if (isset($user->email))
                                    $this->redirect(array('account/user','id'=>Yii::app()->user->getUrlId()));
                }

            } 
            // display the login form
            $this->render('login',array('model'=>$model));
        
    }

    public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionReset_password()
	{
        $model=new Resetpassword();
        if(isset($_POST['Resetpassword']))
        {
            $model->attributes=$_POST['Resetpassword'];

            if($model->validate()) 
            {
                $model->userID = User::model()->find('email=:email',array(':email'=>$model->email))->id;
                $oldResetPassword = Resetpassword::model()->find('userID=:userID',array(':userID'=>$model->userID));
                if ($oldResetPassword)
                    $oldResetPassword->delete();
                $model->key = Resetpassword::model()->generateKey();
                if($model->save()){
                            $resetPasswordLink = Yii::app()->createAbsoluteUrl('account/password', array('key'=>$model->key));
                            $email = Yii::app()->email;
                            $email->to = $model->email;
                            $email->subject = Yii::t('messages','Resetting your password');
                            $email->from= Yii::t('messages', 'Name of site').'<'.Yii::app()->params['email'].'>';
                            $email->replyTo = Yii::app()->params['email'];
                            $email->message = Yii::t('messages','Click on the link to reset it on our site').': '."<a href=\"".$resetPasswordLink."\">".$resetPasswordLink."</a>";
                            $email->Send(); 
                            $url = Yii::app()->createUrl('account/newpass-info');
                            $this->redirect($url);
                 }
            }
        } 
      $this->render('reset_password',array('model'=>$model));
	}

    public function actionNewpass_info()
    {
        $this->render('newpass_info',array());
    }

    public function actionFavorites()
    {
        $user=User::model()->find(Yii::app()->user->id);
        $favorites = Favorite::model()->findAll('userID=:userID',array(':userID'=>Yii::app()->user->id));
        $f_array = array();
        foreach ($favorites as $favorite)
            array_push($f_array, $favorite->adID);

        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.id', $f_array, 'OR');
        $criteria->order= 't.id DESC';
        $ads =  new CActiveDataProvider('Ad', array(  
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
        $this->render('favorites',array(
            'ads'=>$ads,
            'user'=>$user,
        ));
    }

    public function actionDeleteFavorite(){
        $ad=Ad::model()->find('transName=:transName',array(':transName'=>$_POST['id']));
        $fav = Favorite::model()->find('adID=:adID AND userID=:userID',array(':adID'=>$ad->id,':userID'=>Yii::app()->user->id));
        $oldFav = $fav;
        if ($fav->delete()) {
            echo $oldFav->id;
        }
    }

    public function actionPassword($key)
    {
        $this->setPageTitle(Yii::t('messages', 'Name of site') . ' - Смена пароля');
        $resetPassword = Resetpassword::model()->find('t.key=:key',array(':key'=>$key));
        if (!empty($resetPassword)){
        $model = User::model()->findbyPk($resetPassword->userID);
        $model->scenario = 'change_password';
        if(isset($_POST['User']))
        {
            // populate input data to $a and $b
            $model->attributes=$_POST['User'];

            if($model->validate())
            {
                $model->changePassword();
                // use false parameter to disable validation
                if ($model->update())
                {
                    Resetpassword::model()->find('userID=:userID',array(':userID'=>$model->id))->delete();
                    $url = Yii::app()->createUrl('account/password-success');
                    $this->redirect($url);

                }
            }
        }
        $this->render('new_password',array('model'=>$model));
        }
        else
            throw new CHttpException(404,'Указанная запись не найдена');

    }

    public function actionPassword_success()
    {
        $this->render('password_success',array());
    }


    public function actionUser($id)
    {
       $user=User::model()->with('groups','countads','countuserfollowers','countuserfollowing')->find('urlID=:urlID',array(':urlID'=>$id));

       $criteria = new CDbCriteria;
	   $criteria->condition = "t.userID=:userID AND published=:published";
	   $criteria->params = array(':userID'=>$user->id, ':published'=>1);
       $criteria->group='t.id';
       $criteria->order= 't.id DESC';
       $criteria->with=array('likes');
        $ads =  new CActiveDataProvider('Ad', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));


        $ifImFollowing = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>Yii::app()->user->id,':followed_id'=>$user->id));

        $this->render('user',array(
            'ads'=>$ads,
            'user'=>$user,
            'ifImFollowing'=>$ifImFollowing,  
        ));
    } 

    public function actionFollow($id)
    {
        $user=User::model()->find('urlID=:urlID',array(':urlID'=>$id));
        $relationship = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>Yii::app()->user->id,':followed_id'=>$user->id));
        if (empty($relationship)) {
            $newRelationship = new Relationship();
            $newRelationship->follower_id = Yii::app()->user->id;
            $newRelationship->followed_id = $user->id;
            $newRelationship->time = time();
            if ($newRelationship->save()){ 
                echo json_encode(array('follow'=>'created'));
            }
        }
        else {
                if ($relationship->delete()){
                    echo json_encode(array('follow'=>'deleted'));
              }
        }
    }

    public function actionFollowers($id)
    {
       $user=User::model()->with('countads','countuserfollowers','countuserfollowing')->find('urlID=:urlID',array(':urlID'=>$id));

       $criteria = new CDbCriteria;
	   $criteria->condition = "t.followed_id=:followed_id";
	   $criteria->params = array(':followed_id'=>$user->id);
       $criteria->order = 't.id DESC';
       $criteria->with = array('follower','follower.countuserfollowers','follower.iffollower');
       $userFollowers =  new CActiveDataProvider('Relationship', array(  
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        )); 

        $ifImFollowing = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>Yii::app()->user->id,':followed_id'=>$user->id));

        $this->render('followers',array(
            'user'=>$user,
            'userFollowers'=>$userFollowers,
            'ifImFollowing'=>$ifImFollowing
        ));
    }


    public function actionFollowing($id)
    {
       $user=User::model()->find('urlID=:urlID',array(':urlID'=>$id));

       $criteria = new CDbCriteria;
	   $criteria->condition = "t.follower_id=:follower_id";
	   $criteria->params = array(':follower_id'=>$user->id);
       $criteria->order = 't.id DESC'; 
       $criteria->with = array('followed','followed.countuserfollowers','followed.iffollowed');
       $userFollowing =  new CActiveDataProvider('Relationship', array(
            'criteria' => $criteria, 
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));

        $ifImFollowing = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>Yii::app()->user->id,':followed_id'=>$user->id));

        $this->render('following',array(
            'user'=>$user,
            'userFollowing'=>$userFollowing, 
            'ifImFollowing'=>$ifImFollowing
        ));
    }


 

}