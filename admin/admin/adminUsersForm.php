<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if(true){
//if($user->checkSession((isset($_SESSION['usuario']['nombre'])) ? $_SESSION['usuario']['nombre'] : NULL)){
	//if($user->checkValidUser($_SESSION['usuario']['id'])){
	if(true){
		if(true){
		//if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$tpl = new TemplatePower('template/admin/administracionUsuariosForm.inc');
			$tpl->prepare();
			$tpl->assign('acc',$acc);
			if(strcmp($acc,'edit') == 0){
				$tpl->assign('tituloPagina','Editar Usuario');
				$tpl->assign('idUser',$_POST['iduser_' . $_GET['row']]);
				$datosUsuario = $user->consultaUsuario($_POST['iduser_' . $_GET['row']]);
				/*switch($datosUsuario['perfil']){
					case 1:
						$tpl->assign('selectedAdmin','selected');
						break;
					case 2:
						$tpl->assign('selectedCobr','selected');
						break;
					case 3:
						$tpl->assign('selectedDf','selected');
						break;
					case 4:
						$tpl->assign('selectedMty','selected');
						break;
					default:
						break;
				}*/
				$tpl->assign('nombre',$datosUsuario['nombre']);
				$tpl->assign('usuario',$datosUsuario['usuario']);
				$tpl->assign('readOnlyUser','readOnly');
			}else if(strcmp($acc,'form') == 0){
				$tpl->assign('tituloPagina','Nuevo Usuario');
				$tpl->assign('readOnlyUser','');
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