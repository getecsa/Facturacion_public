<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			switch($opc){
				case 'sel':
					$tpl = new TemplatePower('template/admin/adminPermisosSelPerfil.inc');
					$tpl->prepare();
					$tpl->assign('mod',$mod);
					$tpl->assign('acc',$acc);
					$perfiles = $user->consultarPerfiles();
					foreach($perfiles as $item){
						$tpl->newblock('registros');
						$tpl->assign('idPerfil',$item['idPerfil']);
						$tpl->assign('nombrePerfil',utf8_encode($item['nombrePerfil']));
						$tpl->gotoBlock('_ROOT');
					}
					break;
				case 'view':
					$tpl = new TemplatePower('template/admin/adminPermisosPerfil.inc');
					$tpl->prepare();
					$tpl->assign('mod',$mod);
					$tpl->assign('acc','guardar');
					$perfilSel = $user->consultaPerfil($_POST['perfilSel']);
					$tpl->assign('idPerfil',$perfilSel['idPerfil']);
					$tpl->assign('perfilSel',$perfilSel['nombrePerfil']);
					break;
				default:
					break;
				
			}
			$tpl->printToScreen();
		}
	}
	// Se imprime el footer de la Página. *
	$tpl = new TemplatePower('inc/footer.inc');
	$tpl->prepare();
	$tpl->assign('nombreProyecto',PROJECT_NAME);
	$tpl->assign('yearDevelop',YEAR_DEVELOP);
	$tpl->assign('resolucionMinima',MIN_RESOLUTION);
	$tpl->printToScreen();
	//
}