<?php
define('APPROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';
define('TESTRUNNER',true);

try {
    (new \Phalcon\Loader())->registerDirs(array(
        APPROOT.'/src/classes/',
        APPROOT.'/src/',
		APPROOT,
		APPROOT.'/tests/classes/',
		APPROOT.'/tests/'
    ))->register();
} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}