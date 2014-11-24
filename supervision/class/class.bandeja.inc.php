<?php
/**
* Acciones con las Bandejas (accesos, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Bandeja extends DB_Connection
{
	private $_perfil;
	private $_perfilSel;
	private $_bandeja;
	private $_ultimaBandeja;
	private $_ticket;
	private $_fechaIncidente;
	private $_fechaPendiente;
	private $_fechaFvc;
	private $_fechaTomo;
	private $_decisionExport;
	private $_decisionPago;
	private $_decisionReversa;
	private $_decisionRespRever;
	private $_decisionLineaActiva;
	private $_justificacion;
	private $_justificaciones;
	private $_bloqueado;
	private $_estatus;
	private $_estatusCobranza;
	private $_estatusReversion;
	private $_estatusPendResp;
	private $_estatusLineaActiva;
	private $_estatusEval;
	private $_msgSolicitud;
	private $_campoValido = true;

	public function __construct($perfil = NULL,$dbo = NULL,$dbOracle = NULL){
		if(isset($perfil)){
			$this->_perfil = $perfil;
		}else{
			$this->_perfil = '';
		}
		parent::__construct($dbo,$dbOracle);
	}
	
	public function setPerfil($value){
		if($value == '' || $value == NULL){
			$this->_campoValido = false;
		}else{
			$this->_perfilSel = $value;
		}
	}
	public function setBandeja($value){
		if($value == '' || $value == NULL){
			$this->_campoValido = false;
		}else{
			$this->_bandeja = $value;
		}
	}
	public function setUltimaBandeja($value){
		if($value == '' || $value == NULL){
			$this->_campoValido = false;
		}else{
			$this->_ultimaBandeja = $value;
		}
	}
	public function setTicket($value){
		$this->_ticket = $value;
	}
	public function setJustificacion($value){
		$this->_justificacion = $value;
	}
	public function setJustificaciones($value){
		$this->_justificaciones = $value;
	}
	public function setFechaIncidente($value){
		$this->_fechaIncidente = $value;
	}
	public function setBloqueado($value){
		$this->_bloqueado = $value;
	}
	public function setFechaPendiente($value){
		if($value == 1 || $value == 2){
			$this->_fechaPendiente = '0000-00-00';
		}else{
			$this->_fechaPendiente = 'now()';
		}
	}
	public function setFechaFvc($value){
		$this->_fechaFvc = $value;
	}
	public function setFechaTomo($value){
		if($value == 1 || $value == 2){
			$this->_fechaTomo = 'now()';
		}else{
			$this->_fechaTomo = '0000-00-00';
		}
	}
	public function setDecisionExport($value){
		$this->_decisionExport = $value;
	}
	public function setDecisionPago($value){
		$this->_decisionPago = $value;
	}
	public function setDecisionReversa($value){
		$this->_decisionReversa = $value;
	}
	public function setDecisionRespRever($value){
		$this->_decisionRespRever = $value;
	}
	public function setDecisionLineaActiva($value){
		$this->_decisionLineaActiva = $value;
	}
	public function setEstatus($value){
		$this->_estatus = $value;
	}
	public function setEstatusEval($value){
		$this->_estatusEval = $value;
	}
	public function setEstatusPendResp($value){
		$this->_estatusPendResp = $value;
	}
	public function setEstatusCobranza($value){
		$this->_estatusCobranza = $value;
	}
	public function setEstatusReversion($value){
		$this->_estatusReversion = $value;
	}
	public function setEstatusLineaActiva($value){
		$this->_estatusLineaActiva = $value;
	}
	public function setTipoProcesaFolio($value){
		if($value == '' || $value == NULL){
			$this->_campoValido = false;
		}else{
			$this->_tipoProcesaFolio = $value;
		}
	}
	public function getTipoProcesaFolio(){
		return $this->_tipoProcesaFolio;
	}
	public function getMsgSolicitud(){
		return $this->_msgSolicitud;
	}
	public function setMsgSolicitud($value){
		$this->_msgSolicitud = $value;
	}
	public function consultaSemaforo($tipo = NULL,$dato = NULL)
	{
		$datos =array();
		switch($tipo){
			case 'diasHora':
				// Fecha y Hora de Ingreso. *
				$fechaHoraIngreso =explode(' ',$dato);
				$fechaIngreso = $fechaHoraIngreso[0];
				if(empty($fechaHoraIngreso[1])){
					$horaIngreso  = strtotime(date('H:i:s'));
				}else{
					$horaIngreso  = strtotime($fechaHoraIngreso[1]);
				}
				//
				// Fecha Actual. *
				$fechaActual =date('Y-m-d');
				//
				$fechaIngreso = new DateTime($fechaIngreso);
				$fechaActual = new DateTime($fechaActual);
				$interval = $fechaIngreso->diff($fechaActual);
				$diferencia = $interval->format('%R%a') + 0;
				switch($diferencia){
					case 0:
						if($horaIngreso <= strtotime('19:00:00')){
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}else{
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}
						break;
					case 1:
						if($horaIngreso <= strtotime('19:00:00')){
							if($horaIngreso <= strtotime('14:00:59')){
								$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
							}else if($horaIngreso >= strtotime('14:01:00')){
								$datos =array("semaforo" => 'red', "colorFuente" => '#FFFFFF');
							}else{
								$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
							}
						}else{
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}
						break;
					case 2:
						if($horaIngreso <= strtotime('19:00:00')){
							$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
						}else{
							if($horaIngreso <= strtotime('14:00:59')){
								$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
							}else if($horaIngreso >= strtotime('14:01:00')){
								$datos =array("semaforo" => 'red', "colorFuente" => '#000000');
							}else{
								$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
							}
						}
						break;
					default:
						$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
						break;
				}
				break;
			case 'dias':
				if($dato < 0){
					$dato = $dato * (-1);
				}
				if($dato >= 0 && $dato <= 7){
					$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
				}else if($dato == 8){
					$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
				}else if($dato == 9){
					$datos =array("semaforo" => 'red', "colorFuente" => '#FFFFFF');
				}else{
					$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
				}
				break;
			case 'diasRever':
				$horaActual = strtotime(date('H:i:s'));
				if($dato < 0){
					$dato = $dato - 1;
				}
				if($dato >= 0 && $dato <= 9){
					$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
				}else if($dato == 10 && $horaActual <= strtotime('14:00:59')){
					$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
				}else if($dato == 10 && $horaActual >= strtotime('14:01:00')){
					$datos =array("semaforo" => 'red', "colorFuente" => '#FFFFFF');
				}else{
					$datos =array("semaforo" => '#000000', "colorFuente" => '#FFFFFF');
				}
				break;
			case 'fechaHora':
				// Fecha y Hora de Ingreso. *
				$fechaHoraIngreso =explode(' ',$dato);
				$fechaIngreso = $fechaHoraIngreso[0];
				$horaIngreso  = strtotime($fechaHoraIngreso[1]);
				//
				// Fecha Actual. *
				$fechaActual =date('Y-m-d');
				//
				$fechaIngreso = new DateTime($fechaIngreso);
				$fechaActual = new DateTime($fechaActual);
				$interval = $fechaIngreso->diff($fechaActual);
				$diferencia = $interval->format('%R%a') + 0;
				switch($diferencia){
					case 0:
						if($horaIngreso <= strtotime('19:00:00')){
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}else{
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}
						break;
					case 1:
						if($horaIngreso <= strtotime('19:00:00')){
							$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
						}else{
							$datos =array("semaforo" => 'green', "colorFuente" => '#FFFFFF');
						}
						break;
					case 2:
						if($horaIngreso <= strtotime('19:00:00')){
							$datos =array("semaforo" => 'red', "colorFuente" => '#FFFFFF');
						}else{
							$datos =array("semaforo" => 'yellow', "colorFuente" => '#000000');
						}
						break;
					default:
						$datos =array("semaforo" => 'red', "colorFuente" => '#FFFFFF');
						break;
				}
				break;
		}
		return $datos;

	}
	public function consultarDias($fecha)
	{
		if($fecha != '0000-00-00'){
			// Fecha Actual. *
			$fechaActual =date('Y-m-d');
			//
			$fechaValor = new DateTime($fecha);
			$fechaActual = new DateTime($fechaActual);
			$interval = $fechaValor->diff($fechaActual);
			$dias = $interval->format('%R%a') + 0;
			if($dias < 0){
				$dias = $dias * (-1);
			}
		}else{
			$dias = 'N/A';
		}
		return $dias;
	}
	/**
	* Función para consultar el nombre del Perfil.
	*
	* @return string
	*/
	public function consultaPerfilBandeja($perfilActual = NULL,$bandejaNum = NULL)
	{
		$datos =array();
		switch($perfilActual){
			case 1:
				$perfil = 'Administrador';
				break;
			case 2:
				$perfil = 'Cobranza';
				break;
			case 3:
				$perfil = 'Exportaciones D.F.';
				break;
			case 4:
				$perfil = 'Exportaciones Mty.';
				break;
			default:
				$perfil = '-'; 
				break;
		}
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id,nombre FROM bandejas WHERE id = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$bandejaNum)){
			    		throw new Exception('Error: Obtener Dato');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('Error: Obtener Dato');
			    	}
			    	$stmt->bind_result($idBandeja,$bandejaNombre);
			    	if($stmt->fetch()){
			    		$bandeja = $bandejaNombre;
			    	}else{
			    		$bandeja = '';
			    	}
			    }else{
					throw new Exception('Error: Obtener Dato');
			    }
			    $stmt->close();
			}else{
				throw new Exception('Error: Obtener Dato');
			}
		}catch (Exception $e){
			$bandeja = $e->getMessage();
		}
		$datos =array("nombrePerfil" => $perfil,"idBandeja" => $idBandeja,"nombreBandeja" => $bandeja);
		return $datos;
	}
	/**
	* Función para consultar un Folio.
	*
	* @return string
	*/
	public function consultaFolio($folio)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.perfil,s.num_bandeja,s.q_tomo FROM solicitudes s WHERE s.folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folio)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($perfil,$bandeja,$qTomo);
			    	if($stmt->fetch()){
			    		$datos =array("perfil"      => $perfil,
			    					  "bandeja"     => $bandeja,
			    					  "usuarioTomo" => $qTomo);
			    		return $datos;
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			return $e->getMessage();
		}
	}
	/**
	* Función para consultar el Histórico de un Folio.
	* 
	* @param integer $folio Valor con el número de Folio a consultar.
	* @return array
	*/
	public function consultaHistoricoFolio($folio)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT (SELECT nombre FROM bandejas WHERE id = h.num_bandeja) AS bandeja,s.tipo_abd,s.no_dn,";
		        $sql .= "h.perfil,(SELECT nombre FROM usuarios WHERE id = h.id_usuario) AS nombreUsuario,h.f_alta, ";
		        $sql .= "h.justificacion FROM solicitudes s,historico h WHERE s.folio = h.folio AND s.folio = ? ";
		        $sql .= "ORDER BY h.id DESC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folio)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($bandeja,$tipoAbd,$noDn,$perfil,$nombreUsuario,$fechaIngreso,$justificacion);
			    	while($stmt->fetch()){
			    		$item =array("bandeja"        => $bandeja,
			    					 "tipoAbd"        => $tipoAbd,
			    					 "noDn"           => $noDn,
			    					 "perfil"         => $perfil,
			    					 "nombreUsuario"  => $nombreUsuario,
			    					 "fechaOperacion" => $fechaIngreso,
			    					 "justificacion"  => $justificacion);
			    		array_push($datos,$item);
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			return $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para consultar el registro de Evaluación de la Solicitud.
	*
	* @return mixed
	*/
	public function consultaSolicitudEval($folioAbd)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.estatus_eval,s.justificaciones FROM solicitudes s WHERE s.folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($estatusEval,$justificaciones);
			    	if($stmt->fetch()){
			    		$datos =array("estatusEval"     => $estatusEval,
			    					  "justificaciones" => $justificaciones);
			    		return $datos;
			    	}else{
			    		return false;
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}
	/**
	* Función para consultar si el folio de la solicitud esta Bloqueado.
	*
	* @return boolean
	*/
	public function consultaBloqueoFolio($folioAbd,$idUser = NULL)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT bloqueado,q_tomo FROM solicitudes WHERE folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($bloqueado,$quienTomo);
			    	if($stmt->fetch()){
			    		if($bloqueado == 1 && $quienTomo != $idUser){
			    			return true;
			    		}else{
			    			return false;
			    		}
			    	}else{
			    		return false;
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}
	/**
	* Función para consultar si el estatus de la solicitud ha terminado o esta en proceso.
	*
	* @return boolean
	*/
	public function consultaFolioEstatus($folioAbd)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT COUNT(folio) AS folio FROM solicitudes WHERE estatus >= 4 AND folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($folio);
			    	if($stmt->fetch()){
			    		if($folio > 0){
			    			return true;
			    		}else{
			    			return false;
			    		}
			    	}else{
			    		return false;
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}
	/**
	* Función para realizar el desbloqueo de un Folio.
	*
	* @return boolean
	*/
	public function desbloqueoFolio($idUser,$folioAbd)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "UPDATE solicitudes SET bloqueado = 0,q_tomo = 0 WHERE folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	if($this->procesaHistorico($idUser,$folioAbd,NULL,NULL,'Desbloqueó',0)){
			    		$this->setMsgSolicitud(1);
			    		return true;
			    	}else{
			    		throw new Exception('Se realizó el debloqueó con éxito. Error al agregar en Histórico.');
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			$this->setMsgSolicitud('Error: ' . $e->getMessage());
			return false;
		}
	}
	/**
	* Función para consultar si el Folio dado existe.
	*
	* @return boolean
	*/
	public function validarFolio()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				$folioAbd = $_POST['folioAbd'];
		        $sql = "SELECT COUNT(folio) AS folio,estatus FROM solicitudes WHERE folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS.');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN. Error: ' . $stmt->error);
			    	}
			    	$stmt->bind_result($folio,$estatus);
			    	if($stmt->fetch()){
			    		if($folio > 0){
			    			if($_POST['modCon'] == 'desbloqueo'){
				    			if($estatus < 4){
				    				$this->setMsgSolicitud(1);
				    				return true;
				    			}else{
				    				throw new Exception('El folio ABD ' . $folioAbd . ' ha finalizado su Proceso.');
				    			}
				    		}else{
				    			$this->setMsgSolicitud(1);
				    			return true;
				    		}
			    		}else{
			    			throw new Exception('El folio ABD ' . $folioAbd . ' no se encontró.');
			    		}
			    	}else{
			    		throw new Exception('El folio ABD ' . $folioAbd . 'no se encontró.');
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN. Error: ' . $stmt->error);
			    }
			    $stmt->close();
			}else{
				throw new Exception("No se conectó a la Base de Datos. " . $this->getMsgErrorConnection());
			}
		}catch (Exception $e){
			$this->setMsgSolicitud($e->getMessage());
			return false;
		}
	}
	/**
	* Función para procesar el cambio de Usuario de una Solicitud.
	*
	* @return boolean
	*/
	public function procesaTomaFolio($idUser)
	{
		$datos =array();
		try{
			if($this->db){
				$folioAbd = $_POST['folioAbd'];
    			$stmt = $this->db->stmt_init();
		        $sql = "UPDATE solicitudes SET q_tomo = ? WHERE folio = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('ii',$idUser,$folioAbd)){
			    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS.');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN. Error: ' . $stmt->error);
			    	}
			    	if($this->procesaHistorico($idUser,$folioAbd,0,NULL,'Cambió de Ejecutivo',$idUser)){
			    		$this->setMsgSolicitud(1);
			    		return true;
			    	}else{
			    		throw new Exception('Se realizó el cambio correctamente. Pero falló al ' . 
			    		'agregar en Histórico');
			    	}
			    	$stmt->close();
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN. Error: ' . $stmt->error);
			    }
			}else{
				throw new Exception("No se conectó a la Base de Datos. " . $this->getMsgErrorConnection());
			}
		}catch (Exception $e){
			$this->setMsgSolicitud($e->getMessage());
			return false;
		}
	}
	/**
	* Función para consultar las justificaciones de la Tabla justificaciones.
	*
	* @return array
	*/
	public function consultaJustificaciones()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id,descrip FROM justificaciones WHERE estatus = 1 ORDER BY id ASC;";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLA EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$descrip);
			    	while($stmt->fetch()){
			    		$item =array("id"      => $id,
			    					 "descrip" => $descrip,);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLA PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error:' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para consultar las justificaciones por ID.
	*
	* @return array
	*/
	public function consultaJustificacionesPorId($id)
	{
		$descrip = '';
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT descrip FROM justificaciones WHERE id = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$id)){
			    		throw new Exception('FALLÓ BIND PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLA EJECUCIÓN');
			    	}
			    	$stmt->bind_result($descrip);
			    	$stmt->fetch();
			    	$stmt->close();
				    return $descrip;
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}
	/**
	* Función para consultar una Solicitud por Folio.
	*
	* @return array
	*/
	public function consultaSolicitudesFolio($folioAbd)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT fecha_pendiente,justificaciones FROM solicitudes WHERE folio = ?;";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$folioAbd)){
			    		throw new Exception('FALLÓ BIND PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLA EJECUCIÓN');
			    	}
			    	$stmt->bind_result($fechaPendiente,$justificaciones);
			    	if($stmt->fetch()){
			    		$justificaciones =explode(",",$justificaciones);
			    		$fechaPendiente  =explode(" ",$fechaPendiente); 
			    		$datos =array('justificaciones' => $justificaciones,'fechaPendiente' => $fechaPendiente[0]);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para consultar la Bandeja de Solicitudes de Exportaciones.
	*
	* @return array
	*/
	public function consultaBandejaExportaciones()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id,folio,tipo_abd,no_dn,segmento,estado,fecha_pendiente,fecha_ingreso,";
		        $sql .= "estatus_eval,bloqueado,q_tomo FROM solicitudes WHERE estatus >= 1 AND estatus < 3 AND ";
		        $sql .= "perfil = ? AND num_bandeja = 1 ORDER BY fecha_ingreso ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$this->_perfil)){
			    		throw new Exception('FALLÓ BIND_PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$tipoAbd,$noDn,$segmento,$estado,$fechaPendiente,$fechaIngreso,
			    	$estatusEval,$bloqueado,$quienTomo);
			    	while($stmt->fetch()){
			    		$item =array("id"             => $id,
			    					 "folio"          => $folio,
			    					 "tipoAbd"        => $tipoAbd,
			    					 "noDn"           => $noDn,
			    					 "segmento"       => $segmento,
			    					 "estado"         => $estado,
			    					 "fechaPendiente" => $fechaPendiente,
			    					 "fechaIngreso"   => $fechaIngreso,
			    					 "estatusEval"    => $estatusEval,
			    					 "bloqueado"      => $bloqueado,
			    					 "qTomo"          => $quienTomo);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error:' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para consultar la Bandeja de Pendiente Respuesta ABD.
	*
	* @return array
	*/
	public function consultaPendientesRespuestaAbd()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,pr.fecha_ingreso,s.tipo_abd,s.no_dn,s.segmento,s.estado,s.estatus,";
		        $sql .= "s.bloqueado,s.q_tomo,pr.estatus_eval FROM solicitudes s,pendiente_respuesta pr WHERE ";
		        $sql .= "s.perfil = ? AND s.num_bandeja = 2 AND s.estatus < 3 AND ";
		        $sql .= "s.folio = pr.folio ORDER BY pr.fecha_ingreso ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$this->_perfil)){
			    		throw new Exception('FALLÓ BIND_PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$fechaIngreso,$tipoAbd,$noDn,$segmento,$estado,$estatus,$bloqueado,
			    	$quienTomo,$estatusEval);
			    	while($stmt->fetch()){
			    		$item =array("id"           => $id,
			    					 "folioAbd"     => $folio,
			    					 "fechaIngreso" => $fechaIngreso,
			    					 "tipoAbd"      => $tipoAbd,
			    					 "noDn"         => $noDn,
			    					 "segmento"     => $segmento,
			    					 "estadoScl"    => $estado,
			    					 "estatus"      => $estatus,
			    					 "estatusEval"  => $estatusEval,
			    					 "bloqueado"    => $bloqueado,
			    					 "qTomo"        => $quienTomo);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Pendiente Respuesta ABD.
	*
	* @return boolean
	*/
	public function guardaRegistroPendienteRespuesta($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO pendiente_respuesta (folio,fecha_ingreso,estatus,estatus_eval,";
						$sql .= "justificaciones,perfil,f_alta,q_alta) VALUES (?,now(),1,?,?,?,now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iisii',$folio,$this->_estatusEval,$this->_justificaciones,
					    	$this->_perfilSel,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar la Bandeja de Cobranza.
	*
	* @return array
	*/
	public function consultaBandejaCobranza()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,co.fecha_ingreso,s.tipo_abd,s.no_dn,s.segmento,s.estado,s.estatus,";
		        $sql .= "s.fecha_fvc FROM solicitudes s,cobranza co WHERE s.num_bandeja = 3 AND s.estatus < 3 AND ";
		        $sql .= "s.estatus_eval <> 3 AND fecha_fvc <> '0000-00-00' AND s.folio = co.folio ";
		        $sql .= "ORDER BY s.fecha_fvc ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLA EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$fechaIngreso,$tipoAbd,$noDn,$segmento,$estado,$estatus,$fechaFvc);
			    	while($stmt->fetch()){
			    		$item =array("id"           => $id,
			    					 "folioAbd"     => $folio,
			    					 "fechaIngreso" => $fechaIngreso,
			    					 "fechaFvc"     => $fechaFvc,
			    					 "tipoAbd"      => $tipoAbd,
			    					 "noDn"         => $noDn,
			    					 "segmento"     => $segmento,
			    					 "estadoScl"    => $estado,
			    					 "estatus"      => $estatus);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLA PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Cobranza.
	*
	* @return boolean
	*/
	public function guardaRegistroCobranza($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO cobranza (folio,fecha_ingreso,estatus,f_alta,q_alta) VALUES ";
						$sql .= "(?,now(),1,now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('ii',$folio,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	$this->setMsgSolicitud('Se guardó el registró.'); 
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para procesar una Solicitud de la Bandeja de Cobranza.
	*
	* @return boolean
	*/
	public function procesaBandejaCobranza($idUser,$folioAbd)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($folioAbd)){
				$folio = preg_replace('/[^0-9]/', '',$folioAbd);
				try{
					if($this->db){
						$stmt = $this->db->stmt_init();
						$sql = "UPDATE solicitudes s,cobranza co SET s.ultima_bandeja = ?,s.num_bandeja = ?,";
						$sql .= "s.estatus = ?,co.fecha_solicitud_reversa = now(),co.pago = ?,";
						$sql .= "co.estatus = ?,co.q_modi = ?,s.q_modi = ? WHERE s.folio = co.folio AND s.folio = ?";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iiiiiiii',$this->_ultimaBandeja,$this->_bandeja,$this->_estatus,
					    	$this->_decisionPago,$this->_estatusCobranza,$idUser,$idUser,$folio)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	if($this->_decisionPago == 1){
					    		$justificacion = 'Reversa Completa';
					    	}else{
					    		$justificacion = 'No pagó';
					    	}
					    	if($this->procesaHistorico($idUser,$folio,$this->_ultimaBandeja,NULL,$justificacion,$idUser)){
					    		if($this->_decisionPago == 2){
						    		$this->guardaRegistroBandejaReversion($idUser,$folio);
						    	}
						    	$this->setMsgSolicitud(1);
						    	return true;
					    	}else{
					    		throw new Exception('Se guardó el registro, pero Falló al Agregar al Histórico.');
					    	}
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN' . $stmt->error);
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->setMsgSolicitud('Error: ' . $e->getMessage());
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar la Bandeja de Reversiones.
	*
	* @return array
	*/
	public function consultaBandejaReversiones()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,s.tipo_abd,s.no_dn,s.segmento,s.fecha_fvc,s.bloqueado FROM solicitudes s,";
		        $sql .= "reversiones r WHERE r.folio = s.folio AND s.num_bandeja = 4 AND s.estatus >= 1 AND ";
		        $sql .= "s.estatus <= 3 ORDER BY s.fecha_fvc DESC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$tipoAbd,$noDn,$segmento,$fechaFvc,$bloqueado);
			    	while($stmt->fetch()){
			    		$item =array("id"             => $id,
			    					 "folioAbd"       => $folio,
			    					 "tipoAbd"        => $tipoAbd,
			    					 "noDn"           => $noDn,
			    					 "segmento"       => $segmento,
			    					 "fechaFvc"       => $fechaFvc,
			    					 "bloqueado"      => $bloqueado);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error:' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para procesar la Bandeja de Reversiones.
	*
	* @return boolean
	*/
	public function procesaBandejaReversion($idUser)
	{
		try{
			if($_POST['acc'] == 'guardar'){
				if(!empty($_POST['folioAbd'])){
					$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
					if($this->db){
						$stmt = $this->db->stmt_init();
				    	$sql = "UPDATE solicitudes s,reversiones r SET s.bloqueado = 1,s.ultima_bandeja = ";
				    	$sql .= "IF(s.num_bandeja = 4,4,6),s.num_bandeja = ?,s.ticket = ?,r.ticket = ?,";
				    	$sql .= "s.justificacion = ?,r.justificacion = ?,s.estatus = ?,r.estatus = ?,";
				    	$sql .= "r.se_reversa = ?,s.q_modi = ?,r.q_modi = ? WHERE s.folio = ?";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('issssiiiiii',$this->_bandeja,$this->_ticket,$this->_ticket,
					    	$this->_justificacion,$this->_justificacion,$this->_estatus,$this->_estatusReversion,
					    	$this->_decisionReversa,$idUser,$idUser,$folio)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN');
					    	}
					    	if($this->_justificacion != NULL || $this->_justificacion != ''){
					    		$justificacion = $this->_justificacion;
					    	}else{
					    		$justificacion = ($this->_decisionReversa == 2) ? 'No Reversado':'';
					    	}
					    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,$justificacion,$idUser)){
					    		if($this->_decisionReversa == 1){
						    		$this->guardaRegistroBandejaResRever($idUser);
						    	}else if($this->_decisionReversa == 3){
						    		$this->guardaRegistroBandejaIncidencias($idUser);
						    	}
						    	$this->_msgSolicitud = 1;
						    	return true;
					    	}else{
					    		throw new Exception('Se guardó el registro, pero Falló al agregar' . 
					    		'en Histórico.');
					    	}	    	
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error al conectar a la Base de Datos.");
					}
				}else{
					throw new Exception("Error al procesar el ID del Registro.");
				}
			}else{
				throw new Exception("Error al realizar la acción.");
			}
		}catch (Exception $e){
			$this->_msgSolicitud = $e->getMessage();
			return false;
		}
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Reversiones.
	*
	* @return boolean
	*/
	public function guardaRegistroBandejaReversion($idUser,$folioAbd)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($folioAbd)){
				$folio = preg_replace('/[^0-9]/', '',$folioAbd);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO reversiones (folio,fecha_ingreso,estatus,f_alta,q_alta) VALUES ";
						$sql .= "(?,now(),1,now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('ii',$folio,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja)){
						    	$this->setMsgSolicitud(1);
						    	return true;
					    	}else{
					    		throw new Exception('Se guardó el registro, pero Falló al Agregar al Histórico.');
					    	}
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->setMsgSolicitud('Error:' . $e->getMessage());
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar las solicitudes de la Bandeja de Incidencias.
	*
	* @return mixed
	*/
	public function consultaBandejaIncidencias()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,(SELECT nombre FROM bandejas WHERE id = s.ultima_bandeja) as ";
		        $sql .= "perfilAnterior,s.no_dn,s.segmento,(SELECT fecha_ingreso FROM incidencias WHERE ";
		        $sql .= "folio = s.folio ORDER BY id DESC LIMIT 1) AS fechaIngreso,(SELECT ticket FROM ";
		        $sql .= "incidencias WHERE folio = s.folio ORDER BY id DESC LIMIT 1) AS ticket,(SELECT ";
		        $sql .= "justificacion FROM incidencias WHERE folio = s.folio ORDER BY id DESC LIMIT 1) AS ";
				$sql .= "justificacion,(SELECT fecha_fvc FROM respuesta_reversion WHERE folio = s.folio) AS ";
				$sql .= "fecha_fvc,IF(s.fecha_reversion = '0000-00-00',s.fecha_reversion,(SELECT ";
				$sql .= "fecha_solicitud_reversa FROM cobranza WHERE folio = s.folio)) AS fecha_fvc_rever ";
				$sql .= "FROM solicitudes s WHERE s.num_bandeja = 5 AND s.estatus >= 1 AND s.estatus < 4 ";
				$sql .= "ORDER BY s.fecha_ingreso ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$perfilAnterior,$noDn,$segmento,$fechaIngreso,$ticket,$justificacion,
			    	$fechaFvc,$fechaReversion);
			    	while($stmt->fetch()){
			    		$item =array("id"             => $id,
			    					 "folioAbd"       => $folio,
			    					 "perfilAnterior" => $perfilAnterior,
			    					 "noDn"           => $noDn,
			    					 "segmento"       => $segmento,
			    					 "ticket"         => $ticket,
			    					 "justificacion"  => $justificacion,
			    					 "fechaIngreso"   => $fechaIngreso,
			    					 "fechaReversion" => $fechaReversion,
			    					 "fechaFvc"       => $fechaFvc);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error:' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para procesar la Bandeja de Incidencias.
	*
	* @return boolean
	*/
	public function procesaBandejaIncidencia($idUser)
	{
		try{
			if($_POST['acc'] == 'guardar'){
				if(!empty($_POST['folioAbd'])){
					$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
					if($this->db){
						$stmt = $this->db->stmt_init();
				    	$sql = "UPDATE solicitudes s,incidencias i SET s.estatus = ?,i.estatus = 2,";
				    	$sql .= "s.ultima_bandeja = IF(s.num_bandeja = 5,5,6),s.num_bandeja = ?,s.q_modi = ?,";
				    	$sql .= "i.q_modi = ? WHERE s.folio = i.folio AND s.folio = ?";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iiiii',$this->_estatus,$this->_bandeja,$idUser,$idUser,$folio)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN');
					    	}
			    			if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,($this->_bandeja == 5) 
			    			? 'Reversado': '',$idUser)){
			    				if($this->_bandeja == 6){
						    		if($this->guardaRegistroBandejaResRever($idUser)){
						    			$this->_msgSolicitud = 1;
							    		return true;
							    	}else{
							    		throw new Exception('Se guardó el registro, pero ocurrió un error al ' . 
							    		'agregar la Solicitud en la Bandeja Respuesta ABD Reversión.');
							    	}
							    }else{
							    	$this->_msgSolicitud = 1;
							    	return true;
							    }
					    	}else{
					    		throw new Exception('Se guardó el registro, pero ocurrió un error al agregar ' . 
					    		'en el Histórico.');
					    	}
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error al conectar a la Base de Datos.");
					}
				}else{
					throw new Exception("Error al procesar el ID del Registro.");
				}
			}else{
				throw new Exception("Error al realizar la acción.");
			}
		}catch (Exception $e){
			$this->_msgSolicitud = $e->getMessage();
			return false;
		}
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Incidencias.
	*
	* @return boolean
	*/
	public function guardaRegistroBandejaIncidencias($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO incidencias (folio,fecha_ingreso,ticket,justificacion,estatus,f_alta,";
						$sql .= "q_alta) VALUES (?,now(),?,?,1,now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iisi',$folio,$this->_ticket,$this->_justificacion,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	$this->setMsgSolicitud('Se guardó el registró.'); 
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar la Bandeja de Respuesta ABD Reversión.
	*
	* @return array
	*/
	public function consultaBandejaRespuestaRever()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,s.tipo_abd,s.no_dn,s.segmento,rr.fecha_ingreso FROM solicitudes s,";
		        $sql .= "respuesta_reversion rr WHERE s.num_bandeja = 6 AND s.estatus >= 1 AND s.estatus <= 3 ";
		        $sql .= "AND s.folio = rr.folio ORDER BY rr.fecha_ingreso ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$tipoAbd,$noDn,$segmento,$fechaIngreso);
			    	while($stmt->fetch()){
			    		$item =array("id"           => $id,
			    					 "folioAbd"     => $folio,
			    					 "tipoAbd"      => $tipoAbd,
			    					 "noDn"         => $noDn,
			    					 "segmento"     => $segmento,
			    					 "fechaIngreso" => $fechaIngreso);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para procesar la Bandeja de Respuesta ABD Reversión.
	*
	* @return boolean
	*/
	public function procesaBandejaRespuesta($idUser)
	{
		$justificacion = '';
		try{
			if($_POST['acc'] == 'guardar'){
				if(!empty($_POST['folioAbd'])){
					$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
					if($this->db){
						$stmt = $this->db->stmt_init();
				    	$sql = "UPDATE solicitudes s,respuesta_reversion rr SET s.ultima_bandeja = ?,";
				    	$sql .= "s.num_bandeja = ?,s.estatus = ?,rr.fecha_fvc = ?,rr.aceptado = ?,s.q_modi = ?,";
				    	$sql .= "rr.q_modi = ? WHERE s.folio = rr.folio AND s.folio = ?";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iiisiiii',$this->_ultimaBandeja,$this->_bandeja,$this->_estatus,
					    	$this->_fechaFvc,$this->_decisionRespRever,$idUser,$idUser,$folio)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN');
					    	}
					    	if($this->_decisionRespRever == 2){
					    		$justificacion = 'No Aceptado por ABD';
					    	}else{
					    		$justificacion = '';
					    	}
					    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,$justificacion,$idUser)){
					    		if($this->_decisionRespRever == 1){
						    		$this->guardaRegistroBandejaLineasActivas($idUser);					    		
						    	}
						    	$this->_msgSolicitud = 1;
						    	return true;
					    	}else{
					    		throw new Exception('Se guardó el registro, pero Falló al agregar' . 
					    		'en Histórico.');
					    	}
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error al conectar a la Base de Datos.");
					}
				}else{
					throw new Exception("Error al procesar el Registro.");
				}
			}else{
				throw new Exception("Error al realizar la acción.");
			}
		}catch (Exception $e){
			$this->_msgSolicitud = $e->getMessage();
			return false;
		}
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Respuesta ABD Reversión.
	*
	* @return boolean
	*/
	public function guardaRegistroBandejaResRever($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO respuesta_reversion (folio,fecha_ingreso,f_alta,q_alta) VALUES ";
						$sql .= "(?,now(),now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('ii',$folio,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	$this->setMsgSolicitud('Se guardó el registró.'); 
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->setMsgSolicitud($e->getMessage());
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar la Bandeja de Lineas Activas.
	*
	* @return mixed
	*/
	public function consultaBandejaLineasActivas()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id,s.folio,s.tipo_abd,s.no_dn,s.segmento,rr.fecha_fvc FROM solicitudes s,";
		        $sql .= "respuesta_reversion rr WHERE s.num_bandeja = 7 AND s.estatus >= 1 AND s.estatus <= 3 ";
		        $sql .= "AND s.folio = rr.folio ORDER BY rr.fecha_fvc ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$folio,$tipoAbd,$noDn,$segmento,$fechaFvc);
			    	while($stmt->fetch()){
			    		$item =array("id"       => $id,
			    					 "folioAbd" => $folio,
			    					 "tipoAbd"  => $tipoAbd,
			    					 "noDn"     => $noDn,
			    					 "segmento" => $segmento,
			    					 "fechaFvc" => $fechaFvc);
			    		array_push($datos,$item);
				    }
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		return $datos;
	}
	/**
	* Función para guardar el Registro del Folio en la Bandeja de Líneas Activas.
	*
	* @return boolean
	*/
	public function guardaRegistroBandejaLineasActivas($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
					    $stmt = $this->db->stmt_init();
						$sql = "INSERT INTO lineas_activas (folio,fecha_ingreso,estatus,f_alta,q_alta) VALUES ";
						$sql .= "(?,now(),1,now(),?)";
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('ii',$folio,$idUser)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	$this->setMsgSolicitud('Se guardó el registró.'); 
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para procesar la Bandeja de Líneas Activas.
	*
	* @return boolean
	*/
	public function procesaBandejaLineasActivas($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
						if($this->_campoValido){
							$stmt = $this->db->stmt_init();
							$sql = "UPDATE solicitudes s,lineas_activas la SET s.ultima_bandeja = ";
							$sql .= "IF(s.ultima_bandeja = 6,6,7),s.num_bandeja = ?,s.estatus = ?,la.linea_aaa = ?,";
							$sql .= "la.estatus = ?,s.q_modi = ?,la.q_modi = ?,s.justificacion = ? WHERE s.folio = ";
							$sql .= "la.folio AND s.folio = ?";
						    if($stmt->prepare($sql)){
						    	if($this->_decisionLineaActiva == 1){
						    		$justificacion = 'Reversión Completa';
						    	}else{
						    		$justificacion = $this->_justificacion;
						    	}
						    	if(!$stmt->bind_param('iiiiiisi',$this->_bandeja,$this->_estatus,
						    	$this->_decisionLineaActiva,$this->_estatusLineaActiva,$idUser,$idUser,$justificacion,
						    	$folio)){
						    		throw new Exception('FALLÓ BIND_PARAM');
						    	}
						    	if(!$stmt->execute()){
						    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
						    	}
						    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,$justificacion,$idUser)){
						    		if($this->_decisionLineaActiva == 2){
							    		$this->guardaRegistroBandejaIncidencias($idUser);
							    	}
							    	$this->_msgSolicitud = 1;
							    	return true;
						    	}else{
						    		throw new Exception('Se guardó el registro, pero Falló al agregar' . 
						    		'en Histórico.');
						    	}
						    }else{
								throw new Exception('FALLÓ PREPARACIÓN');
						    }
						    $stmt->close();
						}else{
							throw new Exception('CAMPO INVÁLIDO');
						}
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para procesar un Folio cuando se toma de la Bandeja de Exportaciones.
	*
	* @return boolean
	*/
	public function procesaFolio($idUser)
	{
		$folioRes = 0;
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
						if($this->_campoValido){
							$stmt = $this->db->stmt_init();
					        $sql = "SELECT COUNT(folio) AS folioRes FROM solicitudes WHERE folio = ? AND q_tomo <> 0";
						    if($stmt->prepare($sql)){
						    	if(!$stmt->bind_param('i',$folio)){
						    		throw new Exception('FALLÓ LA VINCULACIÓN DE PARÁMETROS.');
						    	}
						    	if(!$stmt->execute()){
						    		throw new Exception('FALLÓ EJECUCIÓN. Error: ' . $stmt->error);
						    	}
						    	$stmt->bind_result($folioRes);
						    	if($stmt->fetch()){
						    		if($folioRes > 0){
						    			throw new Exception('La solicitud NO se encuentra Disponible.');
						    		}else{
						    			$stmt->close();
						    			$stmt = $this->db->stmt_init();
										$sql = "UPDATE solicitudes SET fecha_pendiente = $this->_fechaPendiente,";
										$sql .= "q_tomo = ?,num_bandeja = ?,estatus_eval = ?,bloqueado = ?,";
										$sql .= "justificaciones = ?,f_tomo = $this->_fechaTomo, perfil = ? ";
										$sql .= "WHERE folio = ?";
									    if($stmt->prepare($sql)){
									    	if(!$stmt->bind_param('iiiisii',$idUser,$this->_bandeja,
									    	$this->_estatusEval,$this->_bloqueado,$this->_justificaciones,
									    	$this->_perfilSel,$folio)){
									    		throw new Exception('FALLÓ BIND_PARAM');
									    	}
									    	if(!$stmt->execute()){
									    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
									    	}
									    	$stmt->close();
									    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,
									    	$this->_justificaciones)){
									    		if($this->_estatusEval == 1 || $this->_estatusEval == 2){
										    		$this->guardaRegistroPendienteRespuesta($idUser);
										    	}
										    	$this->_msgSolicitud = 1;
										    	return true;
									    	}else{
									    		throw new Exception('Se guardó el registro, pero Falló al Agregar ' . 
									    		'al Histórico.' . $this->_msgSolicitud);
									    	}
									    }else{
											throw new Exception('FALLÓ PREPARACIÓN');
									    }
									    $stmt->close();
						    		}
						    	}else{
						    		throw new Exception('Error: al realizar la operación.' . $stmt->error);
						    	}
						    	$stmt->close();
						    }else{
								throw new Exception('FALLÓ PREPARACIÓN');
						    }
						}else{
							throw new Exception('CAMPO INVÁLIDO');
						}
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para procesar un Registro en el Histórico de Movimientos.
	*
	* @return boolean
	*/
	public function procesaHistorico($idUser,$folioAbd,$bandeja = NULL,$perfil = NULL,$justificacion = NULL,
	$idUsuario = NULL)
	{
		$folio = preg_replace('/[^0-9]/', '',$folioAbd);
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				if($perfil == 0 && $idUsuario == NULL){
					$sql = "INSERT INTO historico (folio,num_bandeja,perfil,justificacion,id_usuario,f_alta,q_alta) ";
					$sql .= "VALUES (?,IF(? > 0,?,(SELECT num_bandeja FROM solicitudes WHERE folio = ?)),";
					$sql .= "(SELECT perfil FROM solicitudes WHERE folio = ?),?,(SELECT q_tomo FROM solicitudes ";
					$sql .= "WHERE folio = ?),now(),?)";
					if($stmt->prepare($sql)){
				    	if(!$stmt->bind_param('iiiiisii',$folio,$bandeja,$bandeja,$folio,$folio,$justificacion,$folio,
				    	$idUser)){
				    		throw new Exception('FALLÓ BIND_PARAM');
				    	}
				    	if(!$stmt->execute()){
				    		throw new Exception('FALLÓ EJECUCIÓN.' . $stmt->error);
				    	}
				    	return true;
				    }else{
						throw new Exception('FALLÓ PREPARACIÓN');
				    }
				}else if($perfil != 0 && $idUsuario != 0){
					$sql = "INSERT INTO historico (folio,num_bandeja,perfil,justificacion,id_usuario,f_alta,q_alta) VALUES ";
					$sql .= "(?,?,?,?,?,now(),?)";
					if($stmt->prepare($sql)){
						if(!$stmt->bind_param('iiisii',$folio,$bandeja,$perfil,$justificacion,$idUsuario,$idUser)){
				    		throw new Exception('FALLÓ BIND_PARAM');
				    	}
				    	if(!$stmt->execute()){
				    		throw new Exception('FALLÓ EJECUCIÓN.' . $stmt->error);
				    	}
				    	return true;
				    }else{
						throw new Exception('FALLÓ PREPARACIÓN');
				    }
				}else if($perfil != 0 && $idUsuario == NULL){
					if($justificacion == NULL) $justificacion = '';
					$sql = "INSERT INTO historico (folio,num_bandeja,perfil,justificacion,id_usuario,f_alta,q_alta) ";
					$sql .= "VALUES (?,(SELECT num_bandeja FROM solicitudes WHERE folio = $folio),?,?,(SELECT q_tomo ";
					$sql .= "FROM solicitudes WHERE folio = $folio),now(),?)";
					if($stmt->prepare($sql)){
						if(!$stmt->bind_param('iisi',$folio,$perfil,$justificacion,$idUser)){
				    		throw new Exception('FALLÓ BIND_PARAM');
				    	}
				    	if(!$stmt->execute()){
				    		throw new Exception('FALLÓ EJECUCIÓN.' . $stmt->error);
				    	}
				    	return true;
				    }else{
						throw new Exception('FALLÓ PREPARACIÓN');
				    }
				    $stmt->close();
				}else if($perfil == 0 && $idUsuario != 0){
					if($justificacion == NULL) $justificacion = '';
					$sql = "INSERT INTO historico (folio,num_bandeja,perfil,justificacion,id_usuario,f_alta,q_alta) ";
					$sql .= "VALUES (?,(SELECT num_bandeja FROM solicitudes WHERE folio = $folio),(SELECT perfil FROM ";
					$sql .= "solicitudes WHERE folio = $folio),?,?,now(),?)";
					if($stmt->prepare($sql)){
						if(!$stmt->bind_param('isii',$folio,$justificacion,$idUser,$idUser)){
				    		throw new Exception('FALLÓ BIND_PARAM');
				    	}
				    	if(!$stmt->execute()){
				    		throw new Exception('FALLÓ EJECUCIÓN.' . $stmt->error);
				    	}
				    	return true;
				    }else{
						throw new Exception('FALLÓ PREPARACIÓN');
				    }
				    $stmt->close();
				}
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			$this->setMsgSolicitud($e->getMessage());
			return false;
		}
	}
	/**
	* Función para procesar una Solicitud de la Bandeja Pendiente Respuesta ABD.
	*
	* @return boolean
	*/
	public function procesaExport($idUser)
	{
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
						$stmt = $this->db->stmt_init();
						$sql = "UPDATE solicitudes s, pendiente_respuesta pr SET s.ultima_bandeja = 2,";
						$sql .= "s.num_bandeja = ?,s.estatus = ?,s.fecha_fvc = ?,s.q_tomo = ?,s.bloqueado = 1,";
						$sql .= "pr.se_exporta = ?,pr.fecha_fvc = ?,pr.estatus = ?,s.bloqueado = ? WHERE ";
						$sql .= "s.folio = pr.folio AND s.folio = ?";
					    if($stmt->prepare($sql)){
					    	$bloqueo = ($this->_decisionExport == 2) ? 0 : 1; 
					    	if(!$stmt->bind_param('iisiisiii',$this->_bandeja,$this->_estatus,$this->_fechaFvc,$idUser,
					    	$this->_decisionExport,$this->_fechaFvc,$this->_estatusPendResp,$bloqueo,$folio)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
					    	}
					    	if($this->_decisionExport == 2){
						    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja,NULL,'No se exporta')){
							    	$this->_msgSolicitud = 1;
							    	return true;
						    	}else{
						    		throw new Exception('Se guardó el registro, pero Falló al Agregar al Histórico.');
						    	}
						    }else{
						    	if($this->procesaHistorico($idUser,$folio,$this->_bandeja)){
						    		if($this->guardaRegistroCobranza($idUser)){
							    		$this->_msgSolicitud = 1;
							    	}else{
							    		$this->_msgSolicitud = $this->getMsgSolicitud();
							    	}
							    	return true;
						    	}else{
						    		throw new Exception('Se guardó el registro, pero Falló al Agregar al Histórico.');
						    	}
						    }
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para procesar un Folio para Reasignar.
	*
	* @return boolean
	*/
	public function procesaReasignacion($idUser)
	{
		$justificacion = '';
		if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['folioAbd'])){
				$folio = preg_replace('/[^0-9]/', '',$_POST['folioAbd']);
				try{
					if($this->db){
						$stmt = $this->db->stmt_init();
						if($this->_bandeja == 0){
							$sql = "UPDATE solicitudes s SET s.perfil = ?,s.q_modi = ?,s.q_tomo = 0 WHERE s.folio = ?";
							if($stmt->prepare($sql)){
						    	if(!$stmt->bind_param('iii',$this->_perfilSel,$idUser,$folio)){
						    		throw new Exception('FALLÓ BIND_PARAM');
						    	}
						    	if(!$stmt->execute()){
						    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
						    	}
						    	if($this->_perfilSel != 0){
						    		$perfilSel = $this->_perfilSel;
						    	}
						    	if($this->procesaHistorico($idUser,$folio,0,$perfilSel)){
						    		$this->_msgSolicitud = 1;
						    		return true;
						    	}else{
						    		throw new Exception($this->_msgSolicitud . 'Se guardó el registro, pero ' . 
						    		'Falló al agregar en Histórico.');
						    	}
						    }else{
								throw new Exception('FALLÓ PREPARACIÓN');
						    }
						    $stmt->close();
						}else if($this->_perfilSel == 0){
							$sql = "UPDATE solicitudes s SET s.num_bandeja = ?,s.ultima_bandeja = ?,s.q_modi = ?,";
							$sql .= "s.estatus = 1 WHERE s.folio = ?";
							if($stmt->prepare($sql)){
						    	if(!$stmt->bind_param('iiii',$this->_bandeja,$this->_ultimaBandeja,$idUser,$folio)){
						    		throw new Exception('FALLÓ BIND_PARAM');
						    	}
						    	if(!$stmt->execute()){
						    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
						    	}
						    }else{
								throw new Exception('FALLÓ PREPARACIÓN');
						    }
						    $stmt->close();
						    // Sí la solicitud se regresa a la Bandeja de Pendiente Respuesta ABD. *
						    if($this->_bandeja == 2){
						    	$justificacion = 'Reasignado a Pend. Resp. ABD';
						    	$stmt = $this->db->stmt_init();
						    	$sql = "DELETE FROM cobranza WHERE folio = ?";
								if($stmt->prepare($sql)){
							    	if(!$stmt->bind_param('i',$folio)){
							    		throw new Exception('FALLÓ BIND_PARAM');
							    	}
							    	if(!$stmt->execute()){
							    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
							    	}
							    }else{
									throw new Exception('FALLÓ PREPARACIÓN');
							    }
							    $stmt->close();
						    // Sí la solicitud se regresa a la Bandeja de Cobranza. *
						    }else if($this->_bandeja == 3){
						    	$justificacion = 'Reasignado a Cobranza';
						    	$stmt = $this->db->stmt_init();
						    	$sql = "DELETE FROM reversiones WHERE folio = ?";
								if($stmt->prepare($sql)){
							    	if(!$stmt->bind_param('i',$folio)){
							    		throw new Exception('FALLÓ BIND_PARAM');
							    	}
							    	if(!$stmt->execute()){
							    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
							    	}
							    }else{
									throw new Exception('FALLÓ PREPARACIÓN');
							    }
							    $stmt->close();
							// Sí la solicitud se regresa a la Bandeja Respuesta ABD Reversión. *
						    }else if($this->_bandeja == 6){
						    	$justificacion = 'Reasignado a Resp. ABD Rever.';
						    	$stmt = $this->db->stmt_init();
						    	$sql = "DELETE FROM lineas_activas WHERE folio = ?";
								if($stmt->prepare($sql)){
							    	if(!$stmt->bind_param('i',$folio)){
							    		throw new Exception('FALLÓ BIND_PARAM');
							    	}
							    	if(!$stmt->execute()){
							    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
							    	}
							    }else{
									throw new Exception('FALLÓ PREPARACIÓN');
							    }
							    $stmt->close();
						    }
						    if($this->procesaHistorico($idUser,$folio,$this->_bandeja,0,$justificacion)){
					    		$this->_msgSolicitud = 1;
					    		return true;
					    	}else{
					    		throw new Exception($this->_msgSolicitud . 'Se guardó el registro, pero ' . 
					    		'Falló al agregar en Histórico.');
					    	}
						}
					}else{
						throw new Exception("Error Database Request");
					}
				}catch (Exception $e){
					$this->_msgSolicitud = $e->getMessage();
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	* Función para consultar todos los registros para el llenado del Reporte General.
	*
	* @return boolean
	*/
	public function consultaReporteGral()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				$sql = "SELECT (SELECT usuario FROM usuarios WHERE id = s.q_tomo) AS plataforma,s.fecha_ingreso,";
				$sql .= "(SELECT nombre FROM usuarios WHERE id = s.q_tomo) AS ejecutivo,s.folio,s.tipo_abd,";
				$sql .= "(SELECT IF(se_exporta = 1,'Alta de Exportación Portada',IF(se_exporta = 2,";
				$sql .= "'Alta de Exportación Rechazada','NA')) AS estatus FROM pendiente_respuesta WHERE ";
				$sql .= "folio = s.folio) AS estadoPc,(SELECT fecha_fvc FROM pendiente_respuesta WHERE ";
				$sql .= "folio = s.folio) AS fechaFvcPr,(SELECT IF(pago = 1,'Sí Pago',IF(pago = 2,'No Pago','NA')) ";
				$sql .= "FROM cobranza WHERE folio = s.folio) AS pagoCliente,(SELECT fecha_solicitud_reversa FROM ";
				$sql .= "cobranza WHERE folio = s.folio) AS fechaSolRever,(SELECT IF(aceptado = 1,'Reversión de ";
				$sql .= "Exportación Aceptada',IF(aceptado = 2,'Reversión de Exportación Rechazada','NA')) FROM ";
				$sql .= "respuesta_reversion WHERE folio = s.folio) AS estatusRever,(SELECT justificacion FROM ";
				$sql .= "reversiones WHERE folio = s.folio) AS justificacion,(SELECT fecha_fvc FROM ";
				$sql .= "respuesta_reversion WHERE folio = s.folio) AS fechaFvcRever,(SELECT IF(estatus = 2,";
				$sql .= "'Reversión Completa',IF(estatus = 1,'En Proceso','NA')) FROM lineas_activas WHERE ";
				$sql .= "folio = s.folio) AS estatusLinea FROM solicitudes s ORDER BY ";
				$sql .= "s.fecha_ingreso DESC";
				if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN' . $stmt->error);
			    	}
			    	$stmt->bind_result($plataforma,$fechaIngreso,$nombreEjecutivo,$folioAbd,$tipoAbd,$estadoPc,
			    	$fechaFvcPr,$pagoCliente,$fechaSolRever,$estatusRever,$justificacion,$fechaFvcRever,$estatusLinea);
			    	while($stmt->fetch()){
			    		$item = array("plataforma"       => $plataforma,
			    					  "fechaIngreso"     => $fechaIngreso,
			    					  "ejecutivo"        => $nombreEjecutivo,
			    					  "folioAbd"         => $folioAbd,
			    					  "tipoAbd"          => $tipoAbd,
			    					  "estadoPc"         => $estadoPc,
			    					  "fechaFvcPr"       => $fechaFvcPr,
			    					  "pagoCliente"      => $pagoCliente,
			    					  "fechaSolRever"    => $fechaSolRever,
			    					  "estatusRever"     => $estatusRever,
			    					  "justificacion"    => $justificacion,
			    					  "fechaFvcRever"    => $fechaFvcRever,
			    					  "estatusLinea"     => $estatusLinea,
			    					  "fechaSolicitudTt" => '',
			    					  "numeroTt"         => '');
			    		array_push($datos,$item);
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN');
			    }
			    $stmt->close();
			}else{
				throw new Exception("Error Database Request");
			}
		}catch (Exception $e){
			$this->_msgSolicitud = $e->getMessage();
		}
		return $datos;
	}
}