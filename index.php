<?php
define('APPROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';
require_once APPROOT.'init.php';

initApplication();

$m = new MyClass();
echo $m->getTrue();

echo isMethodAnnotated($m,'getFalse','LogDebug');

$container = DependencyInjector::getContainer();
$config = $container->getConfig();
var_dump($config);
$logger = $container->getLogger();

$logger->log("LOG");
$logger->debug("DEBUG");
$logger->info("INFO");
$logger->notice("NOTICE");
$logger->warning("WARNING");
$logger->error("ERROR");
$logger->alert("ALERT");
