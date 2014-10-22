<?php
/**
* Acciones con las Tasas de IVA (consutlas,validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Iva extends DB_Connection
{
	private $_nombreTasa;
	private $_valorTasa;
	private $_estatusTasa;
	private $_msgSolicitud;
	private $_camposValidos = true;

	public function __construct($dbo = NULL,$dbOracle = NULL){
		parent::__construct($dbo,$dbOracle);
	}
	
	public function setNombreTasa($value){
		if($value == '' || $value == NULL){
			$this->_camposValidos = false;
		}else{
			$this->_nombreTasa = utf8_decode($value);
		}
	}
	public function setValorTasa($value){
		if($value == '' || $value == NULL){
			$this->_camposValidos = false;
		}else{
			$this->_valorTasa = $value;
		}
	}
	public function setEstatus($value){
		$this->_estatusTasa = $value;
	}
	public function getMsgSolicitud(){
		return $this->_msgSolicitud;
	}
	public function setMsgSolicitud($value){
		$this->_msgSolicitud = $value;
	}
	/**
	* Función para consultar las distintas tasas de IVA.
	* 
	* @return array
	*/
	public function consultarIva()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_iva,valor_tx,valor_int,suspendido 
			 			  FROM iva 
			 		  ORDER BY id_iva ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($idIva,$tipoIva,$valorIva,$estatus);
			    	while($stmt->fetch()){
			    		$item =array("idIva"    => $idIva,
			    					 "tipoIva"  => $tipoIva,
			    					 "valorIva" => $valorIva,
			    					 "estatus"  => $estatus);
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
	* Función para consultar una Tasa por ID.
	* 
	* @return array
	*/
	public function consultaTasaIva($idIva)
	{
		$dato =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_iva,valor_tx,valor_int,suspendido 
			 			  FROM iva 
			 		  	 WHERE id_iva = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$idIva)){
			    		throw new Exception('FALLÓ VINCULACIÓN DE PARÁMETROS ' . __METHOD__);
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN ' . __METHOD__);
			    	}
			    	$stmt->bind_result($idIva,$nombreTasa,$valorTasa,$estatus);
			    	if($stmt->fetch()){
			    		$dato =array("idIva"      => $idIva,
			    					 "nombreTasa" => $nombreTasa,
			    					 "valorTasa"  => $valorTasa,
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
	* Función para procesar una Tasa.
	* 
	* @return boolean
	*/
	public function procesaTasa()
	{
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				if(empty($_POST['idIva'])){
					if($this->_camposValidos){
						$sql = "INSERT INTO iva (valor_tx,valor_int,suspendido) 
								     VALUES (upper(?),?,1)";
					    if(!$stmt->prepare($sql)){
					    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->bind_param('sd',$this->_nombreTasa,$this->_valorTasa)){
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
					$idIva = preg_replace('/[^0-9]/', '',$_POST['idIva']);
					if($this->_camposValidos){
						$sql = "UPDATE iva 
							 	   SET valor_tx = upper(?),valor_int = ? 
							 	 WHERE id_iva = ?";
						if(!$stmt->prepare($sql)){
					    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
					    }
					    if(!$stmt->bind_param('sdi',$this->_nombreTasa,$this->_valorTasa,$idIva)){
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
	* Función para realizar el cambio de estatus de una Tasa.
	* 
	* @return boolean
	*/
	public function cambioEstatusTasa()
	{
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
				if(!empty($_POST['idIva'])){
					$idIva = preg_replace('/[^0-9]/', '',$_POST['idIva']);
					$sql = "UPDATE iva 
						 	   SET suspendido = ? 
						 	 WHERE id_iva = ?";
					if(!$stmt->prepare($sql)){
				    	throw new Exception("Falló prepare (" . $stmt->errno . ") " . $stmt->error);
				    }
				    if(!$stmt->bind_param('ii',$this->_estatusTasa,$idIva)){
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