<?php
//Versión 1.0 Nov-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/reportes/consultaReporteForm.inc');
			$area = new Area();
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$areas = $area->consultarAreas('WHERE suspendido = 0 AND oper_sol = 0');
			foreach($areas as $item){
				$tpl->newblock('areas');
				$tpl->assign('codigoArea',$item['idArea']);
				$tpl->assign('nombreArea',utf8_encode($item['nombreArea']));
				$tpl->gotoBlock('_ROOT');
			}
			$sla = array('CUMPLE SLA','NO CUMPLE SLA','TODAS');
			$index = 1;
			foreach($sla as $item){
				$tpl->newblock('slas');
				$tpl->assign('codigoSla',$index++);
				$tpl->assign('nombreSla',$item);
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