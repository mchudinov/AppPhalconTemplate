<?php
define('APPROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';
require_once APPROOT.'init.php';

initApplication();

$m = new MyClass();
echo $m->getTrue();

echo isMethodAnnotated($m,'getFalse','LogDebug');
