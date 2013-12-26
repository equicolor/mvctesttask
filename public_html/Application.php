<?php

include 'Controller.php';

class Application 
{
	public static $app;
	
	public $router;
	public $db;
	
	public function __construct($configFile)
	{
		$config = eval(file_get_contents($configFile));
		$this->init($this, $config);
		
		if (!is_null($this->db))
			$this->db->init();
			
		self::$app = $this;
	}
	
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
					include($value['class'] . '.php');
					$obj->$key = new $value['class'];
				}
				
				$this->init($obj->$key, $value);
			}
		}
	}
	
	public function run()
	{
		$route = $this->router->parseRoute($_GET['r']);
		
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