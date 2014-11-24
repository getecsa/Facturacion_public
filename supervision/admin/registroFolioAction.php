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
	$estatusEval = $_POST['estatusEval'];
	// Se decidió que el Folio está Pendiente. *
	if($estatusEval == 3){
		$usuarioControl = 0;
		$bloqueo        = 0;
		$bandeja        = 1; //-> Se queda en Bandeja de Exportaciones. 
	}else{
		$bloqueo        = 1; //-> Se bloquea el registro.
		$usuarioControl = $_SESSION['usuario']['id'];
		$bandeja        = 2; //-> Se envía a Bandeja de Pendiente Respuesta ABD.
	}
	//
	$actions = array('guardar' => array('object'     => 'Bandeja',
										'method'     => 'procesaFolio',
										'objectMail' => 'Correo',
										'methodMail' => 'procesaEnvioCorreo'));
	if(isset($actions[$_POST['acc']])){
		$useArray = $actions[$_POST['acc']];
		$obj = new $useArray['object'];
		$obj->setBandeja($bandeja);
		$obj->setEstatusEval($estatusEval);
		$obj->setBloqueado($bloqueo);
		$obj->setFechaPendiente($estatusEval);
		$obj->setFechaTomo($estatusEval);
		$obj->setJustificaciones($_POST['justificaciones']);
		$obj->setPerfil($_SESSION['usuario']['perfil']);
		if(TRUE === $msg = $obj->$useArray['method']($usuarioControl)){
			$objMail = new $useArray['objectMail'];
			if(TRUE === $msg = $objMail->$useArray['methodMail']($_POST['folioAbd'],1,$estatusEval,
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