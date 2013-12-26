<?php

function __autoload($classname)
{
	include $classname . '.php';
}

$app = new Application('config.php');
$app->run();