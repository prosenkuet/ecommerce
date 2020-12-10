<?php
function myclass_autoloader($class) {
	require_once $_SERVER['DOCUMENT_ROOT'] . "/ecommerce/classes/" . $class . '.class.php';
}
spl_autoload_register('myclass_autoloader');
?>