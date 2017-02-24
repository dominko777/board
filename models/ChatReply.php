<?php

/**
 * This is the model class for table "534q_chat_reply".
 *
 * The followings are the available columns in table '534q_chat_reply':
 * @property integer $id
 * @property string $reply
 * @property integer $userID
 * @property integer $time
 * @property integer $chatID
 *
 * The followings are the available model relations:
 * @property 534qChat $chat
 * @property 534qUser $user
 */
class ChatReply extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_chat_reply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    public $userLogin;
    public $userUrlID;
    public $userAvatar;
    public $chatUrlID;
    public $buyerID;
    public $sellerID;
    public $readRepliesBuyers;
    public $countRepliesBuyers;
    public $readRepliesSellers;
    public $countRepliesSellers;
    public $countReplies;
    public $productName;
    public $productPhoto;
    public $chatOffer;
    public $sellerReply;
    public $buyerReply;
    public $buyerTime;
    public $sellerTime;
    public $maxBuyerID;
    public $maxSellerID;
    public $lastReply;
    public $lastReplyLogin;
    public $adSoldStatus;
    public $lastReplyTime;
    public $chatID; 
 

    public $login;
    public $avatar;
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userID, time, chatID', 'required'),
			array('userID, time, chatID', 'numerical', 'integerOnly'=>true),
			array('reply', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, reply, userID, time, chatID', 'safe', 'on'=>'search'),
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
			'chat' => array(self::BELONGS_TO, 'Chat', 'chatID'),
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
			'reply' => 'Reply',
			'userID' => 'User',
			'time' => 'Time',
			'chatID' => 'Chat',
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
		$criteria->compare('reply',$this->reply,true);
		$criteria->compare('userID',$this->userID);
		$criteria->compare('time',$this->time);
		$criteria->compare('chatID',$this->chatID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChatReply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
