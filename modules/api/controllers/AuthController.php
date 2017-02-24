<?php
class AuthController extends ApiController
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
                'actions'=>array('login',
                    'register'),
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




    public function actionLogin($email, $password)
    {

         $model=new LoginForm;
         $model->email = $email; 
         $model->password=$password;
         if($model->validate())
         {
            if ($model->login())
               {
                                $user = User::model()->find('id=:userID', array(':userID'=>Yii::app()->user->getId()));
                                $loginUser = array(
                                    'id'=>$user->id,
                                    'fio'=>$user->fio,
                                    'email'=>$user->email,
                                    'urlID'=>$user->urlID,
                                    'avatar'=>$user->avatar,
                                    'password'=>$user->password,  
                                );

                                $this->_sendResponse(200, CJSON::encode($loginUser));
                }
          }
          else
              $this->_sendResponse(200, CJSON::encode($model->getErrors()));    


    }


    public function actionRegister($email, $password, $login)
    {

        $model=new User('register');
        $model->activation_key=1;
        $model->role="user";

            // populate input data to $a and $b
            $model->email = $email;
            $model->password=$password;
            $model->password_repeat=$password;
            $model->activate_type=1;
            $model->fio = $login;
            $model->last_visit_date=date('Y-m-d');
            $model->register_date=date('Y-m-d');
            if($model->validate())
            {
                // use false parameter to disable validation
                if ($model->save())
                {
                    $user = User::model()->findByPk($model->id);
                    $loginUser = array(
                                    'id'=>$user->id,
                                    'fio'=>$user->fio,
                                    'email'=>$user->email,
                                    'urlID'=>$user->urlID,
                                    'avatar'=>$user->avatar,
                                    'password'=>$user->password, 
                                );

                    $this->_sendResponse(200, CJSON::encode($loginUser));
                }
            } 
            else  
              $this->_sendResponse(200, CJSON::encode(array('data'=>$model->getErrors())));

    }





}
