<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/admin/adminIvaForm.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$iva = new Iva();
			switch($opc){
				case 'new':
					$tpl->assign('tituloPagina','Nueva Tasa');
					break;
				case 'edit':
					$tpl->assign('tituloPagina','Editar Tasa');
					$regIva = $iva->consultaTasaIva($_POST['idiva_' . $_GET['row']]);
					$tpl->assign('idIva',$_POST['idiva_' . $_GET['row']]);
					$tpl->assign('nombreTasa',utf8_encode($regIva['nombreTasa']));
					$tpl->assign('valorTasa',round($regIva['valorTasa'],2));
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