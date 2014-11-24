<?php
/**
* Acciones en la Base de Datos (acceso a la DB, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class DB_Connection
{
	private $_msgErrorConnect;
	private $_msgError;
	protected $dbOracle;
	protected $db;
	
	protected function __construct($dbo = NULL,$dbOracle = NULL)
	{
		if(is_object($dbo)){
			$this->db = $dbo;
		}else{
			try{
				$this->db = new mysqli(DB_HOST,DB_USER,DB_PASS);
				if($this->db->connect_errno){
					try{
		    			throw new Exception("ERROR-> Connection to database failed (" . 
						$this->db->connect_error . ")");
		    		}catch (Exception $e){
		    			$this->setMsgErrorConnection($e->getMessage());
		    		}
				}else{
					if(!$this->db->select_db(DB_NAME)){
						try{
			    			throw new Exception("ERROR-> Selecting database (" . 
							$this->db->error . ")");
			    		}catch (Exception $e){
			    			$this->setMsgErrorConnection($e->getMessage());
			    		}
					}
				}
			}catch (Exception $e){
				$this->_msgError = "ERROR-> Connection to database MySQL failed (" . $e->getMessage() . ")";
				$this->setMsgErrorConnection($this->_msgError);
			}
		}
		// Conexión a la Base de Datos de SCL en Oracle. *
		if(is_object($dbOracle)){
			$this->dbOracle = $dbOracle;
		}else{
			/*try{
				$dbOra = oci_connect(USERNAME_SCL,PASSWORD_SCL,DB_SCELPROYIXTL);
				if(!$dbOra){
				    $e = oci_error();
    				$this->_msgError = $this->_msgError . "<br>ERROR-> Connection to database Oracle failed (" . 
    				htmlentities($e['message']) . ")";
    				$this->setMsgErrorConnection($this->_msgError);
				}
			}catch (Exception $e){
				$this->_msgError = $this->_msgError . "<br>ERROR-> Connection to database Oracle failed (" . 
				$e->getMessage() . ")";
				$this->setMsgErrorConnection($this->_msgError);

			}*/
		}
		//
	}
	/**
	* Función para colocar el mensaje de Error en la conexión.
	*
	* @param $valor 
	*/	
	public function setMsgErrorConnection($valor)
	{
		$this->_msgErrorConnect = $valor;
	}
	/**
	* Función para devolver el mensaje de Error en la conexión.
	*	
	* @return string
	*/	
	public function getMsgErrorConnection()
	{
		return $this->_msgErrorConnect;
	}
}