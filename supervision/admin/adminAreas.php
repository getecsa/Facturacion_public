<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/admin/adminAreas.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$area = new Area();
			$areas = $area->consultarAreas();
			$indice = 1;
			foreach($areas as $item){
				$tpl->newblock('registros');
				$tpl->assign('indice',$indice++);
				$tpl->assign('idArea',$item['idArea']);
				$tpl->assign('nombreArea',utf8_encode($item['nombreArea']));
				$tpl->assign('tipoArea',$item['tipoArea']);
				if($item['estatus'] == 1){
					$tpl->assign('estatus','Activo');
					$tpl->assign('estatusVal',0);
					$tpl->assign('titleEstatus','Desactivar Área');
					$tpl->assign('nombreArchivo','remove');
				}else{
					$tpl->assign('estatus','Inactivo');
					$tpl->assign('estatusVal',1);
					$tpl->assign('titleEstatus','Activar Área');
					$tpl->assign('nombreArchivo','Autorizada');
				}
				$tpl->gotoBlock('_ROOT');
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