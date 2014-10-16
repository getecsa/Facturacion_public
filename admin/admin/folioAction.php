<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Recolección de Variables TIPO POST *
				foreach($_POST as $nombreCampo => $valor){
					$asignacion = '$' . $nombreCampo . '=\'' . $valor . '\';';
			    	if(!is_numeric($nombreCampo)){
			    		eval($asignacion);
			    	}
				}
				//
				$actions = array('guardar' => array('object' => 'Bandeja',
													'method' => 'procesaFolio'));
				if(isset($actions[$_POST['acc']])){
					$useArray = $actions[$_POST['acc']];
					$obj = new $useArray['object'];
					$obj->setPerfil($perfilSel);
					$obj->setTipoProcesaFolio($mod);
					if(TRUE === $msg = $obj->$useArray['method']($idUsuario)){
						echo 'error';
					}else{
						echo 'error';
					}
				}else{
					echo 'Error al procesar la acción.';
				}
				echo 'error';
			}else{
				echo 'error';
			}
		}
	}
}else{
	echo 'error';
}