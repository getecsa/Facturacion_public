<?php
//Versión 1.0 Oct-14
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	session_start();
	include_once '../config/dbCred.inc.php';
	date_default_timezone_set('America/Mexico_City');
	mysqli_report(MYSQLI_REPORT_STRICT);
	foreach ($C as $name => $val){
		define($name,$val);
	}
	function __autoload($class)
	{
		$fileName = "../class/class." . strtolower($class) . ".inc.php";
		if(file_exists($fileName)){
			include_once $fileName;
		}
	}
	$actions = array('guardar' => array('object' => 'Bandeja',
										'method' => 'validarFolio'));
	$useArray = $actions[$_POST['acc']];
	$obj = new $useArray['object'];
	if(isset($actions[$_POST['acc']])){
		if(TRUE === $msg = $obj->$useArray['method']($_SESSION['usuario']['id'])){
			echo $obj->getMsgSolicitud();
		}else{
			echo $obj->getMsgSolicitud();
		}
	}else{
		echo 'Error al procesar la acción.';
	}
}else{
	echo 'Error al procesar la solicitud.';
}