<?php
//Versión 1.0 Oct-14
$user = new Usuario();
if($user->checkSession($_SESSION['usuario']['nombre'])){
	if($user->checkValidUser($_SESSION['usuario']['id'])){
		if($user->checkAccessUser($_SESSION['usuario']['id'])){
			$tpl = new TemplatePower('./template/admin/muestraPlantilla.inc');
			$tpl->prepare();
			switch($opc){
				case 'evalaceptada':
					$tpl->assign('titulo','Plantilla de Correo - Evaluación Aceptada');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/evaluacionAceptada.inc';
					break;
				case 'evalrechazada':
					$tpl->assign('titulo','Plantilla de Correo - Evaluación Rechazada');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/evaluacionRechazada.inc';
					break;
				case 'evalpendiente':
					$tpl->assign('titulo','Plantilla de Correo - Evaluación Pendiente');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/evaluacionPendiente.inc';
					break;
				case 'penresacept':
					$tpl->assign('titulo','Plantilla de Correo - Pendiente Respuesta Aceptada');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/pendienteRespuestaAceptado.inc';
					break;
				case 'penresrech':
					$tpl->assign('titulo','Plantilla de Correo - Pendiente Respuesta Rechazada');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/pendienteRespuestaRechazado.inc';
					break;
				case 'cobranzatiempo':
					$tpl->assign('titulo','Plantilla de Correo - Cobranza en Tiempo');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/cobranzaEnTiempo.inc';
					break;
				case 'cobranzademora':
					$tpl->assign('titulo','Plantilla de Correo - Cobranza Demorado');
					$tpl->assign('opc',$opc);
					$fileName = './template/correo/cobranzaDemora.inc';
					break;
				default:
					$tpl->assign('titulo','Desconocido');
					$tpl->assign('opc',$opc);
					$fileName = '';
			}
			$archivo = fopen($fileName,'rb');
			if($archivo){
			    $tpl->assign('texto',fread($archivo,filesize($fileName)));
			    fclose($archivo);
			}else{
				echo "Error: No se pudo leer el archivo.";
			}
			$tpl->printToScreen();
		}
	}
}