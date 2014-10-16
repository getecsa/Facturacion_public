<?php
/**
* Acciones con el Envío de Notificaciones por Correo Electrónico (Envíos, Consultas SCL, etc.)
*
* PHP version 5
*
* @author Alfredo Rodríguez
* @version 1.0 Oct-14
*/
class Correo extends DB_Connection
{
	private $_msgAction;
	private $_direccionDestino;
	private $_campoValido = true;

	public function __construct($dbo = NULL,$dbOracle = NULL){
		parent::__construct($dbo,$dbOracle);
	}
	
	public function setMsgAction($value)
	{
		$this->_msgAction = $value;
	}
	public function getMsgAction()
	{
		return $this->_msgAction;
	}
	/**
	* Función para procesar el envío de una notificación por Correo Electrónico. 
	*
	* @param mixed $folioAbd Este valor puede ser un Folio o un arreglo de Folios.
	* @param integer $bandeja Valor con el número de la Bandeja que se encuentra actualmente.
	* @param integer $decision Valor con el número de decision que se tomo en el formulario.
	* @param integer $segmento Valor con el número de segmento o perfil al que pertenece.
	* @return void
	*/
	public function procesaEnvioCorreo($folioAbd = NULL,$bandeja = NULL,$decision = NULL,$segmento = NULL)
	{
		$asuntoMail = '';
		$cc         = '';
		require '../template/class.TemplatePower.inc.php';
		require '../phpMailer/class.phpmailer.php';
		$mail = new PHPMailer();
	    switch($bandeja){
	    	// Se va de la Bandeja de Exportaciones.
	    	case 1:
	    		// Evaluación Aceptada. *
	    		if($decision == 1){
	    			$tpl = new TemplatePower('../template/correo/evaluacionAceptada.inc');
	    			$tpl->prepare();
	    			$infoScl = $this->consultaInfoClienteScl($cc);
	    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
	    			$controlLineas = ($infoScl['numeroLineas'] == 1) ? 'línea' : 'líneas';
	    			$tpl->assign('numeroLineas',$infoScl['numeroLineas']);
	    			$tpl->assign('controlLineas',$controlLineas);
	    			$tpl->assign('folioAbd',$folioAbd);
	    			$tpl->assign('cc',$infoScl['codigoCliente']);
	    			$tpl->assign('dn',$infoScl['noDn']);
	    			$asuntoMail = 'EXPORTACIÓN ' . $infoScl['nombreCliente'];
				//Evaluación Rechazada. *
				}else if($decision == 2){
					$tpl = new TemplatePower('../template/correo/evaluacionRechazada.inc');
	    			$tpl->prepare();
	    			// Información de SCL. *
	    			$infoScl = $this->consultaInfoClienteScl($cc);
	    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
	    			$controlLineas = ($infoScl['numeroLineas'] == 1) ? 'línea' : 'líneas';
	    			$tpl->assign('numeroLineas',$infoScl['numeroLineas']);
	    			$tpl->assign('controlLineas',$controlLineas);
	    			$tpl->assign('folioAbd',$folioAbd);
	    			$tpl->assign('cc',$infoScl['codigoCliente']);
	    			$tpl->assign('dn',$infoScl['noDn']);
	    			$asuntoMail = 'EXPORTACIÓN ' . $infoScl['nombreCliente'];
	    			//
	    			// Información del GER. *
	    			$useArray = array('object'    => 'Bandeja',
									  'method'    => 'consultaSolicitudesFolio',
									  'methodTwo' => 'consultaJustificacionesPorId');
					$obj = new $useArray['object'];
					$solicitud = $obj->$useArray['method']($folioAbd);
					if(!empty($solicitud['justificaciones'])){
						$justificacion = '';
						foreach($solicitud['justificaciones'] as $item){
							if(is_numeric($item)){
								$justificacion = $justificacion . '* ' . $obj->$useArray['methodTwo']($item) . 
								'. <br>';
							}
						}
						$tpl->assign('justificaciones',$justificacion);
					}else{
						$tpl->assign('justificaciones','NO SE SELECCIONÓ NINGUNA JUSTIFICACIÓN.');
					}
	    			//
				//Evaluación Pendiente. *
				}else if($decision == 3){
		    		$tpl = new TemplatePower('../template/correo/evaluacionPendiente.inc');
	    			$tpl->prepare();
	    			// Información de SCL. *
	    			$infoScl = $this->consultaInfoClienteScl($cc);
	    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
	    			$controlLineas = ($infoScl['numeroLineas'] == 1) ? 'línea' : 'líneas';
	    			$tpl->assign('numeroLineas',$infoScl['numeroLineas']);
	    			$tpl->assign('controlLineas',$controlLineas);
	    			$tpl->assign('folioAbd',$folioAbd);
	    			$tpl->assign('cc',$infoScl['codigoCliente']);
	    			$tpl->assign('dn',$infoScl['noDn']);
	    			$asuntoMail = 'EXPORTACIÓN ' . $infoScl['nombreCliente'];
	    			//
	    			// Información del GER. *
	    			$useArray = array('object'    => 'Bandeja',
									  'method'    => 'consultaSolicitudesFolio',
									  'methodTwo' => 'consultaJustificacionesPorId');
					$obj = new $useArray['object'];
					$solicitud = $obj->$useArray['method']($folioAbd);
					if(!empty($solicitud['justificaciones'])){
						$justificacion = '';
						foreach($solicitud['justificaciones'] as $item){
							if(is_numeric($item)){
								$justificacion = $justificacion . '* ' . $obj->$useArray['methodTwo']($item) . 
								'. <br>';
							}
						}
						$tpl->assign('justificaciones',$justificacion);
					}else{
						$tpl->assign('justificaciones','NO SE SELECCIONÓ NINGUNA JUSTIFICACIÓN.');
					}
					$tpl->assign('fechaTermino',$solicitud['fechaPendiente']);
	    			//
				}
	    		break;
	    	//
	    	// Se va de la Bandeja Pendiente Respuesta ABD.
	    	case 2:
	    		// SI se Exportó. *
	    		if($decision == 1){
		    		$tpl = new TemplatePower('../template/correo/pendienteRespuestaAceptado.inc');
	    			$tpl->prepare();
	    			// Información de SCL. *
	    			$infoScl = $this->consultaInfoClienteScl($cc);
	    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
	    			$controlLineas = ($infoScl['numeroLineas'] == 1) ? 'línea' : 'líneas';
	    			$tpl->assign('numeroLineas',$infoScl['numeroLineas']);
	    			$tpl->assign('controlLineas',$controlLineas);
	    			$tpl->assign('folioAbd',$folioAbd);
	    			$tpl->assign('cc',$infoScl['codigoCliente']);
	    			$tpl->assign('dn',$infoScl['noDn']);
	    			$asuntoMail = 'EXPORTACIÓN ' . $infoScl['nombreCliente'] . ' // DN ' . $infoScl['noDn'];
	    			//
				// NO se Exportó. *
				}else if($decision == 2){
					$tpl = new TemplatePower('../template/correo/pendienteRespuestaRechazado.inc');
	    			$tpl->prepare();
	    			// Información de SCL. *
	    			$infoScl = $this->consultaInfoClienteScl($cc);
	    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
	    			$controlLineas = ($infoScl['numeroLineas'] == 1) ? 'línea' : 'líneas';
	    			$tpl->assign('numeroLineas',$infoScl['numeroLineas']);
	    			$tpl->assign('controlLineas',$controlLineas);
	    			$tpl->assign('folioAbd',$folioAbd);
	    			$tpl->assign('cc',$infoScl['codigoCliente']);
	    			$tpl->assign('dn',$infoScl['noDn']);
	    			$asuntoMail = 'EXPORTACIÓN ' . $infoScl['nombreCliente'] . ' // DN ' . $infoScl['noDn'];
				}
	    		break;
	    	//
	    	// Se va de la Bandeja de Cobranza.
	    	case 3:
	    		$foliosAbdDemora =array();
	    		if(is_array($folioAbd)){
    				foreach($folioAbd as $folios){
    					if($folios['diasRetraso'] >= 9){
    						$item = array('folioAbd' => $folios['folioAbd'],'diasRetraso' => $folios['diasRetraso']);
    						array_push($foliosAbdDemora,$item);
    					}
	    			}
	    		}
	    		// Hubo al menos 1 Folio con 9 o más días. *
	    		if(!empty($foliosAbdDemora)){
	    			$tpl = new TemplatePower('../template/correo/cobranzaDemora.inc');
		    		$tpl->prepare();
		    		$asuntoMail = 'BITÁCORA DE EXPORTACIONES';
	    			foreach($foliosAbdDemora as $folio){
	    				$tpl->newblock('registros');
		    			// Información de SCL. *
		    			$infoScl = $this->consultaInfoClienteScl($cc);
		    			$tpl->assign('nombreCliente',$infoScl['nombreCliente']);
		    			$tpl->assign('folioAbd',$folio['folioAbd']);
		    			$tpl->assign('codigoCliente',$infoScl['codigoCliente']);
		    			$tpl->assign('diasRetraso',$folio['diasRetraso']);
		    			//
		    			$tpl->gotoBlock('_ROOT');
		    		}
	    			//
				// Todos los Folios fueron de menos de 9 días. *
				}else{
					$tpl = new TemplatePower('../template/correo/cobranzaEnTiempo.inc');
	    			$tpl->prepare();
	    			$asuntoMail = 'BITÁCORA DE EXPORTACIONES';
				}
	    		break;
	    	default:
	    		break;
	    }
	   	try{
	   		// Setear Origen. * 
		    $mail->SetFrom('exportaciones@telefon.com',utf8_decode('Atención a Exportaciones y Reversiones'));
		    //
		    // Setear Destino. *
		    //$mail->AddAddress('',"Grupo");
		    $mail->AddAddress('alf67@hotmail.com','Desarrollador');
		    $mail->AddAddress('monica.romero@telefonica.com','Exportaciones D.F.');
		    $mail->AddAddress('gabriel.sumano.ext@telefonica.com','Exportaciones Mty.');
		    //
		    // Setear ASUNTO. *
		    $mail->Subject = utf8_decode($asuntoMail);
		    //
		    $mail->MsgHTML(utf8_decode($tpl->getOutputContent()));
			$mail->Send();
		}catch(phpmailerException $e){
			echo $e->errorMessage();
	    }catch(Exception $e){
	    	echo $e->getMessage();
	    }
	}
	/**
	* Función para consultar la Información de un Cliente..
	*
	* @return array
	*/
	public function consultaInfoClienteScl($codigoCliente)
	{
		$datos =array("codigoCliente" => 76894354,"numeroLineas" => 2,
			"nombreCliente" => 'AUTOPISTA URBANA NORTE S.A. de C.V.',"noDn" => 5560268984);
		/*try{
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
		}*/
		return $datos;
	}
	/**
	* Función para guardar la plantilla de Correo.
	*
	* @return boolean
	*/
	public function guardaPlantilla()
	{
		try{
			if(isset($_POST['plantilla'])){
				if($file = fopen('../template/correo/' . $_POST['plantilla'],'w')){
					if(fwrite($file,$_POST['cuerpo'])){
						fclose($file);
						$this->setMsgAction(1);
						return true;
					}else{
						throw new Exception("No se pudo escribir en el archivo.");
					}
				}else{
					throw new Exception('No se guardó correctamente la plantilla.');
				}
			}
		}catch (Exception $e){
			$this->setMsgAction('Error: ' . $e->getMessage());
			return false;
		}
	}
}