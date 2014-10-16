<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$tpl = new TemplatePower('template/admin/adminPlantillasCorreoForm.inc');
			$tpl->prepare();
			$tpl->assign('acc',$acc);
			$tpl->printToScreen();
		}
	}
}