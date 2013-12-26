<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index', array(
			'foo' => 'bar',
			'bar' => 'foo'
		));
	}
	
	public function actionTest()
	{
		$this->render('test', array(
			'test' => 123,
			'test2' => array(1, 2, 3, 4, 5)
		));
	}
	
	public function actionPdo()
	{
		$this->render('pdo', array(
			'rows' => Application::$app->db->query('SELECT * FROM test'),
		));
	}	
}