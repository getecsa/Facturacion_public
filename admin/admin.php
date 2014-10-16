<?php
/**
* Controlador del Módulo de Administración.
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
session_start();
require 'template/class.TemplatePower.inc.php';
include_once 'inc/header.inc';
include_once 'init.inc.php';
$user = new Usuario();
if(true){
//if($user->checkSession((isset($_SESSION['usuario']['nombre'])) ? $_SESSION['usuario']['nombre'] : NULL)){
	//$menu = new Menu($_SESSION['usuario']['nombre'],$_SESSION['usuario']['perfil']);
	$menu = new Menu('Admin',1);
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
				// Reasignación de Folios *
				case 'reasigna':
					$menu->verMenu($mod);
					switch($acc){
						case 'form':
							include_once 'admin/adminFolio.php';
							break;
						case 'con':
							include_once 'admin/consultaFolio.php';
							break;
						case 'guardar':
							include_once 'admin/folioAction.php';
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
				// Desbloqueo de Folios. *
				case 'desbloqueo':
					$menu->verMenu($mod);
					switch($acc){
						case 'form':
							include_once 'admin/adminFolio.php';
							break;
						case 'con':
							include_once 'admin/consultaFolio.php';
							break;
						case 'guardar':
							include_once 'clientes/registroClientesAction.php';
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
				// Generar Reporte. *
				case 'reporte':
					$menu->verMenu($mod);
					switch($acc){
						case 'form':
						case 'edit':
							include_once 'clientes/registroClientes.php';
							break;
						case 'con':
							include_once 'reportes/consultaReporte.php';
							break;
						case 'guardar':
							include_once 'clientes/registroClientesAction.php';
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
				// Consulta Histórico del Folio. *
				case 'folio':
					$menu->verMenu($mod);
					switch($acc){
						case 'form':
							include_once 'admin/adminFolio.php';
							break;
						case 'con':
							include_once 'consultas/consultaHistoricoFolio.php';
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
				// Administración de Usuarios. *
				case 'users':
					$menu->verMenu($mod,'Administración - Usuarios - Telefónica Movistar');
					switch($acc){
						case 'con':
							include_once 'admin/administracionUsuarios.php';
							break;
						case 'form':
						case 'edit':
							include_once 'admin/adminUsersForm.php';
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
				// Administración de las Plantillas de los Correos Automáticos. *
				case 'tplcorreo':
					switch($acc){
						case 'con':
							$menu->verMenu($mod);
							include_once 'admin/adminPlantillasCorreo.php';
							break;
						case 'form':
						case 'edit':
							$menu->verInicioSesion();
							include_once 'admin/adminPlantillas.php';
							break;
						//
						default:
							$menu->verMenu($mod);
							$tpl = new TemplatePower('template/errorRequest.inc');
							$tpl->prepare();
							$tpl->assign('mensaje','Error al Procesar la Solicitud');
							$tpl->printToScreen();
							break;
					}
					break;
				//	
				default:
					$menu->verMenu($mod);
					$tpl = new TemplatePower('template/errorRequest.inc');
					$tpl->prepare();
					$tpl->assign('mensaje','No se encontró la opción solicitada.');
					$tpl->printToScreen();
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