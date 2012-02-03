<?php

/**
 * This is the model class for table "supplierfeedback".
 *
 * The followings are the available columns in table 'supplierfeedback':
 * @property integer $id
 * @property integer $supplierid
 * @property string $dateadded
 * @property integer $rating
 * @property string $feedback
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 */
class Supplierfeedback extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Supplierfeedback the static model class
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
		return 'supplierfeedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplierid, dateadded, rating, feedback', 'required'),
			array('supplierid, rating', 'numerical', 'integerOnly'=>true),
			array('feedback', 'length', 'max'=>4000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, supplierid, dateadded, rating, feedback', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplierid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplierid' => 'Supplierid',
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
		$criteria->compare('supplierid',$this->supplierid);
		$criteria->compare('dateadded',$this->dateadded,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('feedback',$this->feedback,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}