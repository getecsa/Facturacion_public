<?php
/**
* Acciones con las Monedas (accesos, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Moneda extends DB_Connection
{
	private $_perfil;
	private $_perfilSel;
	private $_bandeja;
	private $_msgSolicitud;
	private $_campoValido = true;

	public function __construct($dbo = NULL,$dbOracle = NULL){
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
	public function getMsgSolicitud(){
		return $this->_msgSolicitud;
	}
	public function setMsgSolicitud($value){
		$this->_msgSolicitud = $value;
	}
	
	/**
	* Función para consultar las Áreas.
	* 
	* @return array
	*/
	public function consultarMonedas()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_moneda,moneda,suspendido 
			 			  FROM moneda 
			 		  ORDER BY moneda ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($idMoneda,$moneda,$estatus);
			    	while($stmt->fetch()){
			    		$item =array("idMoneda" => $idMoneda,
			    					 "moneda"   => $moneda,
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
}