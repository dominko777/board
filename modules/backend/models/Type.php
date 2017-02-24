<?php

/**
 * This is the model class for table "534q_type".
 *
 * The followings are the available columns in table '534q_type':
 * @property integer $id
 * @property string $name
 * @property integer $categoryID
 * @property string $transName
 *
 * The followings are the available model relations:
 * @property 534qCategories $category
 */
class Type extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, categoryID, transName', 'required'),
			array('categoryID', 'numerical', 'integerOnly'=>true),
			array('name, transName', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, categoryID, transName', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, '534qCategories', 'categoryID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'categoryID' => 'Category',
			'transName' => 'Trans Name',
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
		$criteria->compare('categoryID',$this->categoryID);
		$criteria->compare('transName',$this->transName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Type the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function generateTranslitUrl($url) {
        $newUrl = UrlTransliterate::cleanString($url);
        $results = Categories::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
        $count = count ( $results );
        if ($count > 0)
            do {
                mt_srand();
                $id = mt_rand(10000, 99999);
                $newUrl = $newUrl.'-'.$id;
                $results = Categories::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
                $count = count ( $results );
            } while ($count > 0);
        return $newUrl;
    }
}
