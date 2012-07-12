<?php

/**
 * This is the model class for table "productcategory".
 *
 * The followings are the available columns in table 'productcategories':
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Productcategory $parent
 * @property Productcategory[] $productcategories
 */
class Productcategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productcategory the static model class
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
		return 'productcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parentid, inherit_attrs_from_parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parentid, name, inherit_attrs_from_parent', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'categoryid'),
			'parent' => array(self::BELONGS_TO, 'Productcategory', 'parentid'),
			'productcategories' => array(self::HAS_MANY, 'Productcategory', 'parentid', 'order' => 'name ASC'),
			'attrs' => array(self::MANY_MANY, 'Attribute', 'categoryattribute(category_id,attribute_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parentid' => 'Parentid',
			'name' => 'Name',
			'inherit_attrs_from_parent' => 'Inherit attributes'
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
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors(){
		return array(
			'CAdvancedArBehavior' => array(
				'class' => 'application.extensions.CAdvancedArBehavior'
			),
			'nestedSetBehavior'=>array(
				'class'=>'application.extensions.trees.NestedSetBehavior',
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'depth',
				'rootAttribute'=>'root',
			)
		);
	}
	/*public function getListed() {
	    $subitems = array();
	    if($this->productcategories) foreach($this->productcategories as $child) {
	        $subitems[] = $child->getListed();
	    }
	    $returnarray = array('label' => $this->name, 'url' => array('Productcategory/view', 'id' => $this->id));
	    if($subitems != array()) 
	        $returnarray = array_merge($returnarray, array('items' => $subitems));
	    return $returnarray;
	}*/
}