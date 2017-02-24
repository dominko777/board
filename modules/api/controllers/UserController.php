<?php
class UserController extends ApiController
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
                'actions'=>array('Create','delete','Update','GetUserProfileInfo'),   
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

    public function actionUpdate()
    {
        $user = $this->getUser();
        $user->fio = urldecode($_POST['login']);
        $user->scenario='profile';
        if (isset($_FILES['image']['tmp_name']))
        {    
                    $oldImage = $user->avatar;
                    if ($oldImage!='default.jpg')
                        $this->avatarremove($oldImage); 
                    $user->avatar = AdImage::generateImageName("jpg");
                    if($user->save())  
                    {
                        $firstSequence = substr($user->avatar, 0,3);
                        $secondSequence = substr($user->avatar, 3,3);
                        $thirdSequence = substr($user->avatar, 6,3);  
                        $uploaddir = Yii::getPathOfAlias('webroot').'/images/avatars/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
                        if(!is_dir($uploaddir)) {  
                                            if (mkdir($uploaddir, 0755, true));                     }
                     //   file_put_contents($uploaddir.$user->avatar, $decodedImage, LOCK_EX);
                        move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir. $user->avatar);
                     //   file_put_contents($uploaddir.$user->avatar, print_r($uploadtitle, true));
                        $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($user)));
                    }
                    else
                        $this->_sendResponse(200, CJSON::encode(array('data'=>$user->getErrors())));
        }
        else
            if($user->save())
                   $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($user)));
            else
                $this->_sendResponse(200, CJSON::encode(array('data'=>$user->getErrors())));  


    }

    private function avatarremove($oldImage){
        $firstSequence = substr($oldImage, 0,3);
        $secondSequence = substr($oldImage, 3,3);
        $thirdSequence = substr($oldImage, 6,3);
        $uploaddir = Yii::getPathOfAlias('webroot').'/images/avatars/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/';
        if (file_exists($uploaddir.$oldImage))   
           unlink($uploaddir.$oldImage);
    }

    public function actionGetUserProfileInfo()
    {
        $user = User::model()->with('countuserfollowers','countuserfollowing','countads')->findByPk($_GET['id']);
        $relation = Relationship::model()->find('follower_id=:follower_id AND followed_id=:followed_id',array(':follower_id'=>$this->getUser()->id, ':followed_id'=>$_GET['id']));
        if (empty($relation))
            $isMyFriend = false;
        else
            $isMyFriend = true;
        $this->_sendResponse(200, CJSON::encode(array(
                                                    'login'=>$user->fio,
                                                    'avatar'=>$user->avatar,
                                                    'followers'=>$user->countuserfollowers,
                                                    'following'=>$user->countuserfollowing,  
                                                    'countads'=>$user->countads,
                                                    'isMyFriend'=>$isMyFriend
                                                )));   
    }
}

 
