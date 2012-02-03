<?php

/**
 * This is the model class for table "productfeedback".
 *
 * The followings are the available columns in table 'productfeedback':
 * @property integer $id
 * @property integer $productid
 * @property string $dateadded
 * @property integer $rating
 * @property string $feedback
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class Productfeedback extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productfeedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productfeedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productid, dateadded, rating, feedback', 'required'),
			array('productid, rating', 'numerical', 'integerOnly'=>true),
			array('feedback', 'length', 'max'=>4000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, productid, dateadded, rating, feedback', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'productid' => 'Productid',
			'dateadded' => 'Dateadded',
			'rating' => 'Rating',
			'feedback' => 'Feedback',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('productid',$this->productid);
		$criteria->compare('dateadded',$this->dateadded,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('feedback',$this->feedback,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}