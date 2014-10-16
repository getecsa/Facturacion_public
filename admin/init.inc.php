<?php
/**
* Inicializar la configuración Básica del Aplicativo.
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
date_default_timezone_set('America/Mexico_City');
mysqli_report(MYSQLI_REPORT_STRICT);
include_once 'config/dbCred.inc.php';
foreach ($C as $name => $val){
	define($name,$val);
}
function __autoload($class)
{
	$fileName = "class/class." . strtolower($class) . ".inc.php";
	if(file_exists($fileName)){
		include_once $fileName;
	}
}