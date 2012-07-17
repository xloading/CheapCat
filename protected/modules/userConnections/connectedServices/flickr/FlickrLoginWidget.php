<?php
/**
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class FlickrLoginWidget extends AbstractLoginWidget
{
    public $loggedInHtml = 'Flickr: you logged in';
    public $options = array();
    public $assetsUrl;
    public $publishAssets = true;

    public function init(){
        Yii::import('application.extensions.filters.publishAssets.EPublishAssetsFilter');
    }

    public function run()
    {
        EPublishAssetsFilter::publish($this);
        if (!$this->service->isAuthenticated) {
            $this->render('loginWidget', $this->options);
        }
    }
}