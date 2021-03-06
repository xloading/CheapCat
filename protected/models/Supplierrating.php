<?php

/**
 * This is the model class for table "supplierrating".
 *
 * The followings are the available columns in table 'supplierrating':
 * @property integer $supplierid
 * @property string $averating
 * @property integer $ratecounter
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 */
class Supplierrating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Supplierrating the static model class
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
		return 'supplierrating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplierid, averating, ratecounter', 'required'),
			array('supplierid, ratecounter', 'numerical', 'integerOnly'=>true),
			array('averating', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplierid, averating, ratecounter', 'safe', 'on'=>'search'),
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
			'supplierid' => 'Supplierid',
			'averating' => 'Averating',
			'ratecounter' => 'Ratecounter',
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

		$criteria->compare('supplierid',$this->supplierid);
		$criteria->compare('averating',$this->averating,true);
		$criteria->compare('ratecounter',$this->ratecounter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}