
<?php
include("configuracion.php");
$id_area=$_SESSION['area'];
$id_usuario=$_SESSION['uid'];


if(isset($_POST['bandera'])) {
	

$tipo_sol=$_POST['tipo_sol'];
$detalle_solic=$_POST['detalle_solic'];
$linea_negoc=$_POST['linea_negoc'];
$cod_cte=$_POST['cod_cte'];
	
$query="INSERT INTO `sis_fac`.`aclaracion_queja` 
( `fecha_recep`, `usuario`, `area`, `tipo_solic`, 
`detalle_solic`, `linea_negoc`, `cod_cte`, estatus, area_flujo) 
VALUES ( now(), '$id_usuario', '$id_area',  '$tipo_sol', 
'$detalle_solic', '$linea_negoc', '$cod_cte', '0', '7')";
$result = $mysqli->query($query);
$id_solicitud=$mysqli->insert_id;

 //guarda Historial
                               $query="INSERT INTO historial_estados (fecha,
                                                   estado_solicitud_idestado_solicitud,
                                                   users_id_usuario,
                                                   area_id_area,
                                                   id_aclaracion) 
                                            VALUES (now(),
                                                    0,
                                                    '$id_usuario',
                                                    '$id_area',
                                                    '$id_solicitud')";
                                $mysqli->query($query) or die($mysqli->error);

$query = "INSERT INTO observaciones( observacion,fecha_observacion,users_id_usuario,
 estado,solicitudes_id_solicitudes )
 VALUES ( '$detalle_solic', now(), '$id_usuario', '2', '$id_solicitud')";
$result = $mysqli->query($query);	
}



?>
        <div class="contenedor">
            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png">
                <h1 class='h1_header'>Aclaración o Queja</h1>    
            </div>
            <div class="content">
<form method="POST" action="#">                
               <table class="gridview"  id="tabla" >
                    
						<tr>
                        <td>Tipo de solictud:</td> 
                        <td><select name="tipo_sol" >
                              <option value="0">Seleccione tipo de solicitud</option>
                              <option value="Aclaración">Aclaración</option>
                              <option value="Solicitud">Solicitud</option>
                              
                                </select></td>

                        
                        
                    </tr>

                    <tr>
                        <td >Detalle solicitud: </td>
                        <td><textarea COLS="25" ROWS="2" name="detalle_solic">
                             </textarea></td>                     
                        
                    </tr>
                    
						<tr>
                        <td>Línea de negocio</td> 
                        <td><select name="linea_negoc">
                              <option value="0">Seleccione tipo </option>
                              <option value="Data">Data</option>
                              <option value="Pospago">Pospago</option>
                              <option value="">...</option>
                              
                                </select></td>

                        
                        
                    </tr>
                  <tr>
                        <td>Código de cliente</td> 
                        <td><input type="text" name="cod_cte"></td>

                        
                        
                    </tr>
                                      
                   
                     
                                       <tr>
<input type="hidden" name="bandera" value="bandera">                        
                       <td colspan="4" align="center"><input type="submit" ID="btnLogin"  value="Enviar" ></td>
                    </tr>
            </table>
</form>
                
            </div>
            
        </div>
    
