<?php
defined('APPROOT') or die('No direct access');

$GLOBALS['settings'] = array(
    'app' => array(
        'version' => '1.0',
        'description' => 'Phalcon template', 
        'copyright' => '(c) 2014-2015 Mikael Chudinov' ,
        'developer' => 'Mikael Chudinov',                                                        
        'developermail' => 'mikael@chudinov.net',
        'configfile' => 'config.ini',
    ),
    'cache' => array(
        'enable' => true,
        'ttl' => 28800
    )
);