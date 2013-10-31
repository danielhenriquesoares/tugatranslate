<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daniel-soares
 * Date: 8/15/13
 * Time: 12:11 PM
 * To change this template use File | Settings | File Templates.
 */

defined('MY_PATH')
|| define('MY_PATH', realpath(dirname(__FILE__) . '/../'));


$tempFolder = MY_PATH . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

switch($argv[1]){

    case 'up':
                echo "Setting maintenance page\n";
                touch($tempFolder.'maintenance.txt');
                break;
    case 'down':
                echo "Removing maintenance page\n";
                if (file_exists($tempFolder.'maintenance.txt')){
                    unlink($tempFolder.'maintenance.txt');
                    exit;
                }
                echo "Maintenance page not set yet\n";
                break;

    default: echo "Invalid parameter used\n";

}