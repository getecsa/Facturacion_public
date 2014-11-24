<?php
/**
* Acciones con las Áreas (consultas, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Area extends DB_Connection
{
	private $_nombreArea;
	private $_tipoArea;
	private $_estatusArea;
	private $_msgSolicitud;
	private $_camposValidos = true;

	public function __construct($dbo = NULL,$dbOracle = NULL){
		parent::__construct($dbo,$dbOracle);
	}
	
	public function setNombreArea($value){
		if($value == '' || $value == NULL){
			$this->_camposValidos = false;
		}else{
			$this->_nombreArea = utf8_decode($value);
		}
	}
	public function setTipoArea($value){
		if($value == -1 || $value == NULL){
			$this->_camposValidos = false;
		}else{
			$this->_tipoArea = $value;
		}
	}
	public function setEstatus($value){
		$this->_estatusArea = $value;
	}
	public function getMsgSolicitud(){
		return $this->_msgSolicitud;
	}
	public function setMsgSolicitud($value){
		$this->_msgSolicitud = $value;
	}
	/**
	* Función para consultar los Tipos de Áreas.
	* 
	* @return array
	*/
	public function consultarTiposAreas()
	{
		$datos =array(array('idTipoArea' => 0,'nombreTipoArea' => 'Operador'),array('idTipoArea' => 1,'nombreTipoArea' => 'Solicitante'),
		array('idTipoArea' => 3,'nombreTipoArea' => 'Administrador'),array('idTipoArea' => 4,'nombreTipoArea' => 'Supervisor'));
		return $datos;
	}
	/**
	* Función para consultar las Áreas.
	* 
	* @return array
	*/
	public function consultarAreas($strWhere = NULL)
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_area,tx_area,IF(oper_sol = 0,'Operador',IF(oper_sol = 1,'Solicitante',IF(oper_sol = 3,'Administrador',
		        	           IF(oper_sol = 4,'Supervisor','N/A')))) AS tipoArea,suspendido 
			 			  FROM area 
			 			  $strWhere
			 		  ORDER BY tx_area ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($idArea,$nombreArea,$tipoArea,$estatus);
			    	while($stmt->fetch()){
			    		$item =array("idArea"     => $idArea,
			    					 "nombreArea" => $nombreArea,
			    					 "tipoArea"   => $tipoArea,
			    					 "estatus"    => $estatus);
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
	* Función para consultar una Área por ID.
	* 
	* @return array
	*/
	public function consultaArea($idArea)
	{
		$dato =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_area,tx_area,oper_sol,suspendido 
			 			  FROM area 
			 		  	 WHERE id_area = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$idArea)){
			    		throw new Exception('FALLÓ VINCULACIÓN DE PARÁMETROS ' . __METHOD__);
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN ' . __METHOD__);
			    	}
			    	$stmt->bind_result($idArea,$nombreArea,$tipoArea,$estatus);
			    	if($stmt->fetch()){
			    		$dato =array("idArea"     => $idArea,
			    					 "nombreArea" => $nombreArea,
			    					 "idTipoArea" => $tipoArea,
			    					 "estatus"    => $estatus);
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN ' . __METHOD__);
			    }
			    $stmt->close();
			}else{
				throw new Exception('Error Database Request ' . __METHOD__);
			}
		}catch (Exception $e){
			return $e->getMessage();
		}
		return $dato;
	}
	/**
	* Función para procesar una Área.
	* 
	* @return boolean
	*/
	public function procesaArea()
	{
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				if(empty($_POST['idArea'])){
					if($this->_camposValidos){
						$sql = "INSERT INTO area (tx_area,oper_sol,suspendido) 
								     VALUES (upper(?),?,1)";
					    if(!$stmt->prepare($sql)){
					    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->bind_param('si',$this->_nombreArea,$this->_tipoArea)){
					    	throw new Exception("Falló bind_param (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->execute()){
					    	throw new Exception("Falló execute (" . $stmt->errno . ") " . $stmt->error);
					    }
					    $stmt->close();
					    $this->setMsgSolicitud(1);
					    return true;
					}else{
						throw new Exception('Campos Inválidos ' . __METHOD__);
					}
				}else{
					$idArea = preg_replace('/[^0-9]/', '',$_POST['idArea']);
					if($this->_camposValidos){
						$sql = "UPDATE area 
							 	   SET tx_area = upper(?),oper_sol = ? 
							 	 WHERE id_area = ?";
						if(!$stmt->prepare($sql)){
					    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->bind_param('sii',$this->_nombreArea,$this->_tipoArea,$idArea)){
					    	throw new Exception("Falló bind_param (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->execute()){
					    	throw new Exception("Falló execute (" . $stmt->errno . ") " . $stmt->error);
					    }
					    $stmt->close();
					    $this->setMsgSolicitud(1);
					    return true;
					}else{
						throw new Exception('Campos Inválidos ' . __METHOD__);
					}
				}
			}else{
				throw new Exception('Database Request ' . __METHOD__);
			}
		}catch (Exception $e){
			$this->setMsgSolicitud('Error-> ' . $e->getMessage());
			return false;
		}
	}
	/**
	* Función para realizar el cambio de estatus de una Área.
	* 
	* @return boolean
	*/
	public function cambioEstatusArea()
	{
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				if(!empty($_POST['idArea'])){
					$idArea = preg_replace('/[^0-9]/', '',$_POST['idArea']);
					$sql = "UPDATE area 
						 	   SET suspendido = ? 
						 	 WHERE id_area = ?";
					if(!$stmt->prepare($sql)){
				    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
				    }
				    if(!$stmt->bind_param('ii',$this->_estatusArea,$idArea)){
				    	throw new Exception("Falló bind_param (" . $stmt->errno . ") " . $stmt->error);
				    }
				    if(!$stmt->execute()){
				    	throw new Exception("Falló execute (" . $stmt->errno . ") " . $stmt->error);
				    }
				    $stmt->close();
				    $this->setMsgSolicitud(1);
				    return true;
				}else{
					throw new Exception('Registro Inválido ' . __METHOD__);
				}
			}else{
				throw new Exception('Database Request ' . __METHOD__);
			}
		}catch (Exception $e){
			$this->setMsgSolicitud('Error-> ' . $e->getMessage());
			return false;
		}
	}
}