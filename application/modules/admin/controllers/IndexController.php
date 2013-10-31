<?php

class Admin_IndexController extends Zend_Controller_Action
{
    private $session = null;

    protected function getSession()
    {
        if ($this->session === null){
            $this->session = new Zend_Auth_Storage_Session();
        }

        return $this->session;
    }

    public function indexAction()
    {
        $sessionData = $this->getSession()->read();

        if (!$sessionData){
            $this->redirect('default/index');
        }
    }

    public function adminAction()
    {
        // action body
    }


}



