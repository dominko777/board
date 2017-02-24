<?php

class TopController extends Controller
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
                'actions'=>array('index','success','create'),
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
        $top = Top::model()->find('adID=:adID',array(':adID'=>$ad->id));
        if (count($top)>0)
        {
            if ($top->finishDate<date('Y-m-d  H:i:s'))
                $top->finishDate = $finishDate;
                if ($top->update())
                {
                    echo 'saved';
                }
        }
        else {
            $top = new Top();
            $top->adID = $ad->id;
            $top->finishDate = $finishDate;
            if ($top->save())
            {
                echo 'saved';
            }
        }
    }

    public function actionSuccess()
    {
        $this->render('success',array());
    }
}