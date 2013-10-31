<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    private $logFile = "/tmp/logs.txt";

    protected function _initViewHelpers(){

        $view = new Zend_View();
        $view->headTitle('Tuga Translate')->setSeparator(' - ');
    }

    protected function _initAutoLoad(){

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Plugins_');

    }

    protected function _initPlugins(){

        try{

            $front = Zend_Controller_Front::getInstance();
            $front->registerPlugin(new Plugins_Helper_Maintenance());
            $front->registerPlugin(new Plugins_Helper_SelectLayout());
            /*$front->registerPlugin(new Plugins_Twitter_Form());
            $front->registerPlugin(new Plugins_Twitter_Form_Decorator_Checkboxlabel());
            $front->registerPlugin(new Plugins_Twitter_Form_Decorator_Errors());*/


        }catch(Exception $ex){

            $writer = new Zend_Log_Writer_Stream($this->logFile);
            $log = new Zend_Log($writer);

            $log->log('Error occured: ' . $ex,Zend_Log::ERR);

        }
    }

    protected function _initConstants(){

        $registry = Zend_Registry::getInstance();
        $registry->constants = new Zend_Config($this->getApplication()->getOption('constants'));
    }

    protected function _initDoctype(){

        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    /*public function _initNavigation(){
        $container  = new Zend_Config_Xml(APPLICATION_PATH.'/configs/menu.xml','nav');
        $navigation = new Zend_Navigation($container);

        $this->bootstrap("view");
        $view = $this->getResource("view");
        $view->navigation($navigation);
    }*/


}

