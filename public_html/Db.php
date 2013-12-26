<?php

class Db 
{
	public $driver = 'mysql';
	public $host;
	public $dbname;
	public $user;
	public $password;
	
	protected $_pdo;
	
	public function init()
	{
		try 
		{	
			$this->_pdo = new PDO(
				"$this->driver:host=$this->host;dbname=$this->dbname",
				$this->user,
				$this->password
			);
		} 
		catch (PDOException $e) 
		{
			print 'Error!: ' . $e->getMessage() . '<br/>';
			die();
		}
	}
	
	public function query($sql)
	{
		$q = $this->_pdo->query($sql);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		return $q->fetchAll();
	}
	
	public function __destruct()
	{
		$this->_pdo = null;
	}
}