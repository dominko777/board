<?php

/**
 * This is the model class for table "534q_live_user".
 *
 * The followings are the available columns in table '534q_live_user':
 * @property integer $id
 * @property integer $ip
 * @property integer $userID
 *
 * The followings are the available model relations:
 * @property 534qLive[] $534qLives
 */
class LiveUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_live_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, userID', 'required'),
			array('ip, userID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ip, userID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'534qLives' => array(self::HAS_MANY, '534qLive', 'liveUserId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip' => 'Ip',
			'userID' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ip',$this->ip);
		$criteria->compare('userID',$this->userID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LiveUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        
        public static function getLiveUserId(){
             $liveUserId = NULL;
        	if(Yii::app()->user->isGuest){
	        	$guestIp = LiveUser::getIp();
	        	$guestUser = LiveUser::model()->find('userID=:userID AND ip=:ip',array(':userID'=>0,':ip'=>$guestIp));
				if(empty($guestUser))
				{
		        	    $liveUser = new LiveUser();
		        	    $liveUser->ip = $guestIp;
		        	    $liveUser->userID = 0;
		        	    if ($liveUser->save())
		        	    	$liveUserId = $liveUser->id;
	        	    	}
	        	    	else
	        	    		$liveUserId = $guestUser->id;
        	}
        	else
        	{
        		$liveUser = LiveUser::model()->find('userID=:userID',array(':userID'=>Yii::app()->user->id));
        		if (empty($liveUser))
        		{
        			$liveUser = new LiveUser();
		        	$liveUser->ip = LiveUser::getIp();
		        	$liveUser->userID = Yii::app()->user->id;
		        	if ($liveUser->save())
		        		$liveUserId = $liveUser->id;
        			
        		}
        		else
        			$liveUserId = $liveUser->id;
        	}
        	return $liveUserId;
        }
        
        private static function getIp(){
        	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	            $ip=$_SERVER['HTTP_CLIENT_IP'];
	        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	        }else{
	            $ip=$_SERVER['REMOTE_ADDR'];
	        }
	        $ip = ip2long($ip);
	        return $ip;
        }
}
