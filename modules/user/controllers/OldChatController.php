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
                                'actions'=>array('archive','create','report','block','list','chat'),
                                'roles'=>array('@'),
                                ),


                  );
     }




	public function actionList()
	{

		$this->render('inbox');
	}

    public function actionCreate($product)
	{
          //находим продавца товара
          $criteria = new CDbCriteria;
          $criteria->select = 't.id, a.id AS productID';
          $criteria->join .= ' LEFT JOIN 534q_ad a ON t.id = a.userID';
          $criteria->condition = 'a.transName=:transName';
          $criteria->params = array(':transName'=>$product);
          $adUser = User::model()->find($criteria);

          //определяем я ли продавец товара
          $amISeller = ($adUser->id == Yii::app()->user->id) ? true : false;

          //ищем была ли переписка по этому товару
          $criteria = new CDbCriteria;
          $criteria->select = 't.id, c.urlID AS chatUrlID';
          $criteria->join = ' LEFT JOIN 534q_chat c ON c.id = t.chatID';
          $criteria->join .= ' LEFT JOIN 534q_user tu ON t.to_id = tu.id';
          $criteria->join .= ' LEFT JOIN 534q_user fru ON t.from_id = fru.id';
          $criteria->condition = 't.to_id=:to_id AND t.from_id=:from_id AND c.adID=:adID';
          $criteria->params = array(':adID'=>$adUser->productID, ':to_id'=>$adUser->id,':from_id'=>Yii::app()->user->id);
          $oldChatMessages = ChatMessage::model()->find($criteria);

          //если была переписка - то открываем старый чат
          if (!empty($oldChatMessages))
              $this->chatPage($oldChatMessages->chatUrlID, Chat::CHAT_OLD, $amISeller);
          //если нет - создаем новый чат
          else
          {
              $newChat = new Chat;
              $newChat->status = 'inbox';
              $newChat->type = 'buying';
              $newChat->offer = 0;
              $newChat->urlID = Chat::model()->generateUrlID();
              $newChat->adID = $adUser->productID;
              if ($newChat->save())
                  $this->chatPage($newChat->id, Chat::CHAT_NEW, $amISeller, $newChat->id);
          }


    }

    public function actionView($id)
	{
        $criteria = new CDbCriteria;
        $criteria->select = 't.id';
        $criteria->join = 'LEFT JOIN 534q_ad a ON t.id = a.userID';
        $criteria->join .= ' LEFT JOIN 534q_chat c ON c.adID = a.id';
        $criteria->condition = 'c.urlID=:urlID';
        $criteria->params = array(':urlID'=>$id);
        $adUser = User::model()->find($criteria);
        $amISeller = ($adUser->id == Yii::app()->user->id) ? true : false;
        $this->chatPage($id, Chat::CHAT_OLD, $amISeller);
	}

    private function chatPage($id, $isChatNew,  $amISeller, $newChatID = 0){

        if (!$isChatNew) {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*, a.name AS productName, a.price AS productPrice, tu.avatar AS toUserAvatar, fru.avatar AS fromUserAvatar,
            tu.fio AS toUserLogin, fru.fio AS fromUserLogin, ai.image AS productPhoto, s.fio AS sellerLogin, s.avatar AS sellerAvatar,
            s.urlID AS sellerUrlID, s.id AS sellerID, tu.id AS toID, fru.id AS fruID, c.urlID AS chatUrlID, c.status AS chatStatus';
            $criteria->join = ' LEFT JOIN 534q_chat c ON c.id = t.chatID';
            $criteria->join .= ' LEFT JOIN 534q_ad a ON c.adID = a.id';
            $criteria->join .= ' LEFT JOIN 534q_ad_image ai ON ai.adID = a.id';
            $criteria->join .= ' LEFT JOIN 534q_user tu ON t.to_id = tu.id';
            $criteria->join .= ' LEFT JOIN 534q_user fru ON t.from_id = fru.id';
            $criteria->join .= ' LEFT JOIN 534q_user s ON s.id = a.userID';
            $criteria->condition = '(t.to_id=:to_id OR t.from_id=:from_id) AND c.urlID=:urlID';
            $criteria->params = array(':to_id'=>Yii::app()->user->id,':from_id'=>Yii::app()->user->id,':urlID'=>$id);
            $criteria->order='time DESC';
            $criteria->group='t.id';
            $chatMessages = ChatMessage::model()->findAll($criteria);
            if(count($chatMessages)==0) throw new CHttpException(404,'The specified page cannot be found.');

            //определяем профайл покупателя, если я продавец
            if ($amISeller){
                $buyerID = ($chatMessages[0]->sellerID == $chatMessages[0]->toID) ? $chatMessages[0]->fruID : $chatMessages[0]->toID;
                $buyer = User::model()->findByPk($buyerID);
                $chatBlock = ChatBlock::model()->find('userID=:userID AND blockedUserID=:blockedUserID',array(':userID'=>Yii::app()->user->id, ':blockedUserID'=>$buyerID));
                $reportBlock = ChatReport::model()->find('userID=:userID AND reportedUserID=:reportedUserID',array(':userID'=>Yii::app()->user->id, ':reportedUserID'=>$buyerID));
                $this->render('chat',array('buyer'=>$buyer, 'amISeller'=>$amISeller, 'chatMessages'=>$chatMessages, 'chatBlock'=>$chatBlock, 'reportBlock'=>$reportBlock));
            }
            else
            {
                $chatBlock = ChatBlock::model()->find('userID=:userID AND blockedUserID=:blockedUserID',array(':userID'=>Yii::app()->user->id, ':blockedUserID'=>$chatMessages[0]->sellerID));
                $reportBlock = ChatReport::model()->find('userID=:userID AND reportedUserID=:reportedUserID',array(':userID'=>Yii::app()->user->id, ':reportedUserID'=>$chatMessages[0]->sellerID));
                $this->render('chat',array('amISeller'=>$amISeller, 'chatMessages'=>$chatMessages, 'chatBlock'=>$chatBlock, 'reportBlock'=>$reportBlock));
            }



        }
        else
        {
            $criteria = new CDbCriteria;
            $criteria->select = 't.*, a.name AS productName, a.price AS productPrice, ai.image AS productPhoto, s.fio AS sellerLogin, s.avatar AS sellerAvatar,
            s.urlID AS sellerUrlID, s.id AS sellerID';
            $criteria->join .= ' LEFT JOIN 534q_ad a ON t.adID = a.id';
            $criteria->join .= ' LEFT JOIN 534q_ad_image ai ON ai.adID = a.id';
            $criteria->join .= ' LEFT JOIN 534q_user s ON s.id = a.userID';
            $criteria->condition = 't.id=:id';
            $criteria->params = array(':id'=>$newChatID);
            $newChat = Chat::model()->find($criteria);
            $this->render('chat',array('amISeller'=>$amISeller, 'newChat'=>$newChat));
        }
    }


    public function actionBlock($id)
	{
        $blockedUser = User::model()->find('urlID=:urlID',array(':urlID'=>$id));
        $block = ChatBlock::model()->find('userID=:userID AND blockedUserID=:blockedUserID',array(':userID'=>Yii::app()->user->id, ':blockedUserID'=>$blockedUser->id));
        if (empty($block)) {
            $newBlock = new ChatBlock;
            $newBlock->userID=Yii::app()->user->id;
            $newBlock->blockedUserID = $blockedUser->id;
            if ($newBlock->save())
            {
                $response = array('popupMessage'=>Yii::t('chat','User was successfully blocked'),'blockButtonStatus'=>Yii::t('chat','Unblock User'));
            }
        }
        else
        {
            if ($block->delete())
            {
                $response = array('popupMessage'=>Yii::t('chat','User was successfully unblocked'),'blockButtonStatus'=>Yii::t('chat','Block User'));
            }
        }
        echo json_encode($response);
    }


    public function actionReport($id)
	{
        $reportUser = User::model()->find('urlID=:urlID',array(':urlID'=>$id));
        $report = ChatReport::model()->find('userID=:userID AND reportedUserID=:reportedUserID',array(':userID'=>Yii::app()->user->id, ':reportedUserID'=>$reportUser->id));
        if (empty($report)) {
            $newReport = new ChatReport;
            $newReport->userID=Yii::app()->user->id;
            $newReport->reportedUserID = $reportUser->id;
            $newReport->time=date('Y-m-d G:i:s');
            if ($newReport->save())
            {
                $response = array('popupMessage'=>Yii::t('chat','User was successfully reported'));
                echo json_encode($response);
            }
        }
    }

    public function actionArchive($id)
	{
        $chat = Chat::model()->find('urlID=:urlID',array(':urlID'=>$id));
        if ($chat->status=='inbox')
        {
            $chat->status = 'archive';
            $responseMsg = Yii::t('chat','Chat was successfully archived');
            $btnText = Yii::t('chat','Move to inbox');
        }
        elseif ($chat->status=='archive')
        {
            $chat->status = 'inbox';
            $responseMsg = Yii::t('chat','Chat was successfully moved to inbox');
            $btnText = Yii::t('chat','Archive');
        }
            if ($chat->save())
            {
                $response = array('popupMessage'=>$responseMsg, 'archiveBtnStatus'=>$btnText);
                echo json_encode($response);
            }
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
}
