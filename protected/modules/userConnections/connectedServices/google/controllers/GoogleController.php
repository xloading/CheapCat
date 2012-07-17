<?php

class GoogleController extends Controller
{
    public $layout = '/layouts/empty';

    public function accessRules()
    {
        return CMap::mergeArray(
            array(
                 array(
                     'allow',
                     'actions' => array('picasa'),
                     'users' => array('@')
                 ),
                 array(
                     'allow',
                     'actions' => array('authenticate')
                 )
            ),
            parent::accessRules()
        );
    }

    public function actionPicasa($action)
    {
        $apiController = new PicasaApiController('PicasaApi');
        $action = 'action' . ucwords($action);
        if (method_exists($apiController, $action)) {
            return $apiController->$action();
        }
        return $apiController->wrongActionCall();
    }

    public function actionAuthenticate()
    {
        $service = $this->module->getComponent('google');
        $this->render('application.modules.userConnections.connectedServices.google.views.authenticate', array('service' => $service));
    }
}

class PicasaApiController extends JsonController
{
    const ITEM_NOT_FOUND = 4;
    const WRONG_ITEM_OWNER = 5;
    const WRONG_ACTION_CALL = 6;

    public function actionGetAllAlbums()
    {
        $service = Yii::app()->getModule('userConnections')->getComponent('google');
        $service->initZend();
        Zend_Loader::loadClass('Zend_Gdata_Photos');
        Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');
        $client = Zend_Gdata_AuthSub::getHttpClient($service->getToken());
        $photos = new Zend_Gdata_Photos($client);
        $query = new Zend_Gdata_Photos_UserQuery();
        $query->setUser($service->getUserId());
        $query->setAlt('json');
        $query->setKind('album');
        $query->setAccess('all');

        try {
            echo $photos->get($query->getQueryUrl())->getBody();
        } catch (Zend_Gdata_App_Exception $e) {
            $error = "Get Google data: Request  failed. Server reply was {$e->getMessage()}.";
            Yii::trace($error, 'warning');
            $this->response(self::WRONG_REQUEST_ATTRIBUTES, $error);
        }
    }

    public function actionGetPrivateAlbumPhotos()
    {
        if (!isset($_GET['albumId'])) {
            return false;
        }
        $service = Yii::app()->getModule('userConnections')->getComponent('google');
        $service->initZend();
        Zend_Loader::loadClass('Zend_Gdata_Photos');
        Zend_Loader::loadClass('Zend_Gdata_Photos_AlbumQuery');

        $client = Zend_Gdata_AuthSub::getHttpClient($service->getToken());
        $photos = new Zend_Gdata_Photos($client);
        $query = new Zend_Gdata_Photos_AlbumQuery();
        $query->setUser($service->getUserId());
        $query->setAlt('json');
        $query->setKind('photo');
        $query->setAccess('all');
        $query->setAlbumId($_GET['albumId']);

        try {
            echo $photos->get($query->getQueryUrl())->getBody();
        } catch (Zend_Gdata_App_Exception $e) {
            $error = "Get Google data: Request  failed. Server reply was {$e->getMessage()}.";
            Yii::trace($error, 'warning');
            $this->response(self::WRONG_REQUEST_ATTRIBUTES, $error);
        }
    }

    public function wrongActionCall()
    {
        $this->response(self::WRONG_ACTION_CALL, 'Try to call wrong action');
    }
}