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
				// Catálogo de IVA. *
				case 'iva':
					$menu->verMenu($mod,'Catálogos - I.V.A. - Telefónica Movistar');
					switch($acc){
						case 'form':
							include_once 'admin/adminIvaForm.php';
							break;
						case 'con':
							include_once 'admin/adminIva.php';
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
				// Catálogo de Monedas. *
				case 'monedas':
					$menu->verMenu($mod,'Catálogos - Monedas - Telefónica Movistar');
					switch($acc){
						case 'form':
							include_once 'admin/adminMonedasForm.php';
							break;
						case 'con':
							include_once 'admin/adminMonedas.php';
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
				// Catálogo de CFDI. *
				case 'cfdi':
					$menu->verMenu($mod,'Catálogos - CFDI - Telefónica Movistar');
					switch($acc){
						case 'form':
							include_once 'admin/adminFolio.php';
							break;
						case 'con':
							include_once 'admin/adminCfdi.php';
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
				// Catálogo de Documentos. *
				case 'docs':
					$menu->verMenu($mod,'Catálogos - Documentos - Telefónica Movistar');
					switch($acc){
						case 'form':
							include_once 'admin/adminFolio.php';
							break;
						case 'alta':
							include_once 'admin/adminDocs.php';
							break;
						case 'permisos':
							include_once 'admin/adminDocsPermisos.php';
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
				default:
					$menu->verMenu($mod,'Administracíon - Menú Principal - Telefónica Movistar');
					$tpl = new TemplatePower('template/menu.inc');
					$tpl->prepare();
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