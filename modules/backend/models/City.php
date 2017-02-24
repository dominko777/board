<?php

/**
 * This is the model class for table "534q_city".
 *
 * The followings are the available columns in table '534q_city':
 * @property integer $id
 * @property string $name_en
 * @property integer $orderID
 * @property string $name
 *
 * The followings are the available model relations:
 * @property 534qUser[] $534qUsers
 */
class City extends OrderRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, transName', 'required'),
			array('orderID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orderID, name', 'safe', 'on'=>'search'),
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
			'534qUsers' => array(self::HAS_MANY, '534qUser', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orderID' => 'Order',
			'name' => 'Name Cn',
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
		$criteria->compare('orderID',$this->orderID);
		$criteria->compare('name',$this->name,true);
        $criteria->order = 't.orderID ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function generateTranslitUrl($url) {
        $newUrl = UrlTransliterate::cleanString($url);
        $results = City::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
        $count = count ( $results );
        if ($count > 0)
            do {
                mt_srand();
                $id = mt_rand(10000, 99999);
                $newUrl = $newUrl.'-'.$id;
                $results = City::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
                $count = count ( $results );
            } while ($count > 0);
        return $newUrl;
    }
}
