<?php

/**
 * This is the model class for table "534q_seller_rating".
 *
 * The followings are the available columns in table '534q_seller_rating':
 * @property integer $id
 * @property integer $sellerID
 * @property integer $userID
 * @property integer $type
 * @property string $date
 *
 * The followings are the available model relations:
 * @property 534qUser $seller
 * @property 534qUser $user
 */
class SellerRating extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_seller_rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

        const POSITIVE = 1;
        const NEUTRAL = 2;
        const NEGATIVE = 3;


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sellerID, userID, type, date', 'required'),
			array('sellerID, userID, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sellerID, userID, type, date', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, '534qUser', 'sellerID'),
			'user' => array(self::BELONGS_TO, '534qUser', 'userID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sellerID' => 'Seller',
			'userID' => 'User',
			'type' => 'Type',
			'date' => 'Date',
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
		$criteria->compare('sellerID',$this->sellerID);
		$criteria->compare('userID',$this->userID);
		$criteria->compare('type',$this->type);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellerRating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
