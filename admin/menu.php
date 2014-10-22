<?php
//Versión 1.0 Oct-14
session_start();
require 'template/class.TemplatePower.inc.php';
include_once 'inc/header.inc';
include_once 'init.inc.php';
$user = new Usuario();
if($user->checkSession((isset($_SESSION['usuario']['nombre'])) ? $_SESSION['usuario']['nombre'] : NULL)){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$ventana = new Menu($_SESSION['usuario']['nombre'],$_SESSION['usuario']['perfil']);
			$mod = 'inicio';
			$ventana->verMenuPrincipal($mod);
			$ventana->mostrarFooter();
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
	$tpl->assign('urlInicioSesion','./');
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