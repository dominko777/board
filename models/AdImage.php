<?php

/**
 * This is the model class for table "762s_ad_image".
 *
 * The followings are the available columns in table '762s_ad_image':
 * @property integer $id
 * @property integer $image
 * @property integer $adID
 *
 * The followings are the available model relations:
 * @property 762sAd $ad
 */
class AdImage extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '534q_ad_image';
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image, adID', 'required', 'on'=>'create'),
            array('adID', 'numerical', 'integerOnly'=>true, 'on'=>'create'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, image, adID', 'safe', 'on'=>'search'),
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
            'ad' => array(self::BELONGS_TO, '762sAd', 'adID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'image' => 'Image',
            'adID' => 'Ad',
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
        $criteria->compare('image',$this->image);
        $criteria->compare('adID',$this->adID);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdImage the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function generateImageName($extension) {
        do {
            $id = AdImage::random_string(18);
            $id = $id.'.'.$extension;
            $results = AdImage::model()->findAll('image=:image', array(':image'=>$id));
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


    public static function getDirPathFullsize($fileName){
        $firstSequence = substr($fileName, 0,3);
        $secondSequence = substr($fileName, 3,3);
        $thirdSequence = substr($fileName, 6,3);
        $dirPath = Yii::app()->request->baseUrl.'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/'.$fileName;
        return $dirPath;
    }

    public static function getDirPathThumbs($fileName){
        $firstSequence = substr($fileName, 0,3);
        $secondSequence = substr($fileName, 3,3);
        $thirdSequence = substr($fileName, 6,3);
        $dirPath = Yii::app()->request->baseUrl.'/images/f/'.$firstSequence.'/'.$secondSequence.'/'.$thirdSequence.'/'.$fileName;
        return $dirPath;
    }
}
