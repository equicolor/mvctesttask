<?php

class Application 
{
	public static $app;
	
	public $router;
	public $db;
		
	public function __construct($configFile)
	{
		$config = require_once($configFile);
		$this->init($this, $config);
		
		if (!is_null($this->db))
		{
			$this->db->init();
		}
		
		self::$app = $this;
	}
	
	// очень хрупкое место, рекурсивно читаю конфиг
	// и создаю объекты, если их нет.. так нельзя, походу)
	// но зато в одном месте хранятся конфиги бд и роутера. на скорую руку, наверное, сойдет..
	public function init($obj, $config)
	{
		foreach ($config as $key => $value)
		{
			if (!is_array($value))
			{
				if (property_exists($obj, $key))
				{
					$obj->$key = $value;
				}
			}
			else
			{
				if (is_null($obj->$key) && isset($value['class']))
				{
					$obj->$key = new $value['class'];
				}
				
				$this->init($obj->$key, $value);
			}
		}
	}
	
	public function run()
	{
		$route = $this->router->parseRoute(isset($_GET['r']) ? $_GET['r'] : '');
		
		$controllerId = $route[0];
		$actionId = $route[1];
		
		$controllerFile = 'controllers' . DIRECTORY_SEPARATOR . $controllerId . 'Controller.php';
		
		try 
		{
			if (file_exists($controllerFile))
			{
				include $controllerFile;
				
				$controllerClassname = $controllerId . 'Controller';
				$controller = new $controllerClassname;
				$controller->runAction($actionId);
			}
			else
				throw new Exception ('Bad route');
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
}