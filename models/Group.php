<?php

/**
 * This is the model class for table "534q_group".
 *
 * The followings are the available columns in table '534q_group':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $photo
 * @property integer $owner_id
 * @property integer $status
 * @property integer $publicity
 * @property integer $createion_time
 *
 * The followings are the available model relations:
 * @property 534qUser $owner
 * @property 534qGroupProducts[] $534qGroupProducts
 */
class Group extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    const PRIVATE_TYPE=1;
    const PUBLIC_TYPE=2;
  
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, photo, owner_id, publicity, creation_time', 'required'),
			array('owner_id, publicity, creation_time', 'numerical', 'integerOnly'=>true),
			array('name, status', 'length', 'max'=>100),
            array('photo', 'file', 'types'=>'jpg, jpeg', 'safe' => false),
			array('status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, photo, owner_id, status, publicity, creation_time', 'safe', 'on'=>'search'),
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
			'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
			'products' => array(self::HAS_MANY, 'GroupProduct', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'photo' => 'Изображение',
			'owner_id' => 'Администратор',
			'status' => 'Статус',
			'publicity' => 'Тип',
			'creation_time' => 'Время создания',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('publicity',$this->publicity);
		$criteria->compare('creation_time',$this->createion_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function generateImageName($extension) {
        do {
            $id = Group::random_string(18);
            $id = $id.'.'.$extension;
            $results = Group::model()->findAll('photo=:photo', array(':photo'=>$id));
            $count = count ( $results );
        } while ($count > 0);
        return $id;
    }   

    private static function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}
