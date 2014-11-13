<?php
define('APPPATH', __DIR__.DIRECTORY_SEPARATOR);
require_once APPPATH.'vendor/autoload.php';
Logger::configure('log4php.xml');

try {
    (new \Phalcon\Loader())->registerDirs(array(
        APPPATH.'/src/classes/',
        APPPATH.'/src/',
		APPPATH,
		APPPATH.'/tests/classes/',
		APPPATH.'/tests/'
    ))->register();

    $di = new Phalcon\DI\FactoryDefault();
	$di->set('annotations', function() {
        return new \Phalcon\Annotations\Adapter\Memory();
    }); 
} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}

$m = new MyClass();
echo $m->getTrue();


$logger = Logger::getLogger(1);
$logger->info("This is an informational message.");
$logger->warn("I'm not feeling so good...");


/**
 * @Cache
 */
class MyClass2
{
	/**
     * @Log
     */
    function getTrue()
    {
        return true;
    }
}

$reader = new \Phalcon\Annotations\Adapter\Memory();
$reflector = $reader->get('MyClass2');

var_dump($reflector);
//Прочесть аннотации в блоке документации класса
$annotations = $reflector->getMethodsAnnotations();
var_dump($annotations);

//Произвести обход всех аннотаций
foreach ($annotations as $annotation) {
var_dump($annotation);
    //Вывести название аннотации
    //echo $annotation->getName(), PHP_EOL;

    //Вывести количество аргументов
    //echo $annotation->numberArguments(), PHP_EOL;

    //Вывести аргументы
    //print_r($annotation->getArguments());
}
    