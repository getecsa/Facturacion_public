<?php
//Versión 1.0 Oct-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/admin/adminDocs.inc');
			$tpl->prepare();
			$tpl->assign('mod',$mod);
			$documento = new Documento();
			$documentos = $documento->consultarTiposDocumentos();
			$indice = 1;
			foreach($documentos as $item){
				$tpl->newblock('registros');
				$tpl->assign('indice',$indice++);
				$tpl->assign('idDoc',$item['idDoc']);
				$tpl->assign('tipoDocumento',utf8_encode($item['tipoDocumento']));
				if($item['estatus'] == 1){
					$tpl->assign('estatus','Activo');
					$tpl->assign('estatusVal',0);
					$tpl->assign('nombreArchivo','remove');
				}else{
					$tpl->assign('estatus','Inactivo');
					$tpl->assign('estatusVal',1);
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