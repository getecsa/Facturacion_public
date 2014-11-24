<?php
/**
* Acciones con los Reportes (consultas)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Reporte extends DB_Connection
{
	private $_nombreArea;
	private $_tipoArea;
	private $_estatusArea;
	private $_msgSolicitud;
	private $_camposValidos = true;

	public function __construct($dbo = NULL,$dbOracle = NULL){
		parent::__construct($dbo,$dbOracle);
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
	* Función para realizar la consulta en base a los criterios del Formulario de Reportes.
	* 
	* @return array
	*/
	public function consultarReporte()
	{
		$datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT s.id_solicitudes,(SELECT tx_area FROM area WHERE id_area = s.area_idarea) AS nombreArea,COUNT(id_solicitudes) AS numSolicitudes 
			 			  FROM solicitudes s 
			 			 WHERE s.area_idarea = ? 
			 		  ORDER BY fecha_solicitud ASC";
			    if($stmt->prepare($sql)){
			    	$fechaInicio = $_POST['fechaInicio'] . ' 00:00:00';
			    	$fechaFin    = $_POST['fechaFin'] . '23:59:59';
			    	if(!$stmt->bind_param('i',$_POST['areasSel'])){
			    		throw new Exception('FALLÓ VINCULACIÓN DE PARÁMETROS ' . __METHOD__);
			    	}
			    	/*if(!$stmt->bind_param('iss',$_POST['areasSel'],$fechaInicio,$fechaFin)){
			    		throw new Exception('FALLÓ VINCULACIÓN DE PARÁMETROS ' . __METHOD__);
			    	}*/    	
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN ' . __METHOD__);
			    	}
			    	$stmt->bind_result($idSolicitud,$nombreArea,$numSolicitudes);
			    	while($stmt->fetch()){
			    		$item =array("idSolicitud" => $idSolicitud,
			    					 "nombreArea"  => $nombreArea,
			    					 "numSolicitudes" => $numSolicitudes,
			    					 "estatus"     => '');
			    		array_push($datos,$item);
			    	}
			    }else{
					throw new Exception('FALLÓ PREPARACIÓN' . __METHOD__);
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