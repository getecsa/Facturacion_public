<?php
/**
* Acciones con el Menú Principal (accesos, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Menu
{
	private $_nombreSesion;
	private $_tipoPerfil;
	private $_stockBajo;

	public function __construct($nombreUser = '',$perfil = ''){
		if(isset($nombreUser)){
			$this->_nombreSesion = $nombreUser;
		}else{
			$this->_nombreSesion = '';
		}
		if(isset($perfil)){
			$this->_tipoPerfil = $perfil;
		}else{
			$this->_tipoPerfil = '';
		}
	}

	public function verMenuPrincipal()
	{
		if(is_int($this->_tipoPerfil)){
			switch($this->_tipoPerfil){
				case 1:
					$tpl = new TemplatePower('template/menuPrincipalAdmin.inc');
					$tpl->prepare();
					$tpl->assign('titulo','Inicio');
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$tpl->printToScreen();
					break;
				case 2:
					$tpl = new TemplatePower('template/menuPrincipalCobranza.inc');
					$tpl->prepare();
					$tpl->assign('titulo','Inicio');
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$tpl->printToScreen();
					break;
				case 3:
				case 4:
					$tpl = new TemplatePower('template/menuPrincipal.inc');
					$tpl->prepare();
					$tpl->assign('titulo','Inicio');
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);				
					$tpl->printToScreen();
					break;
				default:
					$tpl = new TemplatePower('template/perfilInvalido.inc');
					$tpl->prepare();
					$tpl->assign('titulo','Inicio');
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);			
					$tpl->printToScreen();
					break;
			}
		}
	}
	public function verMenu($mod,$windowTitle = NULL)
	{
		if(is_int($this->_tipoPerfil)){
			switch($this->_tipoPerfil){
				case 1:
					$tpl = new TemplatePower('template/menuAdmin.inc');
					$tpl->prepare();
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$tpl->assign('tituloVentana',$windowTitle);
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					switch($mod){
						case 'reasigna':
						case 'desbloqueo':
						case 'folio':
							$tpl->assign('activoAdminFolio','activo');
							break;
						case 'reporte':
							$tpl->assign('activoReportes','activo');
							break;
						case 'users':
						case 'tplcorreo':
							$tpl->assign('activoAdmin','activo');
							break;
						default:
							break;
					}
					$tpl->printToScreen();
					break;
				case 2:
					$tpl = new TemplatePower('template/menuCobranza.inc');
					$tpl->prepare();
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					if(strcmp($mod,'cobranza') == 0){
						$tpl->assign('activoCobranza','activo');
					}
					$tpl->printToScreen();
					break;
				case 3:
				case 4:
					$tpl = new TemplatePower('template/menu.inc');
					$tpl->prepare();
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$tpl->assign('tituloVentana',$windowTitle);
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);
					$config = $this->getConfigurationSystem();
					$tpl->assign('systemName',$config['systemName']);
					$tpl->assign('systemVersion',$config['systemVersion']);
					$tpl->assign('actualYear',$config['actualYear']);
					$tpl->assign('systemDeveloper',$config['systemDeveloper']);
					$tpl->assign('urlDeveloper',$config['urlDeveloper']);
					switch($mod){
						case 'solicitudes':
							$tpl->assign('activoBandExport','activo');
							break;
						case 'penres':
							$tpl->assign('activoBandPendRes','activo');
							break;
						case 'reversiones':
							$tpl->assign('activoBandRever','activo');
							break;
						case 'resprever':
							$tpl->assign('activoBandResRever','activo');
							break;
						case 'linactivas':
							$tpl->assign('activoBandLinAct','activo');
							break;
						case 'incidencias':
							$tpl->assign('activoBandIncide','activo');
							break;
						default:
							break;
					}				
					$tpl->printToScreen();
					break;
				default:
					$tpl = new TemplatePower('template/menu.inc');
					$tpl->prepare();
					$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
					$horaActual =date('G:i:s') . ' hrs.';
					$tpl->assign('horaActual',$horaActual);				
					$tpl->printToScreen();
					break;
			}
		}
	}
	public function verInicioSesion()
	{
		$tpl = new TemplatePower('template/sesion.inc');
		$tpl->prepare();
		$tpl->assign('nombreUsuarioSesion',$this->_nombreSesion);
		$horaActual =date('G:i:s') . ' hrs.';
		$tpl->assign('horaActual',$horaActual);			
		$tpl->printToScreen();
	}
	/**
	* Función para setear la configuración del Sistema.
	*
	*/
	public function getConfigurationSystem()
	{
		$data =array("systemName"      => 'Gestor de Exportaciones y Reversiones',
					 "systemVersion"   => 'ver 1.0',
					 "actualYear"      => '2014',
					 "systemDeveloper" => '',
					 "urlDeveloper"    => '');
		return $data;
	}
}