<?php

class Router 
{
	public $defaultController;
	public $defaultAction;

	public function parseRoute($route)
	{
		$controller = $this->defaultController;
		$action = $this->defaultAction;
		
		if (isset($route) && !empty($route))
		{
			if ($pos = strpos($route, '/'))
			{
				$controller = substr($route, 0, $pos);
				$action = substr($route, $pos + 1);
			}
			else
				$controller = $route;
		}	
		
		return array(
			$controller,
			$action
		);
	}
}