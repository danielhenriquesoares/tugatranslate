<?php

class Maintenance_IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {

        if (file_exists(APPLICATION_PATH . '/tmp/maintenance.txt')){
            $this->getResponse()->setHttpResponseCode(503);
        }else{
            $this->redirect('default/index');
        }
    }


}

