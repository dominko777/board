<?php

class ChatController extends CController
{

    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

 

    public function accessRules()
    {
                return array(
                             array('allow', // allow admin user to perform 'admin' and 'delete' actions
                                'actions'=>array('newreply', 'manage','archive','view','archived','create','remove','block','inbox','chat'),
                                'roles'=>array('@'),     
                                ),
            

                  );
     }


    public function actionNewreply($chatID)
	{
        $chat = Chat::model()->find('urlID=:urlID',array(':urlID'=>$chatID));
        if (($chat->sellerID==Yii::app()->user->id) && ($chat->buyerBlock == Chat::BLOCK))
        {
            $blockMessage = Yii::t('chat','Buyer blocked you. You cant write messages.');
            $blockStatus = true;
        }
        elseif (($chat->buyerID==Yii::app()->user->id) && ($chat->sellerBlock == Chat::BLOCK))
        {
            $blockMessage = Yii::t('chat','Seller blocked you. You cant write messages.');
            $blockStatus = true;
        }
        else
        {
            $blockMessage = '';
            $blockStatus = false;
        }
        if (!$blockStatus) {
            if ($_POST['typeReply']=='offer')
            {
                $offeredSaved = false;
                $chat->offer = $_POST['reply'];
                if ($chat->save())
                    $offeredSaved = true;
            }
            $newReply = new ChatReply();
            $newReply->chatID = $chat->id;
            $newReply->userID = Yii::app()->user->id;
            $newReply->time = time();
            if ($_POST['typeReply']=='simple') $newReply->reply = $_POST['reply'];
            if ($_POST['typeReply']=='report') $newReply->reply = Yii::t('chat','Dont message me if your not interested in buying or selling them. Please. Thank you. Have a great day.');
            if ($_POST['typeReply']=='offer' && $offeredSaved) $newReply->reply = Yii::t('chat','I offered you').' '.$_POST['reply'].' '.Yii::t('chat','grn.');
            if ($newReply->save())
            {
                $savedReply = ChatReply::model()->with('user')->findByPk($newReply->id);
                $response = array('reply'=>$savedReply->reply, 'time'=>$savedReply->time,
                                  'replyId'=>$savedReply->id,  
                                  'login'=>$savedReply->user->fio, 'avatar'=>$savedReply->user->avatar,'blockMessage'=>$blockMessage);
            }
        }
        else
            $response = array('blockMessage'=>$blockMessage);


         echo json_encode($response);  

    }


   public function actionManage()
	{  
       if(Yii::app()->request->isPostRequest)
	  {
         $post = file_get_contents("php://input");
         $data = CJSON::decode($post, true);

         $newDeleteChatFlag = false;
         $newArchiveChatFlag = false;
         $newUnarchiveChatFlag = false;

         if ($data['type'] == 'delete')
         {
             foreach ($data['ids'] as $k=>$v){
                 $newDeleteChat = new ChatDelete();
                 $newDeleteChat->chatID = Chat::model()->find('urlID=:urlID',array(':urlID'=>$v))->id;
                 $newDeleteChat->userID = Yii::app()->user->id;
                 if ($newDeleteChat->save()){
                     $newDeleteChatFlag = true;
                 }
             }
             if ($newDeleteChatFlag)
                 $popupMessage = Yii::t('chat','Chats was successfully deleted');

         }
         elseif ($data['type'] == 'archive')
         {  
             foreach ($data['ids'] as $k=>$v){
                 $newArchiveChat = new ChatArchive();
                 $newArchiveChat->chatID = Chat::model()->find('urlID=:urlID',array(':urlID'=>$v))->id;
                 $newArchiveChat->userID = Yii::app()->user->id;
                 if ($newArchiveChat->save()){
                     $newArchiveChatFlag = true;  
                 }
             }
             if ($newArchiveChatFlag)
                 $popupMessage = Yii::t('chat','Chats was successfully archived');
         }
         elseif ($data['type'] == 'unarchive')
         {
             foreach ($data['ids'] as $k=>$v){
                 $chatID = Chat::model()->find('urlID=:urlID',array(':urlID'=>$v))->id;
                 $oldArchiveChat = ChatArchive::model()->find('userID=:userID AND chatID=:chatID',array(':userID'=>Yii::app()->user->id, ':chatID'=>$chatID));
                 if ($oldArchiveChat->delete()){
                     $newUnarchiveChatFlag = true;
                 }
             } 
             if ($newUnarchiveChatFlag) 
                $popupMessage = Yii::t('chat','Chats was successfully moved to inbox');
         }

         $response = array('popupMessage'=>$popupMessage);
         echo json_encode($response);  
      }  
    }

