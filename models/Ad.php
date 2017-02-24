<?php

/**
 * This is the model class for table "534q_ad".
 *
 * The followings are the available columns in table '534q_ad':
 * @property integer $id
 * @property string $name
 * @property string $time
 * @property integer $moderation
 * @property string $text
 * @property string $phone
 * @property integer $hidePhone
 * @property integer $categoryID
 * @property integer $cityID
 * @property integer $cb
 * @property integer $cm
 * @property integer $pm
 * @property integer $pma
 * @property integer $rs
 * @property integer $re
 * @property integer $property
 * @property integer $soldTime
 *
 * The followings are the available model relations:
 * @property 534qSubtype $subtype
 */
class Ad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '534q_ad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    const SALE_VALUE=1;
    const WANTED_VALUE=2;
    const SALE='sale';
    const WANTED='wanted';

    const ALL_CONDITION_VALUE=0;
    const NEW_CONDITION_VALUE=2;
    const BU_CONDITION_VALUE=3;


    const COMPANY_PROPERTY=2;
    const PRIVATE_PROPERTY=1;
    const ALL_PROPERTY=0;

    const SOLD = 1;  

    public $categoryName;
    public $cityName;
    public $subtypeName;
    public $userFio;
    public $userLogin;
    public $userUrlID;
    public $userEmail;
    public $userAvatar;
    public $companyAdsCount;
    public $mainCategoryName;
    public $typeName;
    public $typeTransName;

    public $pho;


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(  
			array('price, name, time, text', 'required','on'=>'ad_scenario'),
			array('price,  cityID', 'numerical', 'integerOnly'=>true,'on'=>'ad_scenario'),  
			array('name', 'length', 'max'=>150,'on'=>'ad_scenario'),
			array('text', 'length', 'max'=>3000,'on'=>'ad_scenario'), 
			array('hidePhone, phone, categoryID', 'safe', 'on'=>'ad_scenario'),
			array('mainCategoryID',  'required', 'message'=>Yii::t('messages', 'Choose category'),'on'=>'ad_scenario'),
		//	array('categoryID', 'numerical', 'max'=>1000,'tooBig'=>Yii::t('messages', 'Choose category'),'on'=>'ad_scenario'),
          //  array('email', 'email','on'=>'ad_scenario'),
            array('typeID, condition', 'safe','on'=>'ad_scenario'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, time, moderation, text, hidePhone, categoryID, cityID, cb, cm, pm, pma, rs, re, property', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'userID'), 
			'city' => array(self::BELONGS_TO, 'City', 'cityID'),
			'categories' => array(self::BELONGS_TO, 'Categories', 'categoryID'),
			'types' => array(self::BELONGS_TO, 'Type', 'typeID'),
			'mcategory' => array(self::BELONGS_TO, 'Main_categories', 'mainCategoryID'),
			'images' => array(self::HAS_MANY, 'AdImage', 'adID'),
			'tracks' => array(self::HAS_ONE, 'TrackingSum', 'adID'),
            'imagesCount'=>array(self::STAT, 'AdImage', 'adID'),
            'countlikes'=>array(self::STAT, 'AdLike', 'adID'),
            'likes'=>array(self::HAS_MANY, 'AdLike', 'adID'),
            'isliked'=>array(self::STAT, 'AdLike', 'adID'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('messages', 'Name'),
			'price' => Yii::t('messages', 'Price'),
			'time' => 'time',
			'moderation' => 'Moderation',
			'text' => Yii::t('messages', 'Description'),
			'phone' => Yii::t('messages', 'Phone'),
			'hidePhone' => 'Hide Phone',
			'categoryID' => Yii::t('messages', 'Subcategory'),
            'mainCategoryID' => Yii::t('messages', 'Category'),
			'cityID' => Yii::t('messages', 'City'),
			'property' => 'Property',
            'ownerName'=>Yii::t('messages', 'Owner name'),
            'condition'=>Yii::t('messages', 'Condition'),
            'hidePhone'=>Yii::t('messages', 'Show number'),
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
		$criteria->compare('time',$this->time,true);
		$criteria->compare('moderation',$this->moderation);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('hidePhone',$this->hidePhone);
		$criteria->compare('categoryID',$this->categoryID);
		$criteria->compare('cityID',$this->cityID);
		$criteria->compare('cb',$this->cb);
		$criteria->compare('cm',$this->cm);
		$criteria->compare('pm',$this->pm);
		$criteria->compare('pma',$this->pma);
		$criteria->compare('rs',$this->rs);
		$criteria->compare('re',$this->re);
		$criteria->compare('property',$this->property);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ad the static model class
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

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->transName = Ad::generateTranslitUrl($this->name);
            }
            return true;
        }
        else
            return false;
    }


    public function generateTranslitUrl($url) {
       $newUrl = UrlTransliterateRus::str2url($url);

        $results = Ad::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
        $count = count ( $results );
        if ($count > 0)
        do {
            mt_srand();
            $id = mt_rand(10000, 99999);
            $newUrl = $newUrl.'-'.$id;
            $results = Ad::model()->findAll('transName=:transName', array(':transName'=>$newUrl));
            $count = count ( $results );
        } while ($count > 0);
        return $newUrl;
    }


    function cutoff_words($text) {
        $meta = strip_tags($text);
        $meta = strip_shortcodes($meta);
        $meta = str_replace(array("\n", "\r", "\t"), ' ', $meta);
        $meta = substr($meta, 0, 125);
        return $meta;
    }

    public static function getAdCoverImage ($images){
        $countIm = count($images);
            if ($countIm>0)
                    $adCoverImage = AdImage::getDirPathFullsize($images[0]->image);
            else
                    $adCoverImage = Yii::app()->request->baseUrl.'/images/static/nothumb.jpg';
        return $adCoverImage;
    }

}
