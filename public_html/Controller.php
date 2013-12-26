<?php

abstract class Controller
{
	public function getId()
	{
		$class = get_class($this);
		// уверен, это далеко не лучший способ, получить id контроллера..
		return substr($class, 0, strlen($class) - strlen('Controller'));
	}
	
	public function runAction($action)
	{
		$actionMethod = 'action' . ucfirst($action);
		if (method_exists($this, $actionMethod))
		{
			$this->$actionMethod();
		}
		else
			$this->missingAction($action);
	}
	
	public function missingAction()
	{
		throw new Exception('Missing action ' . $action);
	}
	
	public function render($view, $params = array())
	{
		$viewFile = 'views' . DIRECTORY_SEPARATOR . $this->getId()
							. DIRECTORY_SEPARATOR . $view . '.php';
		
		if (file_exists($viewFile))
		{
			$this->renderInternal($viewFile, $params);
		}
		else
			throw new Exception('View not found');
	}
	
	//взял из исходников yii, разворачваем параметры в переменные
	public function renderInternal($_viewFile_, $_data_ = null, $_return_ = false)
	{
		// we use special variable names here to avoid conflict when extracting data
		if(is_array($_data_))
			extract($_data_, EXTR_PREFIX_SAME, 'data');
		else
			$data = $_data_;
		require($_viewFile_);
	}
}