	public function actionInbox()
	{
       $this->processPageRequest('page');
       $type = Yii::app()->request->getParam('type');
       if (empty($type)) $type=Chat::ALL_TYPE;
       $chats = $this->getChats($type, Chat::NOT_ARCHIVED);
       if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_ajax_chat_loop', array(
                'chats'=>$chats, 'archive'=>false
            ));
            Yii::app()->end();
        }
        else 
	        $this->render('inbox',array('chats'=>$chats,'type'=>$type, 'archive'=>false));
	} 

    public function actionArchive()
	{
        $this->processPageRequest('page');
        $type = Yii::app()->request->getParam('type');
        if (empty($type)) $type=Chat::ALL_TYPE;
        $chats = $this->getChats($type, Chat::ARCHIVED);
        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_ajax_chat_loop', array(
                'chats'=>$chats, 'archive'=>true
            )); 
            Yii::app()->end();
        }
        else
		    $this->render('inbox',array('chats'=>$chats,'type'=>$type, 'archive'=>true));
	}

    private function getChats($type, $archive){
        $chats = array();
        $query1 = "SELECT crl.reply AS lastReply, crl.time AS lastReplyTime, crb.reply AS buyerReply,
        crb.time AS buyerTime, crs.reply AS sellerReply,
         crs.time AS sellerTime, c.urlID AS chatUrlID, c.id AS chatID, c.buyerID AS
        buyerID, c.sellerID AS sellerID
                , a.name AS productName, ai.image AS productPhoto, cru.fio AS
        lastReplyLogin, c.offer AS chatOffer,  
                cru.avatar AS userAvatar, SUM(crb.read) AS readRepliesBuyers,
        COUNT(crb.read) AS countRepliesBuyers
                , SUM(crs.read) AS readRepliesSellers, COUNT(crs.read) AS
        countRepliesSellers, COUNT(t.id) AS countReplies, a.soldStatus AS adSoldStatus ";
        $query2 = " FROM `534q_chat_reply` `t`
        LEFT JOIN 534q_chat c ON c.id = t.chatID
        LEFT JOIN 534q_ad a ON c.adID = a.id
        LEFT JOIN 534q_ad_image ai
        ON ai.adID = a.id LEFT JOIN 534q_chat_reply crs ON crs.id = t.id AND
        crs.userID = c.sellerID
        LEFT JOIN 534q_chat_reply crb ON crb.id = t.id AND
        crb.userID = c.buyerID
        LEFT JOIN 534q_chat_reply crl ON crl.id = (SELECT MAX(crl1.id) FROM 534q_chat_reply crl1 WHERE crl1.chatID = c.id)
        LEFT JOIN 534q_user cru ON cru.id  = crl.userID
        LEFT JOIN 534q_chat_archive carch ON carch.chatID = c.id AND carch.userID=:archiveChatUserID
        LEFT JOIN 534q_chat_delete cdel ON cdel.chatID = c.id AND cdel.userID=:delChatUserID ";

        $Not = ($archive != Chat::NOT_ARCHIVED)  ? "NOT" : "";   
 
            if ($type == Chat::ALL_TYPE)   
            {

                $query3 = " WHERE ((c.sellerID= :userID1 XOR c.buyerID= :userID2) AND carch.id IS ".$Not." NULL AND cdel.id IS NULL)
            GROUP BY c.id ORDER BY t.id DESC ";
                $countItems = Yii::app()->db->createCommand("SELECT COUNT(c.id) ".$query2.$query3)
                ->bindValue(':delChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':archiveChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':userID1', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':userID2', Yii::app()->user->id, PDO::PARAM_STR)   
                ->queryAll();
                $chats  = new CSqlDataProvider($query1.$query2.$query3, array(
                        'keyField' =>'chatID',
                        'totalItemCount'=>count($countItems),
                        'params'=>array(':delChatUserID'=>Yii::app()->user->id,':archiveChatUserID'=>Yii::app()->user->id,':userID1' => Yii::app()->user->id,':userID2'=>Yii::app()->user->id),
                         'pagination'=>array(
                            'pageSize'=>7,
                            'pageVar' =>'page',
                        )));
            }  
            elseif ($type == Chat::BUYING_TYPE)
            { 
              $query3 = " WHERE (c.buyerID= :userID2  AND carch.id IS  ".$Not."  NULL AND cdel.id IS NULL)
            GROUP BY c.id ORDER BY t.id DESC ";
                $countItems = Yii::app()->db->createCommand("SELECT COUNT(c.id) ".$query2.$query3)
                ->bindValue(':delChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':archiveChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':userID2', Yii::app()->user->id, PDO::PARAM_STR)
                ->queryAll();
              $chats  = new CSqlDataProvider($query1.$query2.$query3, array(
                        'keyField' =>'chatID',
                        'totalItemCount'=>count($countItems),
                        'params'=>array(':delChatUserID'=>Yii::app()->user->id,':archiveChatUserID'=>Yii::app()->user->id,':userID2'=>Yii::app()->user->id),
                         'pagination'=>array(
                            'pageSize'=>7,
                            'pageVar' =>'page',
                        )));
            }
            elseif ($type == Chat::SELLING_TYPE)
            {
                 $query3 = " WHERE (c.sellerID= :userID1 AND carch.id IS  ".$Not." NULL AND cdel.id IS NULL)
            GROUP BY c.id ORDER BY t.id DESC ";
                $countItems = Yii::app()->db->createCommand("SELECT COUNT(c.id) ".$query2.$query3)
                ->bindValue(':delChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':archiveChatUserID', Yii::app()->user->id, PDO::PARAM_STR)
                ->bindValue(':userID1', Yii::app()->user->id, PDO::PARAM_STR)
                ->queryAll();
                $chats  = new CSqlDataProvider($query1.$query2.$query3, array(
                        'keyField' =>'chatID', 
                        'totalItemCount'=>count($countItems),
                        'params'=>array(':delChatUserID'=>Yii::app()->user->id,':archiveChatUserID'=>Yii::app()->user->id,':userID1'=>Yii::app()->user->id),
                         'pagination'=>array(
                            'pageSize'=>7,
                            'pageVar' =>'page', 
                        )));
            }

        return $chats;  
    }

    public function actionCreate($product)
	{
        $ad = Ad::model()->find('transName=:transName',array(':transName'=>$product));
        $chat = Chat::model()->find('buyerID=:buyerID AND sellerID=:sellerID AND adID=:adID',
                                       array(
                                            ':buyerID'=>Yii::app()->user->id,
                                            ':sellerID'=>$ad->userID,
                                            ':adID'=>$ad->id));
        if (empty($chat)){
            $this->createNewChat($ad); 
        }
        elseif ($chat->buyerDeleted==Chat::DELETED ||  $chat->buyerDeleted==Chat::DELETED)
            $this->createNewChat($ad);
        else
            $this->viewChat($chat->id);


    } 

    private function createNewChat($ad){
            $newChat = new Chat;
            $newChat->buyerID = Yii::app()->user->id;
            $newChat->sellerID = $ad->userID;
            $newChat->time = time();
            $newChat->adID = $ad->id;
            $newChat->urlID = Chat::model()->generateUrlID(); 
            if ($newChat->save())
            {
               $this->viewChat($newChat->id);
            }
    }

    public function actionView($id){
            $chat = Chat::model()->find('urlID=:urlID', array(':urlID'=>$id));
            $this->viewChat($chat->id);
    }

    private function viewChat($chatID){
            $criteria = new CDbCriteria;
            $criteria->select = 't.*, a.transName AS adTransName, a.name AS productName, a.price AS productPrice, ai.image AS productPhoto, s.fio AS sellerLogin,
            b.fio AS buyerLogin, s.urlID AS sellerUrlID, b.urlID AS buyerUrlID, s.avatar AS sellerAvatar, b.avatar AS buyerAvatar,
            s.id AS sellerID, b.id AS buyerID, carch.id AS archiveId';
            $criteria->join .= ' LEFT JOIN 534q_ad a ON t.adID = a.id'; 
            $criteria->join .= ' LEFT JOIN 534q_ad_image ai ON ai.adID = a.id';
            $criteria->join .= ' LEFT JOIN 534q_user s ON s.id = t.sellerID';
            $criteria->join .= ' LEFT JOIN 534q_user b ON b.id = t.buyerID';
            $criteria->join .= ' LEFT JOIN 534q_chat_archive carch ON carch.chatID = t.id AND carch.userID=:archiveChatUserID ';
 
            $criteria->condition = 't.id=:id';
            $criteria->params = array(':id'=>$chatID, ':archiveChatUserID'=>Yii::app()->user->id);
            $chat = Chat::model()->find($criteria);

            $criteria = new CDbCriteria;
            $criteria->select = 't.*, u.fio AS userLogin, u.urlID AS userUrlID, u.avatar as userAvatar';
            $criteria->join = ' LEFT JOIN 534q_chat c ON c.id = t.chatID';
            $criteria->join .= ' LEFT JOIN 534q_user u ON t.userID = u.id';
            $criteria->condition = 'c.id=:id';
            $criteria->params = array(':id'=>$chat->id);
            $criteria->order='t.id ASC';
            $criteria->group='t.id';
            $chatReplies = ChatReply::model()->findAll($criteria);

            foreach ($chatReplies as $chatReply)
            {
                if ($chatReply->userID != Yii::app()->user->id)
                {
                    $chatReply->read = 1;
                    $chatReply->save();    
                }
            }
         
            $this->render('chat',array('chat'=>$chat,'chatReplies'=>$chatReplies));
    }


    public function actionBlock($chatID)
	{
        $chat = Chat::model()->find('urlID=:urlID',array(':urlID'=>$chatID));
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($chat->sellerID==$user->id)
            if ($chat->sellerBlock == Chat::UNBLOCK)
            {
                $chat->sellerBlock = Chat::BLOCK;
                $blockButtonStatus = Yii::t('chat','Unblock User');
                $popupMessage = Yii::t('chat','User was successfully blocked');
            }
            else
            {
                $chat->sellerBlock = Chat::UNBLOCK;
                $blockButtonStatus = Yii::t('chat','Block User');
                $popupMessage = Yii::t('chat','User was successfully unblocked');
            }
        else
            if ($chat->buyerBlock == Chat::UNBLOCK)
            {
                $chat->buyerBlock = Chat::BLOCK;
                $blockButtonStatus = Yii::t('chat','Unblock User');
                $popupMessage = Yii::t('chat','User was successfully blocked');
            }
            else
            {
                $chat->buyerBlock = Chat::UNBLOCK;
                $blockButtonStatus = Yii::t('chat','Block User');
                $popupMessage = Yii::t('chat','User was successfully unblocked');
            }
        if ($chat->save())
        {
            $response = array('popupMessage'=>$popupMessage,'blockButtonStatus'=>$blockButtonStatus);
            echo json_encode($response);  
        }
    }

    public function actionArchived($chatID)
	{ 
        $chat = Chat::model()->find('urlID=:urlID',array(':urlID'=>$chatID));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $chatArchive = ChatArchive::model()->find('userID=:userID AND chatID=:chatID',array(':userID'=>$user->id, ':chatID'=>$chat->id));
        if (!empty($chatArchive))
        {
           if ($chatArchive->delete())
            {
                $responseMsg = Yii::t('chat','Chat was successfully moved to inbox');
                $btnText = Yii::t('chat','Archive');
            }
        }
        else {
            $newChatArchive = new ChatArchive();
            $newChatArchive->userID = $user->id;
            $newChatArchive->chatID = $chat->id;
            if ($newChatArchive->save())
            {
                $responseMsg = Yii::t('chat','Chat was successfully archived');
                $btnText = Yii::t('chat','Move to inbox');
            }
        }
            $response = array('popupMessage'=>$responseMsg, 'archiveBtnStatus'=>$btnText);  
            echo json_encode($response);
     }  

    public function actionRemove($chatID)
	{

        $chat = Chat::model()->find('urlID=:urlID',array(':urlID'=>$chatID));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $chatDelete = ChatDelete::model()->find('userID=:userID AND chatID=:chatID',array(':userID'=>$user->id, ':chatID'=>$chat->id));
        if (empty($chatDelete))
           {
                $newChatDelete = new ChatDelete();
                $newChatDelete->userID = $user->id;
                $newChatDelete->chatID = $chat->id;
                if ($newChatDelete->save())
                {
                    $popupMessage = Yii::t('chat','Chat was successfully deleted');
                }
            }  
            $response = array('popupMessage'=>$popupMessage);
            echo json_encode($response);
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

    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    } 
}