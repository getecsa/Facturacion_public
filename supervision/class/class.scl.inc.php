<?php
/**
* Acciones con el Objeto Scl (accesos,consultas)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Scl extends DB_Connection
{
	private $_perfil;
	private $_msgSolicitud;
	private $_campoValido = true;

	public function __construct($dbOracle = NULL){
		parent::__construct($dbo,$dbOracle);
	}
	
	public function getMsgSolicitud(){
		return $this->_msgSolicitud;
	}
	public function setMsgSolicitud($value){
		$this->_msgSolicitud = $value;
	}
	/**
	* Función para consultar la Información de un Cliente dependiendo del Folio ABD.
	*
	* @return array
	*/
	public function consultaInformacionClienteScl($folioAbd,$codigoCliente)
	{
		$datos =array();
		try{
			if($this->dbOracle){
		        $sql = "SELECT COD_SITUACION,cod_plantarif,fec_alta,cod_cliente,num_celular,fec_acepventa,fec_fincontra 
		        		FROM ga_abocel 
		        		WHERE cod_cliente = :cc 
		        		UNION 
		        		SELECT COD_SITUACION,cod_plantarif,fec_alta,cod_cliente,num_celular,fec_acepventa,fec_fincontra 
		        		FROM ga_aboamist 
		        		WHERE cod_cliente = :cc";
			    $stmt = oci_parse($this->dbOracle,$sql);
			    		oci_bind_by_name($stmt,":cc",$codigoCliente);
			    		oci_execute($stmt);
		    	$row = oci_fetch_assoc($stmt);
	    		$datos =array("fechaInicioContrato" => $row['fec_acepventa'],
	    					  "fechaFinContrato"    => $row['fec_fincontra'],
	    					  "clavePlanComercial"  => $row['cod_plantarif'],
	    					  "fechaAlta"           => $row['fec_alta'],
	    					  "codigoCliente"       => $row['cod_cliente'],
	    					  "noDn"                => $row['num_celular'],
	    					  "estadoScl"           => $row['COD_SITUACION'],
	    					  "nombreCliente"       => '',
	    					  "fechaEmisionFactura" => '',
	    					  "fechaCorte"          => '',
	    					  "estadoLinea"         => '',
	    					  "segmento"            => '',
	    					  "tipoAbd"             => '');
			    oci_close($this->dbOracle);
			}else{
				throw new Exception("Requesting data from database");
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		return $datos;
	}
}