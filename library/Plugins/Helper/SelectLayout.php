<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daniel-soares
 * Date: 8/15/13
 * Time: 9:55 AM
 * To change this template use File | Settings | File Templates.
 */

class Plugins_Helper_SelectLayout extends Zend_Controller_Plugin_Abstract {

    private $dontUseLayouts = array('api');

    public function preDispatch(Zend_Controller_Request_Abstract $request){

        // Obter o nome do módulo
        $module = $request->getModuleName();

        if (!in_array($module,$this->dontUseLayouts)){

            // Devo de iniciar o layout primeiro senão quando faço get $layout fica com o valor null
            Zend_Layout::startMvc();
            // Obter uma instância de layout
            $layout = Zend_Layout::getMvcInstance();

            // Obter o bootstrap
            $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            $options = $bootstrap->getOptions(); // Obter as opções (do application.ini)
            $layoutPathTemp = $options['constants']['layoutPath'];// Para este caso quero o path onde estão os layouts
            $layoutPath = $layoutPathTemp . '/' . $module;// O path para os layouts será algo do género APPLICATION_PATH/layouts/scripts/nome_módulo

            if (!file_exists($layoutPath)){

                throw new Exception("The directory ".$layoutPath. " does not exist. Please create it.");

            }else{

                $layout->setLayoutPath($layoutPath);// Definir o novo caminho para os layouts
                $layout->setLayout('layout');// as views de layouts chamam-se layout.phtml
            }
        }/*else{
            $request->setDispatched(true);
        }*/
    }

}