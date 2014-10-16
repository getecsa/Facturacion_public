<?php
/**
* Acciones con el Usuario (acceso a la BD, validación, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Usuario extends DB_Connection
{
	private $errorMsg;
	private $headerMenu;
	private $_nombre;
	private $_usuario;
	private $_passUserEnc;
	private $_perfil;
	private $_estatus;
	private $_campoInvalido = false;
	private $_msgRequest;

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);
	}
	
	public function setHeaderSession($value)
	{
		$this->headerMenu = $value;
	}
	public function getHeaderSession()
	{
		return $this->headerMenu;
	}
	public function setErrorSessionMsg($value)
	{
		$this->errorMsg = $value;
	}
	public function getErrorSessionMsg()
	{
		return $this->errorMsg;
	}
	public function setNombre($value)
	{
		if($value == '' || $value == NULL){
			$campoInvalido = true;
		}else{
			$this->_nombre = $value;
		}
	}
	public function setUsuario($value)
	{
		if($value == '' || $value == NULL){
			$campoInvalido = true;
		}else{
			$this->_usuario = $value;
		}
	}
	public function setPerfil($value)
	{
		if($value == 0 || $value == NULL){
			$campoInvalido = true;
		}else{
			$this->_perfil = $value;
		}
	}
	public function setPasswordUser($value)
	{
		$this->_passUserEnc = $this->generateEncPass($value);
	}
	public function setEstatus($value)
	{
		$this->_estatus = $value;
	}
	public function getRequestMsg()
	{
		return $this->_msgRequest;
	}
	public function setRequestMsg($value)
	{
		$this->_msgRequest = $value;
	}
	/**
	* Función para consultar el estatus del Usuario.
	*
	* @return string
	*/
	public function consultaEstatus($estatus = NULL)
	{
		$datos =array();
		switch($estatus){
			case 0:
				$strEstatus = 'Inactivo';
				$datos =array('strEstatus' => $strEstatus,'estatusVal' => 0);
				break;
			case 1:
				$strEstatus = 'Activo';
				$datos =array('strEstatus' => $strEstatus,'estatusVal' => 1);
				break;
			default:
				$strEstatus = 'N/A';
				$datos =array('strEstatus' => $strEstatus,'estatusVal' => -1);
				break;
		}
		return $datos;
	}
	/**
	* Función para comprobar el accceso del Usuario al Sistema.
	*
	* @param string $userName cadena con el nombre de Usuario tecleado por el Usuario.
	* @param string $password cadena con la contraseña tecleada por el Usuario.
	* @return boolean
	*/
	public function checkLogin($userName,$password)
	{
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id,password,nombre,usuario,estatus,perfil FROM usuarios WHERE usuario = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param("s",$userName)){
			    		throw new Exception('0:FALLÓ BIND PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('0:FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($idUser,$passHash,$nombreUsuario,$usuario,$estatus,$perfil);
			    	if($stmt->fetch()){
			    		if(TRUE === $activeDirectoryInfoUser = $this->checkLdapLogin($userName,$password)){
					        if($estatus == 1){
						    	if(crypt($password,$passHash) == $passHash){
						    		session_start();
						    		$_SESSION['usuario'] = array('id'     => $idUser,
															     'nombre' => $nombreUsuario,
															     'perfil' => $perfil);
				        	        $this->setHeaderSession('menu.php');
				        	        $this->setErrorSessionMsg('1:Ingreso Exitoso!');
				        	        return true;
						    	}else{
						    		throw new Exception('0:Usuario o Contraseña Incorrectos');
						    	}
					        }else{
					    		throw new Exception('0:Usuario en estatus Inactivo');
					    	}
					    }else{
					    	throw new Exception('0:' . $this->getErrorSessionMsg());
					    }
				    }else{
			    		throw new Exception('0:Usuario o Contraseña Incorrectos');
			    	}
			    }else{
		    		throw new Exception("0:Error (0x130101) Falló la Preparación (" . $stmt->errno . ") " . 
			    	$stmt->error);
			    }
			    $stmt->close();
			}else{
	    		throw new Exception('0:' . $this->getMsgErrorConnection());
			}
		}catch (Exception $e){
			$this->setErrorSessionMsg($e->getMessage());
			return false;
		}
	}
	/**
	* Función para comprobar si el Usuario pertenece al AD(Active Directory) de Telefónica(TEM).
	*
	* @param string $user cadena con el nombre de Usuario a comprobar su acceso en el AD.
	* @param string $password cadena con la contraseña del Usuario a comprobar su acceso en el AD.
	* @return boolean
	*/
	public function checkLdapLogin($user,$password)
	{
		try{
			if(strcmp('admin',$user) == 0 || strcmp('ADMIN',$user) == 0){
				return true;
			}else{
				// Conexión al Servidor LDAP. *
			    //$ldap = ldap_connect(AD_TEM_SERVER);
			    //ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			    //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
			    //$this->setErrorSessionMsg(($ldap == TRUE) ? 'OK' : 'ERROR');
			    //
			    // Obtener el Nombre del Usuario junto con su dominio. *
			    //$valor=explode('.',AD_TEM_SERVER);
			    //$ldapRdn = $valor[0] . '\\' . $user;
			    //
			    // Se realiza la autenticación del Usuario en el Servidor LDAP. *
			    //$bindLdap = @ldap_bind($ldap,$ldapRdn,$password);
			    //
			    if(true){
			    	/*$dc = explode(".",AD_TEM_SERVER);
				    $base_dn = "";
				    foreach($dc as $_dc){
				    	$base_dn .= "dc=".$_dc.",";
				      	$base_dn = substr($base_dn, 0, -1);
				    }
			        $filter = "(sAMAccountName=$user)";
			        $result = ldap_search($ldap,$base_dn,$filter);
			        ldap_sort($ldap,$result,"sn");
			        $info = ldap_get_entries($ldap, $result);
			        for($i = 0; $i < $info["count"]; $i++){
			            if($info['count'] > 1){
			                break;
			        	}
			        }*/
		              /*
		                0 0 nombre completo
		                0 1 nombre
		                0 2 apellido
		                0 3 mail
		                0 4 puesto
		                0 5 area
		              */
		             /*$datos_usuario[0] =array($info[$i]["cn"][0],$info[$i]["name"][0],$info[$i]["sn"][0],$info[$i]["mail"][0],$info[$i]["title"][0],$info[$i]["department"][0]);
		            echo "<p>Nombre completo: ", $info[$i]["cn"][0], "</p>";
		            echo "<p>Nombre: ", $info[$i]["name"][0], "</p>";
		            echo "<p>Apellido: ", $info[$i]["sn"][0], "</p>";
		            echo "<p>Mail: ", $info[$i]["mail"][0], "</p>";
		            echo "<p>Puesto: ", $info[$i]["title"][0], "</p>";
		            echo "<p>Area: ", $info[$i]["department"][0], "</p>";
			        $datos = array();
					@ldap_close($ldap);*/
					return true;
			    }else{
			    	//$this->setErrorSessionMsg('Error al Autenticar el Usuario en el Servidor LDAP.');
			    	//throw new Exception($this->getErrorSessionMsg());
			    	throw new Exception('Error al Autenticar el Usuario en el Active Directory.');
			    }
			}
		}catch (Exception $e){
			$this->setErrorSessionMsg($e->getMessage());
			return false;
		}
	}
	/**
	* Función para comprobar que la Sesión este Vigente.
	*
	* @param string $userName cadena con el nombre de Usuario a verificar la vigencia de la sesión.
	* @return boolean
	*/
	public function checkSession($userName)
	{
		if(strlen(trim($userName)) > 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	* Función para comprobar si el Usuario esta Activo o Inactivo del Sistema.
	*
	* @param string $idUsuario valor del ID del Usuario a verificar su estatus.
	* @return boolean
	*/
	public function checkValidUser($idUsuario)
	{
		try{
		    if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT COUNT(id) as numUser FROM usuarios WHERE id = ? AND estatus = 1";
			    if(!$stmt->prepare($sql)){
			    	throw new Exception("Error: Falló Preparación (" . $stmt->errno . ") " . $stmt->error);
			    }
			    if(!$stmt->bind_param("i",$idUsuario)){
			    	throw new Exception("Error: Falló bind param (" . $stmt->errno . ") " . $stmt->error);
			    }
			    if(!$stmt->execute()){
			    	throw new Exception("Error: Falló ejecución (" . $stmt->errno . ") " . $stmt->error);
			    }
			    $stmt->bind_result($numUser);
			    $stmt->fetch();
			    $stmt->close();
		    	if($numUser == 1){
		    		return true;
		    	}else{
		    		throw new Exception('Usuario en estatus Inactivo.');
		    	}
			}else{
				throw new Exception($connection->getMsgErrorConnection());
			}
		}catch (Exception $e){
			$this->setErrorSessionMsg($e->getMessage());
			return false;
		}
	}
	/**
	* Función para comprobar el permiso de accceso del Usuario al Sistema.
	*
	* @return boolean
	*/
	public function checkAccessUser()
	{
		switch($_SESSION['usuario']['perfil']){
			case 1:
			case 2:
			case 3:
			case 4:
				return true;
				break;
			default:
				return false;
				break;
		}
	}
	/**
	* Función para consultar los Usuarios Registrados.
	*
	* @return array
	*/
	public function consultarUsuarios()
	{
	    $datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id_usuario,username,nombre,n_paterno,n_materno,
		        		 (SELECT tx_area FROM area WHERE id_area = area_idarea) AS nombreArea,suspendido
		        		  FROM users
		        	  ORDER BY nombre ASC";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$userName,$nombre,$apPaterno,$apMaterno,$nombreArea,$estatus);
			    	while($stmt->fetch()){
			    		$item =array("id"      => $id,
			    					 "nombre"  => $nombre . ' ' . $apPaterno . ' ' . $apMaterno,
			    					 "usuario" => $userName,
			    					 "area"    => $nombreArea,
			    					 "estatus" => $estatus);
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
	* Función para consultar un Usuario por ID.
	*
	* @param integer $idUsuario valor del ID del usuario a consultar.
	* @return array
	*/
	public function consultaUsuario($idUsuario)
	{
	    $datos =array();
		try{
			if($this->db){
				$stmt = $this->db->stmt_init();
		        $sql = "SELECT id,nombre,usuario,perfil,estatus FROM usuarios WHERE id = ?";
			    if($stmt->prepare($sql)){
			    	if(!$stmt->bind_param('i',$idUsuario)){
			    		throw new Exception('FALLÓ BIND_PARAM');
			    	}
			    	if(!$stmt->execute()){
			    		throw new Exception('FALLÓ EJECUCIÓN');
			    	}
			    	$stmt->bind_result($id,$nombre,$usuario,$perfil,$estatus);
			    	if($stmt->fetch()){
			    		$datos =array("id"      => $id,
			    					  "nombre"  => $nombre,
			    					  "usuario" => $usuario,
			    					  "perfil"  => $perfil,
			    					  "estatus" => $estatus);
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
	* Función para procesar un Usuario.
	*
	* @param integer $idUserSess valor del ID del usuario que realiza la operación.
	* @return boolean
	*/
	public function procesaUsuario($idUserSess)
	{
	    if($_POST['acc'] == 'guardar'){
			if(empty($_POST['idUs'])){
		        $sql = "INSERT INTO usuarios (nombre,usuario,password,perfil,estatus,f_alta,q_modi) ";
		        $sql .= " VALUES (upper(?),upper(?),?,?,1,now(),?)";
			    try{
			    	if(!$this->_campoInvalido){
						if($this->db){
							$stmt = $this->db->stmt_init();
						    if($stmt->prepare($sql)){
						    	if(!$stmt->bind_param('sssii',$this->_nombre,$this->_usuario,$this->_passUserEnc,
						    	$this->_perfil,$idUserSess)){
						    		throw new Exception('FALLÓ BIND_PARAM');
						    	}
						    	if(!$stmt->execute()){
						    		throw new Exception('FALLÓ EJECUCIÓN: ' . $stmt->error);
						    	}
						    	$this->setRequestMsg(1);
						    	return true;
						    }else{
								throw new Exception('FALLÓ PREPARACIÓN');
						    }
						    $stmt->close();
						}else{
							throw new Exception("Error Database Connection");
						}
					}else{
						throw new Exception("Campo Inválido");
					}
				}catch (Exception $e){
					$this->setRequestMsg('Error: ' . $e->getMessage());
					return false;
				}
			}else{
				$id = preg_replace('/[^0-9]/', '',$_POST['idUs']);
				if(trim(strlen($_POST['passVol'])) == 0){
					$sql = "UPDATE usuarios SET nombre = upper(?),perfil = ?,q_modi = ? WHERE id = ?";
					try{
				    	if(!$this->_campoInvalido){
							if($this->db){
								$stmt = $this->db->stmt_init();
							    if($stmt->prepare($sql)){
							    	if(!$stmt->bind_param('siii',$this->_nombre,$this->_perfil,$idUserSess,$id)){
							    		throw new Exception('FALLÓ BIND_PARAM');
							    	}
							    	if(!$stmt->execute()){
							    		throw new Exception('FALLÓ EJECUCIÓN');
							    	}
							    	$this->setRequestMsg(1);
							    	return true;
							    }else{
									throw new Exception('FALLÓ PREPARACIÓN');
							    }
							    $stmt->close();
							}else{
								throw new Exception("Error Database Connection");
							}
						}else{
							throw new Exception("Campo Inválido");
						}
					}catch (Exception $e){
						$this->setRequestMsg('Error: ' . $e->getMessage());
						return false;
					}
				}else{
					$sql = "UPDATE usuarios SET nombre = upper(?),password = ?,perfil = ?,q_modi = ? WHERE ";
					$sql .= "id = ?";
					try{
				    	if(!$this->_campoInvalido){
							if($this->db){
								$stmt = $this->db->stmt_init();
							    if($stmt->prepare($sql)){
							    	if(!$stmt->bind_param('ssiii',$this->_nombre,$this->_passUserEnc,$this->_perfil,
							    	$idUserSess,$id)){
							    		throw new Exception('FALLÓ BIND_PARAM');
							    	}
							    	if(!$stmt->execute()){
							    		throw new Exception('FALLÓ EJECUCIÓN');
							    	}
							    	$this->setRequestMsg(1);
							    	return true;
							    }else{
									throw new Exception('FALLÓ PREPARACIÓN');
							    }
							    $stmt->close();
							}else{
								throw new Exception("Error Database Connection");
							}
						}else{
							throw new Exception("Campo Inválido");
						}
					}catch (Exception $e){
						$this->setRequestMsg('Error: ' . $e->getMessage());
						return false;
					}
				}
			}
		}else{
			$this->setRequestMsg('Error al realizar la acción.');
			return false;
		}
	}
	/**
	* Función para realizar el cambio de Estatus de un Usuario.
	*
	* @param integer $idUserSess valor del ID del usuario a realizar la operación.	
	* @return boolean
	*/
	public function cambioEstatusUsuario($idUserSess)
	{
	    if($_POST['acc'] == 'guardar'){
			if(!empty($_POST['idUs'])){
				$id = preg_replace('/[^0-9]/', '',$_POST['idUs']);
		        $sql = "UPDATE usuarios SET estatus = ?,q_modi = ? WHERE id = ?";
			    try{
					if($this->db){
						$stmt = $this->db->stmt_init();
					    if($stmt->prepare($sql)){
					    	if(!$stmt->bind_param('iii',$this->_estatus,$idUserSess,$id)){
					    		throw new Exception('FALLÓ BIND_PARAM');
					    	}
					    	if(!$stmt->execute()){
					    		throw new Exception('FALLÓ EJECUCIÓN: ' . $stmt->error);
					    	}
					    	if($this->_estatus == 0){
					    		$this->setRequestMsg('Se inactiva correctamente al Usuario.');
					    	}else if($this->_estatus == 1){
					    		$this->setRequestMsg('Se reactiva correctamente al Usuario.');
					    	}
					    	return true;
					    }else{
							throw new Exception('FALLÓ PREPARACIÓN');
					    }
					    $stmt->close();
					}else{
						throw new Exception("Error Database Connection");
					}
				}catch (Exception $e){
					$this->setRequestMsg('Error: ' . $e->getMessage());
					return false;
				}
			}else{
				$this->setRequestMsg('Error: ID del Registro Incorrecto.');
				return false;
			}
		}else{
			$this->setRequestMsg('Error al realizar la acción.');
			return false;
		}
	}
	/**
	* Función para obtener el Hash de la contraseña.
	*
	* @param string $password contraseña del Usuario.
	* @return string
	*/
	public function generateEncPass($password,$digito = 9)
	{  
		$setSalt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';  
		$salt    = sprintf('$2a$%02d$',$digito);  
		for($i = 0; $i < 22; $i++){
			$salt .= $setSalt[mt_rand(0,63)];  
		}  
		return crypt($password,$salt);  
	}
}