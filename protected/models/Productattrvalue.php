<?php

/**
 * This is the model class for table "productattrvalue".
 *
 * The followings are the available columns in table 'productattrvalue':
 * @property string $id
 * @property string $product_id
 * @property string $attr_id
 * @property string $attrlistvalue_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Attribute $attr
 * @property Attrvaluelist $attrlistvalue
 */
class Productattrvalue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Productattrvalue the static model class
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
		return 'productattrvalue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, attr_id', 'required'),
			array('product_id, attr_id, attrlistvalue_id', 'length', 'max'=>10),
			array('value', 'length', 'max'=>32000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, attr_id, attrlistvalue_id, value', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'attr' => array(self::BELONGS_TO, 'Attribute', 'attr_id'),
			'attrlistvalue' => array(self::BELONGS_TO, 'Attrvaluelist', 'attrlistvalue_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'attr_id' => 'Attr',
			'attrlistvalue_id' => 'Attrlistvalue',
			'value' => 'Value',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('attr_id',$this->attr_id,true);
		$criteria->compare('attrlistvalue_id',$this->attrlistvalue_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}