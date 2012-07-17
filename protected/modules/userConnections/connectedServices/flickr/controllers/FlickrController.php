<?php
class FlickrController extends Controller
{
    public $layout = '/layouts/empty';

    public function accessRules()
    {
        return CMap::mergeArray(
            array(
                 array(
                     'allow',
                     'actions' => array('api'),
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

    public function actionAuthenticate()
    {
        $service = $this->module->getComponent('flickr');
        if ($service->authenticate()) {
            $content = "<script type='text/javascript'>window.opener.finishFlickrAuthenticate('{$service->token}');window.close();</script>";
            $layoutFile = $this->getLayoutFile($this->layout);
            $this->renderFile($layoutFile, array('content' => $content));
        }
    }

    public function actionApi($action = null)
    {
        $apiController = new FlickrApiController('flickrApi');
        $action = 'action' . ucwords($action);
        if (method_exists($apiController, $action)) {
            return $apiController->$action();
        }
        return $apiController->wrongActionCall();
    }
}

class FlickrApiController extends JsonController
{
    const ITEM_NOT_FOUND = 4;
    const WRONG_ITEM_OWNER = 5;
    const WRONG_ACTION_CALL = 6;

    public function actions()
    {
        //		return array(
        //			'getAddresses' => array(
        //				'class' => 'application.components.JsonSearchAction',
        //				'modelClass' => 'AddressBook'
        //			)
        //		);
    }

    public function actionGetAlbums()
    {
        $service = Yii::app()->getModule('userConnections')->getComponent('flickr');
        $api = $service->getApi();
        require_once('Phlickr/AuthedPhotosetList.php');
        require_once('Phlickr/AuthedPhoto.php');
        $authedPhotosetList = new Phlickr_AuthedPhotosetList($api);
        $data = $authedPhotosetList->getPhotosets();
        $i = 0;
        $result = array();
        foreach ($data as $photoset) {
            $attributes = (array)$photoset->getXml()->attributes();
            $result[$i]['attributes'] = $attributes['@attributes'];
            $result[$i]['title'] = $photoset->getXml()->title->__toString();
            $result[$i]['description'] = $photoset->getXml()->description->__toString();
            $photoId = $result[$i]['attributes']['primary'];
            $photo = new Phlickr_AuthedPhoto($api, $photoId);
            $result[$i]['cover'] = $photo->buildImgUrl(Phlickr_AuthedPhoto::SIZE_75PX);
            $i++;
        }
        $this->response(self::ACTION_COMPLETED, $result);
    }

    public function actionGetPhotos()
    {
        $service = Yii::app()->getModule('userConnections')->getComponent('flickr');
        $api = $service->getApi();
        require_once('Phlickr/Photoset.php');
        if (!isset($_GET['setId']) || empty($_GET['setId'])) {
            return $this->response(self::WRONG_REQUEST_ATTRIBUTES, 'Wrong setId data');
        }
        $photoSet = new Phlickr_Photoset($api, $_GET['setId']);
        $data = $photoSet->getPhotoList()->getPhotos();
        $i = 0;
        foreach ($data as $photo) {
            $attributes = (array)$photo->getXml()->attributes();
            $result[$i] = $attributes['@attributes'];
            $result[$i]['thumbUrl'] = $photo->buildImgUrl(Phlickr_Photo::SIZE_75PX);
            $result[$i]['photoUrl'] = $photo->buildImgUrl(Phlickr_Photo::SIZE_1024PX);
            $i++;
        }
        $this->response(self::ACTION_COMPLETED, $result);
    }

    public function wrongActionCall()
    {
        $this->response(self::WRONG_ACTION_CALL, 'Try to call wrong action');
    }
}
