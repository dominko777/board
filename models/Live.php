<?php

/**
 * This is the model class for table "534q_live".
 *
 * The followings are the available columns in table '534q_live':
 * @property integer $id
 * @property integer $adID
 * @property integer $liveUserId
 * @property string $date
 *
 * The followings are the available model relations:
 * @property 534qAd $ad
 * @property 534qLiveUser $liveUser
 */
class Live extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_live';
	}

	/**
	 * @return array validation rules for model attributes.
	 */


        public $adName;
        public $adPhoto;
        public $userFio;
        public $adTransName;
        public $adPhotoNumber;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adID, liveUserId, date', 'required'),
			array('adID, liveUserId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, adID, liveUserId, date', 'safe', 'on'=>'search'),
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
			'ad' => array(self::BELONGS_TO, '534qAd', 'adID'),
			'liveUser' => array(self::BELONGS_TO, '534qLiveUser', 'liveUserId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'adID' => 'Ad',
			'liveUserId' => 'Live User',
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
		$criteria->compare('adID',$this->adID);
		$criteria->compare('liveUserId',$this->liveUserId);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Live the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
