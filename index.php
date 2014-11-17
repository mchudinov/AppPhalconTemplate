<?php
define('APPROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';

class LogFormatterFile implements Phalcon\Logger\FormatterInterface 
{
    function format($message, $type, $timestamp, $context)
    {
        return '['.date('Y-m-d H:m:s',$timestamp).']'.' '.'['.$this->getMessageType($type).']'.' '.$message.PHP_EOL;
    }
    
    private function getMessageType($n)
    {
		$class = new ReflectionClass('Phalcon\Logger');
    	$constants = $class->getConstants();
    	$constName = null;
    	foreach ( $constants as $name => $value )
    	{
    		if ( $value == $n )
    		{
    			$constName = $name;
    			break;
    		}
    	}
    	return $constName;
    }
}

class Logger
{
	static function getLogger()
	{
		$logger = new Phalcon\Logger\Multiple();
		$adapterFile = new Phalcon\Logger\Adapter\File(APPROOT.'/log/MyApp-'.date('Y-m-d').'.log');
		$adapterFile->setFormatter(new LogFormatterFile());
		$adapterFirePhp = new Phalcon\Logger\Adapter\Firephp("");
		$logger->push($adapterFile);
		//$logger->push($adapterFirePhp);
		return $logger;
	}
}


class DependencyInjector
{
	static function getInjector()
	{
		$di = new Phalcon\DI\FactoryDefault();
		$di->set('AnnotationsAdapter', function() {
			return new \Phalcon\Annotations\Adapter\XCache();
		});
		$di->set('Logger', function() {
			echo 123;
			return Logger::getLogger(1);
		});
		return $di;
	}
}


function isMethodAnnotated($obj, $strMethod)
{
	$di = DependencyInjector::getInjector();
	$adapter = $di->getAnnotationsAdapter();
	$reflector = $adapter->get(get_class($obj));

	//Прочесть аннотации в блоке документации класса
	$annotations = $reflector->getMethodsAnnotations();

	//Произвести обход всех аннотаций
	foreach ($annotations as $annotation) {
		var_dump($annotation);
		
		//var_dump(get_class_methods($annotation));
		//var_dump($annotation->get('Log'));
		//Вывести название аннотации
		//echo $annotation->getName(), PHP_EOL;

		//Вывести количество аргументов
		//echo $annotation->numberArguments(), PHP_EOL;

		//Вывести аргументы
		//print_r($annotation->getArguments());
	}
}


function initApplication()
{
	try {
		(new \Phalcon\Loader())->registerDirs(array(
			APPROOT.'/src/classes/',
			APPROOT.'/src/',
			APPROOT,
			APPROOT.'/tests/classes/',
			APPROOT.'/tests/'
		))->register();
		
		$di = DependencyInjector::getInjector();
		$logger = $di->getLogger();
		var_dump($logger);
		//$logger->log("LOG");
		//$logger->debug("DEBUG");
		//$logger->info("INFO");
		//$logger->notice("NOTICE");
		//$logger->warning("WARNING");
		//$logger->error("ERROR");
		//$logger->critical("CRIICAL");
		//$logger->alert("ALERT");
		//$logger->emergency("EMERGENCY");		
	} catch(\Phalcon\Exception $e) {
		 $logger->error("PhalconException: ".$e->getMessage());
	}
}

initApplication();

$m = new MyClass();
echo $m->getTrue();


isMethodAnnotated($m,'getTrue');