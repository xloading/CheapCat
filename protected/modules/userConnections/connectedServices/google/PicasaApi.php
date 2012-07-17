<?php

class PicasaApi
{
    private $_token;

    private $_email;

    public function __construct($token = null, $email = null)
    {
        /**
         * @see Zend_Gdata_Photos
         */
        Zend_Loader::loadClass('Zend_Gdata_Photos');
        /**
         * @see Zend_Gdata_Photos_UserQuery
         */
        Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');

        /**
         * @see Zend_Gdata_Photos_AlbumQuery
         */
        Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');

        /**
         * @see Zend_Gdata_Photos_PhotoQuery
         */
        Zend_Loader::loadClass('Zend_Gdata_Photos_PhotoQuery');

        /**
         * @see Zend_Gdata_App_Extension_Category
         */
        Zend_Loader::loadClass('Zend_Gdata_App_Extension_Category');

        $this->setToken($token);
        $this->setUserEmail($email);
    }

    public function setToken($token)
    {
        if (is_string($token)) {
            $this->_token = $token;
            return true;
        }
        return false;
    }

    public function setUserEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
            return true;
        }
        return false;
    }

    public function getAllAlbums()
    {
        $client = Zend_Gdata_AuthSub::getHttpClient($this->_token);
        $service = new Zend_Gdata_Photos($client);
        $query = new Zend_Gdata_Photos_UserQuery();
        $query->setUser($this->_email);
        $query->setAlt('json');
        $query->setKind('album');
        $query->setAccess('all');

        try {
            return $service->get($query->getQueryUrl())->getBody();
        } catch (Zend_Gdata_App_Exception $e) {
            Yii::trace("Get Google data: Request  failed. Server reply was {$e->getMessage()}.", 'warning');
            return '';
        }
    }

    public function getPrivateAlbumPhotos($params = array())
    {
        if(!isset($params['albumId'])){
            return false;
        }
        $client = Zend_Gdata_AuthSub::getHttpClient($this->_token);
        $service = new Zend_Gdata_Photos($client);
        $query = new Zend_Gdata_Photos_AlbumQuery();
        $query->setUser($this->_email);
        $query->setAlt('json');
        $query->setKind('photo');
        $query->setAccess('all');
        $query->setAlbumId($params['albumId']);

        try {
            return $service->get($query->getQueryUrl())->getBody();
        } catch (Zend_Gdata_App_Exception $e) {
            Yii::trace("Get Google data: Request  failed. Server reply was {$e->getMessage()}.", 'warning');
            return '';
        }
    }
}