<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$tpl = new TemplatePower('template/admin/adminFolioForm.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			if(strcmp($mod,'reasigna') == 0){
				$tpl->assign('titulo','Reasignación');
			}else if(strcmp($mod,'desbloqueo') == 0){
				$tpl->assign('titulo','Desbloqueo');
			}else if(strcmp($mod,'folio') == 0){
				$tpl->assign('titulo','Consulta de Histórico');
			}
			$tpl->printToScreen();
		}
	}
}