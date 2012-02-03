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
			'productbysuppliers' => array(self::MANY_MANY, 'Productbysupplier', 'productbysupplier(productid,supplierid)'),
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
}