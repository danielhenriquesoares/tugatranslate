<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initNavigation(){

        $container  = new Zend_Config_Xml(APPLICATION_PATH.'/configs/menu.xml','nav');
        $navigation = new Zend_Navigation($container);

        /*$this->bootstrap("view");
        $view = $this->getResource("view");
        $view->navigation($navigation);*/
        $adminNavigation = Zend_Registry::getInstance();
        $adminNavigation->set('Admin_Navigation',$navigation);
    }
}

