<?php

class StatController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

   public $layout='protected/modules/backend/views/layouts/main';


    public function accessRules()
    {
                return array(
                             array('allow', // allow admin user to perform 'admin' and 'delete' actions
                                'actions'=>array('index'),
                                'roles'=>array('admin'),
                                ),
                            array('deny', // deny all users
                                 'users' => array('*'),
                            ),

                  );
     }

    public function actionIndex()
	{
        $currentDate = date('d-m-Y');
        $from = (isset($_GET['from'])) ? $_GET['from'] : date('d-m-Y',strtotime('-12 day',strtotime($currentDate)));
        $to = (isset($_GET['from'])) ? $_GET['to'] : $currentDate; 
        $timestampFrom = strtotime($from);
        $timestampTo = strtotime('+1 day',strtotime($to));

        $timeStampIntervalArray = array();
        $timeStampIntervalArrayDayFormat = array();
        $day= 24 * 60 * 60;
        $countDays = ceil(($timestampTo - $timestampFrom)/$day);
        $dayTotal=$timestampFrom;
        for ($dayIndex = 0; $dayIndex<$countDays; $dayIndex++){
            array_push($timeStampIntervalArray, $dayTotal);
            array_push($timeStampIntervalArrayDayFormat, date("Y-m-d",$dayTotal));
            $dayTotal = strtotime('+1 day', $dayTotal);
        }
  


        $formatFrom = date("Y-m-d",strtotime($from));
        $formatTo = date("Y-m-d",strtotime($to));
        $users = User::model()->findAll('register_date > :min AND register_date <= :created_at_max',array(':min'=>$formatFrom,':created_at_max'=>$formatTo ));
  

        $countUsersDateArray = array();
        foreach ($timeStampIntervalArrayDayFormat as $k=>$v){   
            $countUsersDateInfoArray = array();
            $sumUsers = 0;
            foreach ($users as $user) {
                if (isset($timeStampIntervalArrayDayFormat[$k+1]))   
                {  
                    if ((strtotime($user->register_date)>=strtotime($v)) && (strtotime($user->register_date)<strtotime($timeStampIntervalArrayDayFormat[$k+1])))
                    {       
                       $sumUsers++;
                    }  
                }
                elseif (strtotime($user->register_date)>strtotime($v))
                {
                    $sumUsers++;
                }

            }    
            $dateFormat = date('d-m', strtotime($v));
            $countUsersDateInfoArray[$dateFormat]=$sumUsers;    
            array_push($countUsersDateArray, $countUsersDateInfoArray);
        }

        $countAdsArray = $this->getAdsArray($timeStampIntervalArray, $timestampFrom, $timestampTo);
        return $this->render('index', array(
               'countUsersDateArray'=>$countUsersDateArray,
               'countAdsArray'=>$countAdsArray,
        ));  
    }



    private function getAdsArray($timeStampIntervalArray, $timestampFrom, $timestampTo){
        $ads= Ad::model()->findAll('time > :min AND time <= :created_at_max',array(':min'=>$timestampFrom,':created_at_max'=>$timestampTo));


                $countAdsDateArray = array();
                foreach ($timeStampIntervalArray as $k=>$v){
                    $countAdsDateInfoArray = array();
                    $sumAds = 0;
                    foreach ($ads as $ad) {
                        if (isset($timeStampIntervalArray[$k+1]))
                        {
                            if (($ad->time>$v) && ($ad->time<$timeStampIntervalArray[$k+1]))
                            {
                               $sumAds++;
                            }
                        }
                        elseif ($ad->time>$v)
                        {
                            $sumAds++;
                        }
 
                    }
                    $dateFormat = date('d-m', $v);
                    $countAdsDateInfoArray[$dateFormat]=$sumAds;
                    array_push($countAdsDateArray, $countAdsDateInfoArray);
                }
             return  $countAdsDateArray;
    } 


}

