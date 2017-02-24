<?php

/**
 * This is the model class for table "534q_chat".
 *
 * The followings are the available columns in table '534q_chat':
 * @property integer $id
 * @property integer $buyerID
 * @property integer $sellerID
 * @property integer $adID
 * @property integer $urlID
 * @property integer $time

 *
 * The followings are the available model relations:
 * @property 534qUser $buyer
 * @property 534qUser $seller
 * @property 534qChatReply[] $534qChatReplies
 */
class Chat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    const DELETED = 1;
    const NOT_DELETED = 0;
    const ARCHIVED = 1;
    const NOT_ARCHIVED = 0;   
    const BLOCK = 1;
    const UNBLOCK = 0;

    public $productName;
    public $productPrice;
    public $productPhoto;
    public $sellerLogin;
    public $sellerAvatar;
    public $sellerUrlID;  
    public $buyerUrlID;
    public $sellerID;
    public $buyerID;
    public $buyerLogin;
    public $buyerAvatar;
    public $adTransName;

    public $lastReply;
    public $lastReplyTime;
    public $lastReplyId;
    public $lastReplyLogin;
    public $lastReplyAvatar;
    public $readRepliesBuyers;
    public $countRepliesBuyers;
    public $readRepliesSellers;
    public $countRepliesSellers;
    public $countReplies;
    public $archiveId;
    public $deleteChatId;
    public $buyerDeleted;

    const BUYING_TYPE = "buying";
    const SELLING_TYPE = "selling";
    const ALL_TYPE = "all";   


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('urlID, adID, buyerID, sellerID, time', 'required'),
			array('buyerDeleted, sellerDeleted', 'safe'),
			array('buyerBlock, sellerBlock, urlID, adID, buyerID, sellerID, time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, buyerID, sellerID, time', 'safe', 'on'=>'search'),
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
			'buyer' => array(self::BELONGS_TO, 'User', 'buyerID'),
			'seller' => array(self::BELONGS_TO, 'User', 'sellerID'),
			'chatReplies' => array(self::HAS_MANY, 'ChatReply', 'chatID'),
			'ads' => array(self::BELONGS_TO, 'Ad', 'adID'),
            'adImage'=>array(self::BELONGS_TO,'AdImage',array('id'=>'adID'),'through'=>'ads'),

            'buyeralias' => array(self::BELONGS_TO, 'User', 'buyerID','alias' => 'buyer'),
			'sellerAlias' => array(self::BELONGS_TO, 'User', 'sellerID','alias' => 'seller'),

           
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'buyerID' => 'Buyer',
			'sellerID' => 'Seller',
			'time' => 'Time',
			'buyerArchived' => 'Buyer Archived',
			'sellerArchived' => 'Seller Archived',
			'buyerDeleted' => 'Buyer Deleted',
			'sellerDeleted' => 'Seller Deleted',
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
		$criteria->compare('buyerID',$this->buyerID);
		$criteria->compare('sellerID',$this->sellerID);
		$criteria->compare('time',$this->time);
		$criteria->compare('buyerArchived',$this->buyerArchived);
		$criteria->compare('sellerArchived',$this->sellerArchived);
		$criteria->compare('buyerDeleted',$this->buyerDeleted);
		$criteria->compare('sellerDeleted',$this->sellerDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
}
