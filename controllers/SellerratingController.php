	<?php

class SellerratingController extends Controller
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
				'actions'=>array('create','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionCreate($type, $sellerId)
	{
                $seller = User::model()->find('urlID=:urlID',array(':urlID'=>$sellerId));
		$sellerRating = SellerRating::model()->find('userID=:userID AND sellerID=:sellerID',array(':userID'=>Yii::app()->user->id,':sellerID'=>$seller->id));
                if (empty($sellerRating))
                {
                   $newSellerRating = new SellerRating();
                   $newSellerRating -> sellerID = $seller->id;
                   $newSellerRating -> userID = Yii::app()->user->id;
                   $newSellerRating -> type = $type;
                   $newSellerRating -> date = date('Y-m-d');
                   if ($newSellerRating -> save())
                   {
                      $response = $this->getResponses($seller->id); 
                   }
                }
                else
                {
                   $sellerRating->type = $type;
                   $sellerRating->date = date('Y-m-d');
                   if ($sellerRating->save())
                   {
                       $response = $this->getResponses($seller->id);
                   }
                }
                echo json_encode($response);
	}

        private function getResponses ($sellerID)
        {
		$positiveSellerRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$sellerID));
                $neutralSellerRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$sellerID));
                $negativeSellerRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$sellerID));
                $response = array('positive'=>$positiveSellerRating, 'neutral'=>$neutralSellerRating, 'negative'=>$negativeSellerRating);  
                return $response;    
        }

	
}