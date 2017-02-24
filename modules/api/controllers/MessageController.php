<?php
class MessageController extends ApiController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete',
            'postOnly + create',
            'postOnly + createChat',
            'postOnly + storeuser',
            'postOnly + notification',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array(
                    ),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('list','create','delete','createChat','storeuser','notification'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );  
    }

    

    public function actionInbox($type)
	{
       $type = Yii::app()->request->getParam('type');
       $criteria = new CDbCriteria;
       $criteria->order= 't.time DESC';


        $userID = $this->getUser()->id;  
        if ($type == Chat::ALL_TYPE) 
        {
            $criteria->addCondition('(buyerID= :userID1 AND buyerDeleted != :buyerDeleted)
                                     XOR (sellerID= :userID2 AND sellerDeleted != :sellerDeleted)');
            $criteria->params += array(':userID1' => $userID,  
                                 ':userID2'=> $userID,':buyerDeleted'=>1, ':sellerDeleted'=>1);
        }
        elseif ($type == Chat::BUYING_TYPE)
        {
            $criteria->addCondition('buyerID= :userID1  AND buyerDeleted != :deleted');
            $criteria->params += array(':userID1' => $userID,':deleted'=>1);
        }
        elseif ($type == Chat::SELLING_TYPE)
        {
            $criteria->addCondition('sellerID= :userID1 AND sellerDeleted != :deleted');
            $criteria->params += array(':userID1' => $userID,':deleted'=>1);  
        }  


        // Did we get some results?

            $jSonActiveDataProvider = new JSonActiveDataProvider('Chat', array(
                'attributes' => array('id', 'time'),
                'criteria'=>$criteria,
                'relations' => array(
                                     'ads'=> array(
                                        'attributes' => array('id', 'name'),
                                          'relations' => array(
                                              'images' => array(
                                                'attributes' => array('image')
                                              )
                                            )
                                      ),
                                      'buyer'=> array(
                                        'attributes' => array('id','fio', 'avatar'),
                                        'relations' => array(
                                              'chatReplies' => array(
                                                'attributes' => array('userID', 'time', 'chatID','reply','read')
                                              )
                                            )
                                      ),
                                      'seller'=> array(
                                        'attributes' => array('id','fio', 'avatar'),
                                         'relations' => array(
                                              'chatReplies' => array(
                                                'attributes' => array('userID', 'time', 'chatID','reply','read')
                                              ) 
                                          )
                                      ),
                ),
                'pagination'=>array('currentPage'=>$_GET['page'],'pageSize'=>20)));
       $this->_sendResponse(200, $jSonActiveDataProvider->getJsonData());
	}


    public function actionDelete()
	{
        $userID = $this->getUser()->id;
        $model = Chat::model()->findByPk($_POST['id']);
        if ($userID == $model->buyerID)
        {
            $model->buyerDeleted = 1;
         //   $this->_sendResponse(200, "buyerID");
        }
        elseif ($userID == $model->sellerID)
        {  
            $model->sellerDeleted = 1;
          //  $this->_sendResponse(200, "sellerID");
        }
        if ($model->update())
        {
            $this->_sendResponse(200, CJSON::encode(array('data'=>array("saved"=>true))));
        }    
    }

    public function actionView()
	{
        $userID = $this->getUser()->id;

        $criteria = new CDbCriteria;
        $criteria->order= 't.id ASC';
    //    $criteria->select = 't.reply, t.time, t.userID, u.fio AS login, u.avatar AS avatar';
    //    $criteria->join = ' LEFT JOIN 534q_user u ON u.id = t.userID';
        $criteria->condition='chatID=:chatID';
        $criteria->params = array(':chatID'=>$_GET['id']);
        $models = ChatReply::model()->with('user')->findAll($criteria);
        foreach ($models as $model){
          if ($model->userID != $userID)
              $model->read = 1;
              $model->save();
        }  
        $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($models)));
    }

    public function actionCreate(){
       $chatReply = new ChatReply();
       $chatReply->reply = $_POST['reply'];
       $chatReply->chatID = $_POST['chatId'];
       $chatReply->userID = $this->getUser()->id;
       $chatReply->time = time(); 
       if ($chatReply->save())
       {
           $model = ChatReply::model()->with('user')->findByPk($chatReply->id);
           $chat = Chat::model()->findByPk($model->chatID);

           $chat->time = time();   
           $chat->update();
  
           $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($model)));  
       }
    }

      

    public function actionCreateChat(){

       $adID = $_POST['adID'];
       $userID = $this->getUser()->id;
       $ad = Ad::model()->findByPk($adID);

       $chat = Chat::model()->find('adID=:adID AND buyerID=:buyerID',array(':adID'=>$ad->id, ':buyerID'=>$userID));
       if (empty($chat))
       {

           $newChat = new Chat();
          $newChat->buyerID = $userID;
           $newChat->sellerID = $ad->userID;
           $newChat->adID = $ad->id;
           $newChat->urlID = $newChat->generateUrlID(); 
           $newChat->time = time();

           if ($newChat->save()){ 
               $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($newChat)));
           }
       }
       else
           $this->_sendResponse(200, CJSON::encode(Helper::convertModelToArray($chat)));
    }

    private function sendNotificationEmail($reply, $sender, $receiver){
        $email = Yii::app()->email;
        $email->to = $receiver->email;
        $email->subject = 'Новое сообщение от '.$sender->fio.' на сайте'. Yii::t('messages', 'Name of site');
        $email->from= Yii::t('messages', 'Name of site').'<'.Yii::app()->params['email'].'>';
        $email->message = 'Новое сообщение от '.$sender->fio.':<br><br>';
        $email->message .= $reply;  
        $email->Send();  
    }

    public function actionStoreuser(){
        $user = $this->getUser();
        $user->setScenario('gcm');
        $user->gcm_regid = $_POST['regId'];
        if ($user->validate())   
            if ($user->update()){
                $message = array();
                $result = $this->send_push_notification(array($user->gcm_regid), $message);
                echo $result;        
            }

    }

    function send_push_notification($registatoin_ids, $message) {
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=AIzaSyBCNvhubj9s4JBJAZ3RLTOqnRzGqb9AlBI',  
            'Content-Type: application/json'
        );
        //print_r($headers);
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        echo $result;
    }
  
    public function actionNotification(){   
       $chatReply = ChatReply::model()->with('chat')->findByPk($_POST['chatReplyId']);
       $sender = $this->getUser();
           if ($sender->id== $chatReply->chat->buyerID)
               $receiver = User::model()->findByPk($chatReply->chat->sellerID);
           else
               $receiver = User::model()->findByPk($chatReply->chat->buyerID);
           $message = array('reply'=>$chatReply->reply, 'senderLogin'=>$sender->fio,'chatId'=>$chatReply->chat->id);
           $this->send_push_notification(array($receiver->gcm_regid), $message);
    }       


}
