<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property integer $categoryid
 * @property string $description
 * @property string $smallpic
 * @property string $largepic
 *
 * The followings are the available model relations:
 * @property Productcategories $category
 * @property Productbysupplier[] $productbysuppliers
 * @property Productfeedback[] $productfeedbacks
 * @property Productrating $productrating
 */
class Product extends CActiveRecord
{
	/* PROPERTY FOR RECEIVING THE FILE FROM FORM*/          
	public $uploadedFile;
	/* MUST BE THE SAME AS FORM INPUT FIELD NAME*/
	private $imagePath;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('categoryid', 'numerical', 'integerOnly'=>true),
			array('brand_id', 'numerical', 'integerOnly'=>true),
			array('name, smallpic, largepic', 'length', 'max'=>100),
			//array('uploadedFile', 'file', 'types'=>'jpg, gif, png'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, categoryid, description', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Productcategory', 'categoryid'),
			'productbysuppliers' => array(self::HAS_MANY, 'Productbysupplier', 'productid'),
			'productfeedbacks' => array(self::HAS_MANY, 'Productfeedback', 'productid'),
			'productrating' => array(self::HAS_ONE, 'Productrating', 'productid'),
			'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
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
			'brand_id' => 'Brandid',
			'categoryid' => 'Categoryid',
			'description' => 'Description',
			'smallpic' => 'Smallpic',
			'largepic' => 'Largepic',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('categoryid',$this->categoryid);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('smallpic',$this->smallpic,true);
		$criteria->compare('largepic',$this->largepic);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/*public function beforeSave()
	{
		if($file=CUploadedFile::getInstance($this,'uploadedFile'))
		{
			$this->largepic=$file->name;
		}
		return parent::beforeSave();;
	}*/
	
	public function beforeDelete()
	{
		if(strlen($this->largepic)!==0)	{
			unlink(Yii::getPathOfAlias('webroot').$this->largepic);
			unlink(Yii::getPathOfAlias('webroot').$this->smallpic);
		}
		return parent::beforeDelete();
	}
	
	public function rand_str($length = 8, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
	{
	    // Length of character list
	    $chars_length = (strlen($chars) - 1);
	
	    // Start our string
	    $string = $chars{rand(0, $chars_length)};
	    
	    // Generate random string
	    for ($i = 1; $i < $length; $i = strlen($string))
	    {
	        // Grab a random character from our list
	        $r = $chars{rand(0, $chars_length)};
	        
	        // Make sure the same two characters don't appear next to each other
	        if ($r != $string{$i - 1}) $string .=  $r;
	    }
	    
	    // Return the string
	    return $string;
	}

	public function genImageName()
	{
		$imagePath = Yii::getPathOfAlias('webroot').'/images/products/large/';
		$succGen = False;
		while ($succGen != True)	{
			$imageName = $this->rand_str().'.jpg';
			for($i = 1; $i <= 5; $i++)
			{
				if (!file_exists($imagePath.sprintf("%02d",$i).'/'.$imageName))
				{
					if ($i = 5)	{
						$succGen = True;
					}
					continue;
				}
				else
				{
					break;
				}
			}
		}
		return sprintf("%02d",rand(1,5)).'/'.$imageName;
	}
	
	/**
     * Find product attribute value
     * @param Attribute $attr attribute
     * @return string
     */
    public function findAttrValue($attr)
    {
        $res = Productattrvalue::model()->findByAttributes(array('product_id' => $this->id, 'attr_id' => $attr->id));
        if (!isset($res))
            return '';
        if ($attr->type == '5')
            return $res->attrlistvalue_id;
        else
        {
            return $res->value;
        }
    }
    
	/**
     * Save product attribute values from array
     * @param $data array with product attribute values
     */
    public function SaveAttrs($data)
    {
        //save product attrs
        if (!isset($data))
            return;
        //check exist good features first
        $attrValues = Productattrvalue::model()->findAllByAttributes(array('product_id' => $this->id));

        foreach ($attrValues as $attrValue) {
            if (isset($attrValue->attrlistvalue)) {
                if (($attrValue->attrlistvalue->attr->type == '1')||($attrValue->attrlistvalue->attr->type == '3')) { //if feature is string type
                    if (empty($data['normal'][$attrValue->attrlistvalue->attr->id]))
                        $attrValue->delete();
                    elseif ($data['normal'][$attrValue->attrValue->attr->id] !=
                            $attrValue->attrlistvalue_id
                    ) {
                        if ($data['normal'][$attrValue->attrlistvalue->attr->id] == '0')
                            $attrValue->value = $data['new'][$attrValue->attrValue->attr->id];
                        else
                            $attrValue->attrlistvalue_id = $data['normal'][$attrValue->attrValue->attr->id];
                        $attrValue->save();
                    }
                }
            } elseif (isset($attrValue->attr)) {
                if ($attrValue->attr->type == '2') { //if feature is boolean type
                    if ($data['normal'][$attrValue->attr->id] == '0')
                        $attrValue->delete();
                    elseif ($data['normal'][$attrValue->attr->id] != $attrValue->value) {
                        $attrValue->value = $data['normal'][$attrValue->attr->id];
                        $attrValue->save();
                    }
                } elseif ($attrValue->attr->type == '3') { //if feature is integer type
                    if (empty($data['normal'][$attrValue->attr->id]))
                        $attrValue->delete();
                    elseif ($data['normal'][$attrValue->attr->id] != $attrValue->value) {
                        $attrValue->value = $data['normal'][$attrValue->attr->id];
                        $attrValue->save();
                    }
                }
            }
        }

        $newFeature = TRUE;
        foreach ($data['normal'] as $attrId => $attrValue) {
            foreach ($attrValues as $attrListValue) {
                if ($attrListValue->attrlistvalue !== null && $attrListValue->attrlistvalue->attr_id == $attrId)
                    $newFeature = FALSE;
                if ($attrListValue->attr->id == $attrId)
                    $newFeature = FALSE;
            }
            //var_dump($newFeature);
            //var_dump($attrValue);
            if ($newFeature) {
                $attr = Attribute::model()->findByPk($attrId);
				//var_dump($attr->type);
                $newProductAttr = new Productattrvalue;
                $newProductAttr->product_id = $this->id;
                if ($attr->type == '5' || $attr->type == '6') {
                    if ($attrValue == '0' && !empty($data['new'][$attrId])) {
                        //add new attribute value
                        $newAttrListValue = new Attrvaluelist;
                        $newAttrListValue->attr_id = $attr->id;
                        $newAttrListValue->value = $data['new'][$attrId];
                        
                        //var_dump($newAttrListValue);
                        
                        $newAttrListValue->save();
                        $newAttrListValue->refresh();
                        $newProductAttr->attrlistvalue_id = $newAttrListValue->id;
                        
                        //var_dump($newProductAttr);
                        
                        $newProductAttr->save();
                    } elseif ($attrValue != '0') {
                        $newProductAttr->attrlistvalue_id = $attrValue;
                        $newProductAttr->save();
                    }
                } elseif ($attr->type == '2' && $attrValue != '0') {
                    $newProductAttr->value = $attrValue;
                    $newProductAttr->attr_id = $attrId;
                    $newProductAttr->save();
                } elseif (!empty($attrValue)) {
                    $newProductAttr->value = $attrValue;
                    $newProductAttr->attr_id = $attrId;
					$newProductAttr->save();
                }
            }
            $newFeature = TRUE;
        }
    }
}