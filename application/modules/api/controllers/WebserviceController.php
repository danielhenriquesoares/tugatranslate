<?php

class Api_WebserviceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function processAction()
    {

        $api = new Api_Model_TugatranslateApi($this->getRequest());
        //echo $api->processApi('Api_Model_TugatranslateApi');

        $response = $this->getResponse();
        $response->setBody($api->processApi('Api_Model_TugatranslateApi'));

        return;

    }
}

