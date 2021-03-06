<?php
defined('APPROOT') or die('No direct access.');

$GLOBALS['settings'] = array(
    'application' => array(
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
    ),
	'log' => array(
		'enable' => true, 											
		'level' => 'info', 											// debug|error|warning|info
		'adapter' => 'file'										// file|firephp
	)
);

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
    
	static function getLogger($enable, $level, $appname, $adapter)
	{
        if (null === self::$_instance) 
        {
            self::$_instance = new Phalcon\Logger\Multiple();
			
			if ($enable)
			{
				if (strstr(strtolower($adapter), 'file'))
				{
					try{
						$adapterFile = @(new Phalcon\Logger\Adapter\File(APPROOT.'/log/'.$appname.'-'.date('Y-m-d').'.log'));
						$adapterFile->setFormatter(new LogFormatterFile());
						$adapterFile->setLogLevel($level);
						self::$_instance->push($adapterFile);
					}
					catch(\Exception $e){
						//echo "Exception: ".$e->getMessage();
					}
				}
				
				if (strstr(strtolower($adapter), 'firephp'))
				{
					$adapterFirePhp = new Phalcon\Logger\Adapter\Firephp("");
					$adapterFirePhp->setLogLevel($level);
					self::$_instance->push($adapterFirePhp);
				}
			}
        }
		return self::$_instance;
	}
}


class Config
{
    private static $_instance;
    private function __construct()
    {}
    private function __clone()
    {}
    
	static function getConfig()
	{
        if (null === self::$_instance) 
        {
			self::$_instance = new \Phalcon\Config($GLOBALS['settings']);
			$config = new \Phalcon\Config();
			if (property_exists(self::$_instance->application, 'configfile'))
			{
				$config = new \Phalcon\Config\Adapter\Ini(APPROOT.self::$_instance->application->configfile);
			}
			self::$_instance->merge($config);
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
			self::$_instance['config'] = Config::getConfig();
            
			$objConfig = self::$_instance->getConfig();
			$loglevel = $objConfig->log->level;                     // \Phalcon\Logger::ERROR;
            $appname = str_replace(' ', '', $objConfig->application->name);
			$adapter = $objConfig->log->adapter;
            $enable = $objConfig->log->enable;
			self::$_instance['logger'] = function() use ($enable, $loglevel, $appname, $adapter){
                return Logger::getLogger($enable, $loglevel, $appname, $adapter);
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
	} catch(\Phalcon\Exception $e) {
		$container = DependencyInjector::getContainer();
		$logger = $container->getLogger();
		$logger->error("PhalconException: ".$e->getMessage());
	}
}
