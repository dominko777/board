<?php

class ShowcaseController extends Controller
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
                'actions'=>array(),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('index','create'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($id)
    {
        $ad = Ad::model()->find('urlID=:urlID',array(':urlID'=>$id));
        $this->render('index',array(
            'ad'=>$ad
        ));
    }

    public function actionCreate()
    {
        $date = date('Y-m-d H:i:s');
        $finishDate = date('Y-m-d  H:i:s', strtotime($date . ' + '.$_GET['days'].' day'));
        $ad = Ad::model()->find('urlID=:urlID',array(':urlID'=>$_GET['adId']));
        $showcase = Showcase::model()->find('adID=:adID',array(':adID'=>$ad->id));
        if (count($showcase)>0)
        {
            if ($showcase->finishDate<date('Y-m-d  H:i:s'))
                $showcase->finishDate = $finishDate;
            if ($showcase->update())
            {
                echo 'saved';
            }
        }
        else {
            $showcase = new Showcase();
            $showcase->adID = $ad->id;
            $showcase->finishDate = $finishDate;
            if ($showcase->save())
            {
                echo 'saved';
            }
        }
    }

    public function actionSuccess()
    {
        $this->render('success',array());
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}