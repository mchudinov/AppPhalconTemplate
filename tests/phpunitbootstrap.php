<?php
define('APPPATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
require_once APPPATH.'vendor/autoload.php';
define('TESTRUNNER',true);

try {
    (new \Phalcon\Loader())->registerDirs(array(
        APPPATH.'/src/classes/',
        APPPATH.'/src/',
		APPPATH,
		APPPATH.'/tests/classes/',
		APPPATH.'/tests/'
    ))->register();
} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}