<?php

/**
 * This is the model class for table "762s_resetpassword".
 *
 * The followings are the available columns in table '762s_resetpassword':
 * @property integer $id
 * @property integer $userID
 * @property string $key
 *
 * The followings are the available model relations:
 * @property 762sUser $user
 */
class Resetpassword extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_resetpassword';  
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public $email;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
            array('userID, key', 'safe'),
            array('email', 'email'),
			array('userID', 'numerical', 'integerOnly'=>true),
            array('email', 'isUserIssetValidationRule'),
			array('key', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userID, key', 'safe', 'on'=>'search'),
		);
	}

    public function isUserIssetValidationRule($attribute,$params)
    {
        $user=User::model()->find('email=:email',array(':email'=>$this->email));
        if(!$user)
            $this->addError($attribute, Yii::t('account', 'There is no user registered with that email address.'));
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userID' => 'User',
			'key' => 'Key',
            'email' => Yii::t('messages', 'Email'),
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
		$criteria->compare('userID',$this->userID);
		$criteria->compare('key',$this->key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Resetpassword the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function generateKey() {
        do {
            mt_srand();
            $id = mt_rand(100000000, 999999999);
            $results = $this->findAll(array('condition'=>'t.key=:k', 'params'=>array(":k" =>$id)));
            $count = count ( $results );
        } while ($count > 0);
        return $id;
    }
}

