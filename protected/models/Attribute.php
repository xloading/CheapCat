<?php

/**
 * This is the model class for table "attribute".
 *
 * The followings are the available columns in table 'attribute':
 * @property string $id
 * @property string $name
 * @property string $group_id
 * @property integer $in_brief
 * @property integer $type
 * @property integer $grouporder
 * @property string $dimension
 * @property integer $brieforder
 * @property integer $in_filter
 *
 * The followings are the available model relations:
 * @property Attributegroup $group
 * @property Attrvaluelist[] $attrvaluelists
 * @property Productcategory[] $productcategories
 * @property Productattrvalue[] $productattrvalues
 */
class Attribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Attribute the static model class
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
		return 'attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, group_id, type, in_filter', 'required'),
			array('in_brief, type, grouporder, brieforder, in_filter', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('group_id', 'length', 'max'=>11),
			array('dimension', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, group_id, in_brief, type, grouporder, dimension, brieforder, in_filter', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Attributegroup', 'group_id'),
			'attrvaluelists' => array(self::HAS_MANY, 'Attrvaluelist', 'attr_id'),
			'productcategories' => array(self::MANY_MANY, 'Productcategory', 'categoryattribute(attribute_id, category_id)'),
			'productattrvalues' => array(self::HAS_MANY, 'Productattrvalue', 'attr_id'),
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
			'group_id' => 'Group',
			'in_brief' => 'In Brief',
			'type' => 'Type',
			'grouporder' => 'Grouporder',
			'dimension' => 'Dimension',
			'brieforder' => 'Brieforder',
			'in_filter' => 'In Filter',
		);
	}

	public function behaviors(){
          return array( 'CAdvancedArBehavior' => array(
            'class' => 'application.extensions.CAdvancedArBehavior'));
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('in_brief',$this->in_brief);
		$criteria->compare('type',$this->type);
		$criteria->compare('grouporder',$this->grouporder);
		$criteria->compare('dimension',$this->dimension,true);
		$criteria->compare('brieforder',$this->brieforder);
		$criteria->compare('in_filter',$this->in_filter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
     * Return attribute type description
     * @return string attribute type
     */
	public function GetType() {
		switch ($this->type) {
    		case 1:
				return Yii::t('labels','string');
				break;
			case 2:
				return Yii::t('labels','boolean');
				break;
			case 3:
				return Yii::t('labels','integer');
				break;
			case 4:
				return Yii::t('labels','decimal');
				break;
			case 5:
				return Yii::t('labels','string from list');
				break;
			case 6:
				return Yii::t('labels','integer from list');
				break;
			case 7:
				return Yii::t('labels','text');
				break;
		}
	}
}