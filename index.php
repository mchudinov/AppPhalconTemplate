<?php
define('APPROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';
//Logger::configure('log4php.xml');

try {
    (new \Phalcon\Loader())->registerDirs(array(
        APPROOT.'/src/classes/',
        APPROOT.'/src/',
		APPROOT,
		APPROOT.'/tests/classes/',
		APPROOT.'/tests/'
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


class MyFormatter implements Phalcon\Logger\FormatterInterface 
{
    function format($message, $type, $timestamp, $context)
    {
        return '['.date('Y-m-d H:m:s',$timestamp).']'.' '.'['.$this->getType($type).']'.' '.$message.PHP_EOL;
    }
    
    private function getType($type)
    {
        $strType = "AAA";
        switch($type)
        {
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                break;
        }
        return $strType;
    }
}

//$logger = Logger::getLogger(1);
//$logger->info("This is an informational message.");
//$logger->warn("I'm not feeling so good...");


$logger = new Phalcon\Logger\Adapter\File(APPROOT.'/log/MyApp2-'.date('Y-m-d').'.log');
$logger->setFormatter(new MyFormatter());
$logger->log("This is a message");
$logger->log("This is an error");
$logger->error("This is another error");


echo (new DateTime())->format('Y-m-d');

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
    