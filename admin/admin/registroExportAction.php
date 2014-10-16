<?php
//Versión 1.0 Oct-14
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	session_start();
	include_once '../config/dbCred.inc.php';
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
	// Varbiables POST. *
	$decision = $_POST['decisionFolio'];
	if($_POST['fechaFvcVal'] != '00000000'){
		$fechaFvc =explode('/',$_POST['fechaFvcVal']);
		$fechaFvc = $fechaFvc[2].$fechaFvc[1].$fechaFvc[0];
	}else{
		$fechaFvc = '00000000';
	}
	//
	$actions = array('guardar' => array('object' => 'Bandeja',
										'method' => 'procesaExport',
										'objectMail' => 'Correo',
										'methodMail' => 'procesaEnvioCorreo'));
	if(isset($actions[$_POST['acc']])){
		$useArray = $actions[$_POST['acc']];
		$obj = new $useArray['object'];
		// Se decide que SI se va a Exportar el Folio. *
		if($decision == 1){
			$bandeja         = 3; //-> Se va a la Bandeja de Cobranza.
			$estatus         = 1; //-> Se mantiene el estatus en Proceso.
			$estatusPendResp = 1; //-> Se mantiene el estatus en Proceso en la Bandeja.
		// Se decide que NO se va a Exportar el Folio. *
		}else if($decision == 2){
			$bandeja         = 2; //-> Se queda en la Bandeja de Pendiente Respuesta ABD.
			$estatus         = 4; //-> Se pone estatus de finalizado el proceso en la solicitud.
			$estatusPendResp = 2; //-> Se pone estatus de finalizado el proceso en la bandeja de la solicitud.
		}
		$obj->setBandeja($bandeja);
		$obj->setEstatus($estatus);
		$obj->setDecisionExport($decision);
		$obj->setEstatusPendResp($estatusPendResp);
		$obj->setFechaFvc($fechaFvc);
		if(TRUE === $msg = $obj->$useArray['method']($_SESSION['usuario']['id'])){
			$objMail = new $useArray['objectMail'];
			if(TRUE === $msg = $objMail->$useArray['methodMail']($_POST['folioAbd'],2,$decision,
			$_SESSION['usuario']['perfil'])){
				echo $objMail->getMsgAction();
			}else{
				echo $obj->getMsgSolicitud();
			}
		}else{
			echo $obj->getMsgSolicitud();
		}
	}else{
		echo 'Error al procesar la acción.';
	}
}else{
	echo 'Error al procesar la solicitud.';
}