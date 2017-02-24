<?php

/**
 * This is the model class for table "534q_relationship".
 *
 * The followings are the available columns in table '534q_relationship':
 * @property integer $id
 * @property integer $follower_id
 * @property integer $followed_id
 *
 * The followings are the available model relations:
 * @property 534qUser $followed
 * @property 534qUser $follower
 */
class Relationship extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_relationship';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public $userLogin;
    public $userUrlID;
    public $userAvatar;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('follower_id, followed_id, time', 'required'),
			array('follower_id, followed_id, time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, follower_id, followed_id', 'safe', 'on'=>'search'),
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
			'followed' => array(self::BELONGS_TO, 'User', 'followed_id'),
			'follower' => array(self::BELONGS_TO, 'User', 'follower_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'follower_id' => 'Follower',
			'followed_id' => 'Followed',
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
		$criteria->compare('follower_id',$this->follower_id);
		$criteria->compare('followed_id',$this->followed_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Relationship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
