<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if(true){
//if($user->checkSession((isset($_SESSION['usuario']['nombre'])) ? $_SESSION['usuario']['nombre'] : NULL)){
	//if($user->checkValidUser($_SESSION['usuario']['id'])){
	if(true){
		if(true){
		//if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$tpl = new TemplatePower('template/admin/administracionUsuarios.inc');
			$tpl->prepare();
			$registrosUsuarios = $user->consultarUsuarios();
			$indice = 1;
			foreach($registrosUsuarios as $item){
				$tpl->newblock('registros');
				$tpl->assign('indice',$indice++);
				$tpl->assign('id',$item['id']);
				$tpl->assign('nombre',$item['nombre']);
				$tpl->assign('usuario',$item['usuario']);
				$tpl->assign('area',utf8_encode($item['area']));
				$estatus = $user->consultaEstatus($item['estatus']);
				$tpl->assign('estatus',$estatus['strEstatus']);
				if($item['estatus'] == 1){
					$tpl->assign('estatusVal',0);
					$tpl->assign('nombreArchivo','remove');
					$tpl->assign('titleEstatus','Suspender');
				}else if($item['estatus'] == 0){
					$tpl->assign('estatusVal',1);
					$tpl->assign('nombreArchivo','Autorizada');
					$tpl->assign('titleEstatus','Reactivar');
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