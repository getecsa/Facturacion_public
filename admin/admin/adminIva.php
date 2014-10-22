<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/admin/adminIva.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$iva = new Iva();
			$arrIva = $iva->consultarIva();
			$indice = 1;
			foreach($arrIva as $item){
				$tpl->newblock('registros');
				$tpl->assign('indice',$indice++);
				$tpl->assign('idIva',$item['idIva']);
				$tpl->assign('tipoIva',utf8_encode($item['tipoIva']));
				$tpl->assign('valorIva',round($item['valorIva'],2));
				if($item['estatus'] == 1){
					$tpl->assign('estatus','Activo');
					$tpl->assign('estatusVal',0);
					$tpl->assign('titleEstatus','Desactivar Tasa');
					$tpl->assign('nombreArchivo','remove');
				}else{
					$tpl->assign('estatus','Inactivo');
					$tpl->assign('estatusVal',1);
					$tpl->assign('titleEstatus','Activar Tasa');
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