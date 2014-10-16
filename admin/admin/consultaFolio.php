<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$bandeja = new Bandeja($_SESSION['usuario']['perfil']);
			if(strcmp($mod,'reasigna') == 0){
				$tpl = new TemplatePower('template/admin/reasignaFolio.inc');
				$tpl->prepare();
				$tpl->assign('mod',$mod);
				$tpl->assign('titulo','Reasignación');
				$datosFolio = $bandeja->consultaFolio($_POST['folio']);
				// Consulta de Datos del Perfil Actual y Perfil Destino. *
				$datosPerfil = $bandeja->consultaPerfilBandeja($datosFolio['perfil'],$datosFolio['bandeja']);
				$tpl->assign('perfilActual',$datosPerfil['nombrePerfil']);
				if($datosFolio['perfil'] == 3){
					$tpl->newblock('perfiles');
					$tpl->assign('valuePerfil',4);
					$tpl->assign('nombrePerfil','Exportaciones Mty.');
					$tpl->gotoBlock('_ROOT');
				}else if($datosFolio['perfil'] == 4){
					$tpl->newblock('perfiles');
					$tpl->assign('valuePerfil',3);
					$tpl->assign('nombrePerfil','Exportaciones D.F.');
					$tpl->gotoBlock('_ROOT');
				}
				//
				// Bandeja Actual y Bandeja Destino. *
				$tpl->assign('bandejaActual',$datosPerfil['nombreBandeja']);
				switch($datosFolio['bandeja']){
					// Actual en Bandeja Cobranza. *
					case 3:
						$item = $bandeja->consultaPerfilBandeja('',2);
						$tpl->assign('ultimaBandejaVal',2);
						//-> Sólo se puede mover a Bandeja Pendiente Respuesta ABD.
						$tpl->newblock('bandejas');
						$tpl->assign('valueBandeja',$item['idBandeja']);
						$tpl->assign('nombreBandeja',$item['nombreBandeja']);
						$tpl->gotoBlock('_ROOT');
						break;
					// Actual en Bandeja Reversiones. *
					case 4:
						$item = $bandeja->consultaPerfilBandeja('',3);
						$tpl->assign('ultimaBandejaVal',2);
						//-> Sólo se puede mover a Bandeja Cobranza.
						$tpl->newblock('bandejas');
						$tpl->assign('valueBandeja',$item['idBandeja']);
						$tpl->assign('nombreBandeja',$item['nombreBandeja']);
						$tpl->gotoBlock('_ROOT');
						break;
					// Actual en Bandeja Líneas Activas. *
					case 7:
						$item = $bandeja->consultaPerfilBandeja('',6);
						$tpl->assign('ultimaBandejaVal',4);
						//-> Sólo se puede mover a Bandeja Respuesta ABD Reersión.
						$tpl->newblock('bandejas');
						$tpl->assign('valueBandeja',$item['idBandeja']);
						$tpl->assign('nombreBandeja',$item['nombreBandeja']);
						$tpl->gotoBlock('_ROOT');
						break;
					default:
						break;
				}
				//
			}else if(strcmp($mod,'desbloqueo') == 0){
				$tpl = new TemplatePower('template/admin/desbloqueoFolio.inc');
				$tpl->prepare();
				$tpl->assign('mod',$mod);
				$tpl->assign('titulo','Desbloqueo');
			}
			$tpl->assign('folioAbd',$_POST['folio']);
			if($bandeja->consultaBloqueoFolio($_POST['folio'])){
				$strEstatus   = 'NO Disponible';
				$estatus      = 1;
				$classEstatus = 'no-disponible';
			}else{
				$strEstatus = 'Disponible';
				$estatus    = 0;
				$classEstatus = 'disponible';
			}
			$tpl->assign('estatus',$strEstatus);
			$tpl->assign('estatusClass',$classEstatus);
			$tpl->assign('estatusVal',$estatus);
			$tpl->printToScreen();
		}
	}
}