<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/admin/adminAreasForm.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$area = new Area();
			switch($opc){
				case 'new':
					$tpl->assign('tituloPagina','Nueva Área');
					$tiposAreas = $area->consultarTiposAreas();
					foreach($tiposAreas as $item){
						$tpl->newblock('registros');
						$tpl->assign('idTipoArea',$item['idTipoArea']);
						$tpl->assign('nombreTipoArea',$item['nombreTipoArea']);
						$tpl->gotoBlock('_ROOT');
					}
					break;
				case 'edit':
					$tpl->assign('tituloPagina','Editar Área');
					$regArea = $area->consultaArea($_POST['idarea_' . $_GET['row']]);
					$tpl->assign('idArea',$_POST['idarea_' . $_GET['row']]);
					$tiposAreas = $area->consultarTiposAreas();
					foreach($tiposAreas as $item){
						$tpl->newblock('registros');
						if($item['idTipoArea'] == $regArea['idTipoArea']){
							$tpl->assign('selectedTipoArea','selected');
						}
						$tpl->assign('idTipoArea',$item['idTipoArea']);
						$tpl->assign('nombreTipoArea',utf8_encode($item['nombreTipoArea']));
						$tpl->gotoBlock('_ROOT');
					}
					$tpl->assign('nombreArea',utf8_encode($regArea['nombreArea']));
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