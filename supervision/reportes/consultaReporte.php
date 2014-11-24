<?php
//Versión 1.0 Nov-14
$user = new Usuario();
/*if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){*/
if(true){
	if(true){
		if(true){
			$tpl = new TemplatePower('template/consultas/muestraReporte.inc');
			$tpl->prepare();
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$actions = array('con' => array('object' => 'Reporte',
												'method' => 'consultarReporte'));
				if(isset($actions[$_POST['acc']])){
					$useArray = $actions[$_POST['acc']];
					$obj = new $useArray['object'];
					$area = new Area();
					$datosArea = $area->consultaArea($_POST['areasSel']);
					$tpl->assign('nombreArea',$datosArea['nombreArea']);
					if(!empty($datos = $obj->$useArray['method']())){
						
						foreach($datos as $item){
							$tpl->newblock('registros');
							$tpl->assign('nombreArea',$item['nombreArea']);
							$tpl->assign('indicador','Aceptados');
							$tpl->assign('numSolicitudes',$item['numSolicitudes']);
							$tpl->assign('enSLA',100);
							$tpl->assign('fueraSLA',100);
							$tpl->assign('semaforo','green');
							$tpl->assign('colorText','#FFFFFF');
							$tpl->assign('objetivo','100%');
							$tpl->gotoBlock('_ROOT');
						}
						
					}else{
						//echo $obj->getMsgSolicitud();
					}
					if(!empty($datos = $obj->$useArray['method']())){
						foreach($datos as $item){
							$tpl->newblock('registros');
							$tpl->assign('nombreArea',$item['nombreArea']);
							$tpl->assign('indicador','Rechazos');
							$tpl->assign('numSolicitudes',$item['numSolicitudes']);
							$tpl->assign('enSLA',100);
							$tpl->assign('fueraSLA',100);
							$tpl->assign('semaforo','green');
							$tpl->assign('colorText','#FFFFFF');
							$tpl->assign('objetivo','100%');
							$tpl->gotoBlock('_ROOT');
						}
					}else{
						//echo $obj->getMsgSolicitud();
					}
				}else{
					
					//echo 'Error al procesar la acción.';
				}
			}else{
				//echo 'Error al procesar la solicitud.';
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