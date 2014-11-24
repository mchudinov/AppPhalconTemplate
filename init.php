<?php
defined('APPROOT') or die('No direct access.');
require_once APPROOT.'config.php';

class LogFormatterFile implements Phalcon\Logger\FormatterInterface 
{
    function format($message, $type, $timestamp, $context)
    {
        return '['.date('Y-m-d H:m:s',$timestamp).']'.' '.'['.$this->getMessageType($type).']'.' '.$message.' '.$context.PHP_EOL;
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
    private static $_instance;
    private function __construct()
    {}
    private function __clone()
    {}
    
	static function getLogger($level)
	{
        if (null === self::$_instance) 
        {
            self::$_instance = new Phalcon\Logger\Multiple();
            $adapterFile = new Phalcon\Logger\Adapter\File(APPROOT.'/log/MyApp-'.date('Y-m-d').'.log');
            $adapterFile->setFormatter(new LogFormatterFile());
            $adapterFile->setLogLevel($level);
            $adapterFirePhp = new Phalcon\Logger\Adapter\Firephp("");
            $adapterFirePhp->setLogLevel($level);
            self::$_instance->push($adapterFile);
            self::$_instance->push($adapterFirePhp);
        }
		return self::$_instance;
	}
}


class DependencyInjector
{
    private static $_instance;
    private function __construct()
    {}
    private function __clone()
    {}
    
	static function getContainer()
	{
        if (null === self::$_instance) 
        {
            self::$_instance = new Phalcon\DI();
            self::$_instance['annotationsadapter'] = function() {
                return new \Phalcon\Annotations\Adapter\XCache();
            };
            self::$_instance['logger'] = function() {
                return Logger::getLogger(\Phalcon\Logger::DEBUG);
            };
        }
		return self::$_instance;
	}
}


function isMethodAnnotated($obj, $strMethod, $strAnnotation)
{
    $bReturn = false;
	$container = DependencyInjector::getContainer();
	$adapter = $container->getAnnotationsadapter();
	$reflector = $adapter->get(get_class($obj));

	$annotations = $reflector->getMethodsAnnotations();
    if (is_array($annotations))
    {
        foreach ($annotations as $key => $collection) 
        {
            if (strtolower($key) == strtolower($strMethod))
            {
                foreach ($collection as $annotation) 
                {
                    if ($annotation->getName() == $strAnnotation)
                        $bReturn = true;
                }
            }
        }
    }
	return $bReturn;
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
		
        $config = new \Phalcon\Config($GLOBALS['settings']);
        $config2 = new \Phalcon\Config\Adapter\Ini(APPROOT.'config.ini');
        $config->merge($config2);
        var_dump($config);
        
		$container = DependencyInjector::getContainer();
		$logger = $container->getLogger();	
	} catch(\Phalcon\Exception $e) {
		 $logger->error("PhalconException: ".$e->getMessage());
	}
}
