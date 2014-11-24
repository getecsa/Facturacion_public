<?php
/**
* Controlador del Módulo de Supervisión.
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Nov-14
*/
session_start();
require 'template/class.TemplatePower.inc.php';
include_once 'inc/header.inc';
include_once 'init.inc.php';
$user = new Usuario();
if(true){
//if($user->checkSession((isset($_SESSION['usuario']['nombre'])) ? $_SESSION['usuario']['nombre'] : NULL)){
	//$menu = new Menu($_SESSION['usuario']['nombre'],$_SESSION['usuario']['perfil']);
	$menu = new Menu('Superv',2);
	//if($user->checkValidUser($_SESSION['usuario']['id'])){
	if(true){
		if(true){
		//if($user->checkAccessUser($_SESSION['usuario']['id'])){
			// Inicialización de Variables *
			$mod  = '';
			$acc  = '';
			$opc  = '';
			//
			// Variables de TIPO GET y POST *
			if(isset($_POST['mod'])){
				$mod = $_POST['mod'];
			}else if(isset($_GET['mod'])){
				$mod = $_GET['mod'];
			}
			if(isset($_POST['acc'])){
				$acc = $_POST['acc'];
			}else if(isset($_GET['acc'])){
				$acc = $_GET['acc'];
			}
			if(isset($_POST['opc'])){
				$opc = $_POST['opc'];
			}else if(isset($_GET['opc'])){
				$opc = $_GET['opc'];
			}
			//
			switch($mod){
				// Catálogo de Áreas *
				case 'areas':
					$menu->verMenu($mod,'Catálogos - Áreas - Telefónica Movistar');
					switch($acc){
						case 'form':
							include_once 'admin/adminAreasForm.php';
							break;
						case 'con':
							include_once 'admin/adminAreas.php';
							break;
						//
						default:
							$tpl = new TemplatePower('template/errorRequest.inc');
							$tpl->prepare();
							$tpl->assign('mensaje','Error al Procesar la Solicitud');
							$tpl->printToScreen();
							break;
					}
					break;
				//
				default:
					$menu->verMenu($mod,'Supervisor de ' . 'Direccionamiento' . ' - Inicio - Gesofa - Telefónica');
					$tpl = new TemplatePower('template/inicio.inc');
					$tpl->prepare();
					$tpl->assign('nombreArea','Direccionamiento');
					//$tpl->assign('nombreArea',$_SESSION['nombreArea']);
					$tpl->printToScreen();
					// Se imprime el footer de la Página. *
					$tpl = new TemplatePower('inc/footer.inc');
					$tpl->prepare();
					$tpl->assign('nombreProyecto',PROJECT_NAME);
					$tpl->assign('yearDevelop',YEAR_DEVELOP);
					$tpl->assign('resolucionMinima',MIN_RESOLUTION);
					$tpl->printToScreen();
					//
					break;
			}
		}else{
			$tpl = new TemplatePower('template/errorAcceso.inc');
			$tpl->prepare();
			if(trim(strlen($user->getMsgErrorConnection())) > 0){
				$tpl->assign('displayError','block');
				$tpl->assign('mensajesError',$user->getMsgErrorConnection());
			}else{
				$tpl->assign('displayError','none');
				$tpl->assign('mensajesError','');
			}
			$tpl->assign('mensaje',$user->getErrorSessionMsg());
			$tpl->printToScreen();
		}
	}else{
		$tpl = new TemplatePower('template/errorUsuario.inc');
		$tpl->prepare();
		if(trim(strlen($user->getMsgErrorConnection())) > 0){
			$tpl->assign('displayError','block');
			$tpl->assign('mensajesError',$user->getMsgErrorConnection());
		}else{
			$tpl->assign('displayError','none');
			$tpl->assign('mensajesError','');
		}
		$tpl->assign('mensaje',$user->getErrorSessionMsg());
		$tpl->printToScreen();
	}
}else{
	$tpl = new TemplatePower('template/errorSesion.inc');
	$tpl->prepare();
	$tpl->assign('urlInicioSesion','../');
	if(trim(strlen($user->getMsgErrorConnection())) > 0){
		$tpl->assign('displayError','block');
		$tpl->assign('mensajesError',$user->getMsgErrorConnection());
	}else{
		$tpl->assign('displayError','none');
		$tpl->assign('mensajesError','');
	}
	$tpl->assign('mensaje','No se ha iniciado Sesión o la Sesión ha caducado');
	$tpl->printToScreen();
}