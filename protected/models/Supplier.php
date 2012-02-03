<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $url
 * @property string $description
 * @property string $dateadded
 * @property string $juridicname
 * @property integer $ogrn
 * @property integer $juridicaddress
 *
 * The followings are the available model relations:
 * @property Productbysupplier[] $productbysuppliers
 * @property Supplierfeedback $supplierfeedback
 * @property Supplierrating $supplierrating
 */
class Supplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Supplier the static model class
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
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, url, description, dateadded, juridicname, ogrn, juridicaddress', 'required'),
			array('ogrn, juridicaddress', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>100),
			array('address, juridicname', 'length', 'max'=>200),
			array('description', 'length', 'max'=>16000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, address, url, description, dateadded, juridicname, ogrn, juridicaddress', 'safe', 'on'=>'search'),
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
			'productbysuppliers' => array(self::MANY_MANY, 'Productbysupplier', 'productbysupplier(supplierid,productid)'),
			'supplierfeedback' => array(self::HAS_ONE, 'Supplierfeedback', 'id'),
			'supplierrating' => array(self::HAS_ONE, 'Supplierrating', 'supplierid'),
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
			'address' => 'Address',
			'url' => 'Url',
			'description' => 'Description',
			'dateadded' => 'Dateadded',
			'juridicname' => 'Juridicname',
			'ogrn' => 'Ogrn',
			'juridicaddress' => 'Juridicaddress',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dateadded',$this->dateadded,true);
		$criteria->compare('juridicname',$this->juridicname,true);
		$criteria->compare('ogrn',$this->ogrn);
		$criteria->compare('juridicaddress',$this->juridicaddress);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}