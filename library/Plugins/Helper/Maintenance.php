<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daniel-soares
 * Date: 8/15/13
 * Time: 9:59 AM
 * To change this template use File | Settings | File Templates.
 */

class Plugins_Helper_Maintenance extends Zend_Controller_Plugin_Abstract {

    protected $maintenance_file = "/application/tmp/maintenance.txt";

    public function preDispatch(Zend_Controller_Request_Abstract $request){

        if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))).$this->maintenance_file)){

            $request->setModuleName('maintenance');
            $request->setControllerName('index');
            $request->setActionName('index');
            $request->setDispatched(true);
        }
    }

}