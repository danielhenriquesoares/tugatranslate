<?php
/**
 * Created by PhpStorm.
 * User: daniel-soares
 * Date: 12/28/13
 * Time: 7:20 PM
 */

require_once 'init.php';

// Define public/captcha path

defined('PUBLIC_CAPTCHA') ||
    define('PUBLIC_CAPTCHA', realpath(dirname(__FILE__) . '/../public/captcha/'));


$files = glob(PUBLIC_CAPTCHA."/*");

// verificar se existem mais de 6 ficheiros
if (count($files) > 6){

    foreach ($files as $file) {
        unlink($file);
    }
}
