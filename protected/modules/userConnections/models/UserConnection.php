<?php

/**
 * This is the model class for table "{{user_connections}}".
 *
 * The followings are the available columns in table '{{user_connections}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $service_user_id
 */
class UserConnection extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserConnection the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public static function module()
	{
		return Yii::app()->getModule('userConnections');
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_connections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, service_user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly' => true),
			array('name, service_user_id', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, service_user_id', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' => 'Name',
			'service_user_id' => 'Service User',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('service_user_id', $this->service_user_id, true);

		return new CActiveDataProvider($this, array(
		                                           'criteria' => $criteria,
		                                      ));
	}

	/**
	 * Named scope for selecting all connections for specified user.
	 *
	 * @param mixed $id Id of current user is used if null
	 * @return UserConnection
	 */
	public function forUser($id = null)
	{
		if ($id === null) {
			$id = Yii::app()->user->id;
		}
		$this->getDbCriteria()->mergeWith(array('condition' => 'user_id = ' . $id));
		return $this;
	}
}