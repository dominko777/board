<?php

/**
 * This is the model class for table "534q_categories".
 *
 * The followings are the available columns in table '534q_categories':
 * @property integer $id
 * @property string $name_en
 * @property string $name
 * @property integer $mainCategoryID
 *
 * The followings are the available model relations:
 * @property 534qMainCategories $mainCategory
 * @property 534qCategoryLink[] $534qCategoryLinks
 */
class Categories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_categories';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mainCategoryID, transName', 'required'),
			array('mainCategoryID', 'numerical', 'integerOnly'=>true),
			array('name, transName', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, mainCategory, transName', 'safe', 'on'=>'search'),
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
			'mainCategory' => array(self::BELONGS_TO, 'Main_categories', 'mainCategoryID'),
			'category_subtypes' => array(self::HAS_MANY, 'Category_subtypes', 'categoryID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name Cn',
			'mainCategoryID' => 'Main Category',
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
        $criteria->with = array( 'mainCategory' );
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('t.orderID',$this->orderID,true);
        $criteria->order = 't.orderID ASC';
        
		$criteria->compare('mainCategory.name',$this->mainCategory);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'mainCategory'=>array(
                        'asc'=>'mainCategory.name',
                        'desc'=>'mainCategory.name DESC',
                    ),
                    '*',
                ),
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
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
