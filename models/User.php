<?php

/**
 * This is the model class for table "534q_user".
 *
 * The followings are the available columns in table '534q_user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $fio
 * @property string $phone
 * @property integer $region_id
 * @property integer $city_id
 * @property string $last_visit_date
 * @property string $role
 * @property string $activation_key
 * @property string $salt
 * @property integer $activate_type
 * @property integer $urlID
 * @property string $unique_id
 * @property string $register_date
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public $password_repeat;
    const ROLE_ADMIN = 'admin';
    const ROLE_MODER = 'moderator';
    const ROLE_USER = 'user';


    public $productID;

    public $adName;
    public $adSoldTime;
    public $followedUserLogin;
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('fio, email, password, last_visit_date, role, activation_key, register_date', 'required', 'on'=>'register'),
            array('fio', 'unique', 'on'=>'register'),
        //    array('email', 'required', 'message'=>Yii::t('account', 'email cannot be blank'), 'on'=>'register'),
        //    array('password', 'required','message'=>Yii::t('account', 'password cannot be blan'), 'on'=>'register'),
                        //array('gender, phone, region_id, city_id, phone_additional, activate_type, urlID', 'numerical', 'integerOnly'=>true, 'on'=>'register'),
                        //array('email, password, avatar, activation_key, salt, street', 'length', 'max'=>100, 'on'=>'register'),
                        array('fio, email, password, activation_key', 'length', 'max'=>100, 'on'=>'register'),
                        array('email', 'email' , 'on'=>'register'),
                        array('email', 'unique' , 'on'=>'register'),
                        array('service, identity', 'safe' , 'on'=>'register'),   
                        //array('website', 'length', 'max'=>200, 'on'=>'register'),
                        array('password, password_repeat', 'length', 'min' => 6,'max'=>25, 'on'=>'register'),
                        array('password','length','min'=>6,'message'=>Yii::t('account', 'Minimum 6 characters'), 'on'=>'register'),
                        array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'register'),
                        //array('role, house_number', 'length', 'max'=>10, 'on'=>'register'),
                        //array('unique_id', 'length', 'max'=>50, 'on'=>'register'),
                        array('activation_key', 'safe', 'on'=>'activation'),

                        array('password', 'required', 'on'=>'change_password'),
                        array('password, password_repeat', 'length', 'min' => 6,'max'=>25, 'on'=>'change_password'),
                        array('password','length','min'=>6,'message'=>'Minimum 6 characters', 'on'=>'change_password'),
                        array('password', 'compare' , 'compareAttribute' => 'password_repeat','on'=>'change_password'),

                        array('fio', 'length', 'max'=>120, 'on'=>'edit'),
                        array('fio', 'length', 'min' => 5,'on'=>'edit'),
                        array('fio', 'required','on'=>'edit'),
                        array('phone, region_id, city_id', 'safe','on'=>'edit'),

                        array('email', 'email' , 'on'=>'profile'),
                        array('email', 'unique' , 'on'=>'profile'),
                        array('phone', 'safe' , 'on'=>'profile'),
                        array('fio', 'unique' , 'on'=>'profile'),
                        array('email, fio', 'required' , 'on'=>'profile'),
                        array('avatar', 'required' , 'on'=>'avatar_scenario'),  

                       array('gcm_regid', 'safe' , 'on'=>'gcm'),  

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, fio, phone, region_id, city_id, last_visit_date, role, activation_key, salt, activate_type, urlID, unique_id, register_date', 'safe', 'on'=>'search'),
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
            'countads'=>array(self::STAT, 'Ad', 'userID'), 
            'countuserfollowers'=>array(self::STAT, 'Relationship', 'followed_id'),
            'countuserfollowing'=>array(self::STAT, 'Relationship', 'follower_id'),
            'followers'=>array(self::HAS_MANY, 'Relationship', 'follower_id'),
            'following'=>array(self::HAS_MANY, 'Relationship', 'followed_id'), 
            'ads'=>array(self::HAS_MANY, 'Ad', 'userID'),  
            'groups'=>array(self::HAS_MANY, 'Group', 'owner_id'),
            'iffollower'=>array(self::STAT, 'Relationship', 'followed_id','condition'=>'follower_id=:follower_id','params'=>array(':follower_id'=>Yii::app()->user->id)),
            'iffollowed'=>array(self::STAT, 'Relationship', 'follower_id','condition'=>'followed_id=:followed_id','params'=>array(':followed_id'=>Yii::app()->user->id)),
            'chatReplies' => array(self::HAS_MANY, 'ChatReply', 'userID'), 
         
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => Yii::t('messages', 'Email'),
			'password' => Yii::t('messages', 'Password'),
            'password_repeat'=>Yii::t('messages', 'Repeat password'),
			'fio' => Yii::t('messages', 'Login'),
			'phone' => Yii::t('messages', 'Phone'),
			'region_id' => 'region_id',
			'city_id' => 'city_id',
			'last_visit_date' => Yii::t('messages', 'last visit day'),
			'role' => Yii::t('messages', 'role'),
			'activation_key' => 'activation_key',
			'salt' => 'salt',
			'activate_type' => 'activate_type',
			'urlID' => Yii::t('messages', 'url ID'),
			'unique_id' => 'Unique',
			'register_date' => Yii::t('messages', 'register date'),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('last_visit_date',$this->last_visit_date,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('activation_key',$this->activation_key,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('activate_type',$this->activate_type);
		$criteria->compare('urlID',$this->urlID);
		$criteria->compare('unique_id',$this->unique_id,true);
		$criteria->compare('register_date',$this->register_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{ 
		return parent::model($className);
	}

    public function validatePassword($password)
    {
        return $this->hashPassword($password,$this->salt)===$this->password;
    }

    public function hello($password)
    {
        return $password.'-'.$this->salt.'=='.$this->password;
    } 

    // Создание хэша пароля
    public function hashPassword($password,$salt)
    {
        return md5($salt.$password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    public function generateSalt()
    {
        return uniqid('',true);
    }


    public static function getUserIDByUnique($uid) {
        $user = Member::model()->find('unique_id=:uid', array(':uid'=>$uid));
        if ($user !== null)
            return $user->urlID;
        else
            return null;
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord || $this->scenario == 'initMember')
            {

                $salt = self::generateSalt();
                $this->password = self::hashPassword($this->password, $salt);
                $this->salt = $salt;
                $this->urlID = $this->generateUrlID();
                $this->role = 'user';
            }
            return true;
        }
        else
            return false;
    }

    public function generateUrlID() {
        do {
            mt_srand();
            $id = mt_rand(100000000, 999999999);
            $results = $this->findAll('urlID=:urlID', array(':urlID'=>$id));
            $count = count ( $results );
        } while ($count > 0);
        return $id;
    }

    public function changePassword(){
        $salt = self::generateSalt();
        $this->password = self::hashPassword($this->password, $salt);
        $this->salt = $salt;
    }

    public function getUserName(){
        $user = $this->findByPk(Yii::app()->user->id);
        if (isset($user->fio)){
            if ($user->fio!=='')
               return  $user->fio;
            else
            {
                $userName = str_replace(strrchr($user->email, '@'), '', $user->email);
                return $userName;
            }
        }
        else
        {
            if (isset($user->email))
            {
                $userName = str_replace(strrchr($user->email, '@'), '', $user->email);
                 return $userName;  
            }

        }   
    }

    public static function getAvatarFile($fileName){
        $firstSequence = substr($fileName, 0,3);
        $secondSequence = substr($fileName, 3,3);
        $thirdSequence = substr($fileName, 6,3);
        $dirPath = Yii::app()->request->baseUrl.'/images/avatars/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/'.$fileName;
        return $dirPath;  
    }

    public static function getAvatarImgSrc($avatar){
        if ($avatar=='default.jpg')
            return Yii::app()->request->baseUrl.'/images/static/default.png';
        else
            return User::getAvatarFile($avatar);
    }
}
