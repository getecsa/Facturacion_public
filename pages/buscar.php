<?php
include("configuracion.php");

$id_user = $_SESSION['uid'];

 //Validar que el usuario este logueado y exista un UID
if ( ! ($_SESSION['autenticado'] == 'SI' && isset($_SESSION['uid'])) )
{
    header('location: index.php');
}

    $id_usuario=$_SESSION['uid'];
    $id_area=$_SESSION['area'];

// form anidado 
     
include("cliente.php");

?>

<div class="contenedor">
            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png">
                <h1 class='h1_header'>
                    <?php echo utf8_encode($_SESSION['username']);?>
                </h1>
            </div>
            <div class="content">

             
<table width='60%'>
    <tr>
    <td colspan="3"> <h2> Solicitud</h2> </td>
    </tr>
    <tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Código Cliente:</label></td>
            <td><input type="text" name="tx_cod" style='width:155px;'></td>
            <input type="hidden" value="Cod_Cte" name="Cod_Cte">
            <td><input type="submit" value="Buscar Código de Cliente" name="buscar"></td>
        </form>
    </tr>
    
    <tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Folio documento:</label></td>
            <td><input type="text" name="folio" style='width:155px;'></td>
            <input type="hidden" value="fol_doc" name="fol_doc">
            <td><input type="submit" value="Buscar Documento" name="buscar"></td>
        </form>
    </tr>
     <tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Razón Social:</label></td>
            <td><input type="text" name="tx_RFC" style='width:155px;'></td>
             <input type="hidden" value="RFC" name="RFC">
            <td><input type="submit" value="Buscar Razón" name="buscar"></td>
        </form>
    </tr>
     
    <tr>
   <td colspan="3"><h2> Aclaración</h2></td>
    </tr>
    <tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Folio Aclaración o Queja:</label></td>
            <td><input type="text" name="folio_aclaracion" style='width:155px;'></td>
             <input type="hidden" value="fol_ATC" name="fol_ATC">
            <td><input type="submit" value="Buscar Aclaración ó Queja" name="buscar"></td>
        </form>
    </tr>
    <tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Código de cliente:</label></td>
            <td><input type="text" name="cod_aclaracion" style='width:155px;'></td>
             <input type="hidden" value="cod_ATC" name="cod_ATC">
            <td><input type="submit" value="Buscar Código de Cliente" name="buscar"></td>
        </form>
    </tr>
    <!--<tr>
        <form action="homepage.php?id=buscar" method="post">  
            <td><label>Tipo Solicitud:</label></td>
            <td>
                <select>
                    <option>Seleccione Solicitud</option>
                    <option value="Factura">Factura</option>
                    <option value="NC">Nota de Crédito</option>
                    <option value="RFCon">Refactura Con Cambio</option>
                    <option value="RFSin">Refactura Sin Cambio</option>     
                </select>
            </td>
            <td><input type="submit" value="Buscar Tipo" name="buscar"></td>
        </form>
    </tr>-->
</table>
<?php
 
	if(isset($_POST["Cod_Cte"])&& ($_POST["Cod_Cte"]== "Cod_Cte")) {

$Cod_Cte = $_POST["tx_cod"];
   
			$sql="SELECT  do.solicitudes_idSolicitudes, td.tipo_doc, date(so.fecha_solicitud) as fecha, do.estado_actual, do.id_documento 
        	FROM solicitudes so
  			INNER JOIN documento do ON so.id_solicitudes=do.solicitudes_idSolicitudes
  			
  			INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       	WHERE so.users_id_usuario='$id_user'
         AND do.id_codigo_cliente='$Cod_Cte'";
         
			echo '<br><h2>Código de Cliente: '.$Cod_Cte.'</h2>';
			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estatus</font></td>
                  </tr>';

	if ($rs = $mysqli->query($sql)) {
    
						while ($fila =$rs->fetch_array(MYSQLI_ASSOC)) {

							if($fila["estado_actual"]==0 || $fila["estado_actual"]==1 || $fila["estado_actual"]==2 || $fila["estado_actual"]==3 ||
             				$fila["estado_actual"]==5 || $fila["estado_actual"]==6){
									$estatus = 'Pendiente';             
             			}
							else if($fila["estado_actual"]==4 ){
									$estatus = 'Rechazada';             
             			}
							else if($fila["estado_actual"]==7 ){
									$estatus = 'Aceptada';             
             			}
             			$folio = $fila["id_documento"];
?>

                    <tr>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"><?php echo $fila["id_documento"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $estatus; ?></a></td>
<?php 	
if($fila["estado_actual"]==7) { 
$adjuntos="SELECT * 
FROM  `adjuntos` 
WHERE  `id_documento` =  '$folio'
AND  `area` =  '6'";
	if ($rs_adjuntos = $mysqli->query($adjuntos)) {
	/* fetch array asociativo*/
		while ($fila_adjuntos =$rs_adjuntos->fetch_array(MYSQLI_ASSOC)) {
			echo '<td><a href="Archivos/'.$fila_adjuntos["nombre"].'" >Descargar Doc</a></td>';
		}
	}
}
?>     						
                    </tr>
                    
<?php 	
			}
					}           
   echo  '</table>';
}
?>
                
<?php
 
	if(isset($_POST["fol_doc"])&& $_POST["fol_doc"]== 'fol_doc') {
 
   		$folio = $_POST["folio"];
   
			$sql="SELECT distinct do.solicitudes_idSolicitudes, td.tipo_doc, date(so.fecha_solicitud) as fecha, do.estado_actual, do.id_documento
        	FROM solicitudes so
  			INNER JOIN documento do ON so.id_solicitudes=do.solicitudes_idSolicitudes
  			
  			INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       	WHERE so.users_id_usuario='$id_user'
         AND so.id_solicitudes='$folio'";
echo '<br><h2>Folio del Documento: '.$folio.'</h2>';
			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estatus</font></td>
                  </tr>';

					if ($rs = $mysqli->query($sql)) {
    
						while ($fila =$rs->fetch_array(MYSQLI_ASSOC)) {

							if($fila["estado_actual"]==0 || $fila["estado_actual"]==1 || $fila["estado_actual"]==2 || $fila["estado_actual"]==3 ||
             				$fila["estado_actual"]==5 || $fila["estado_actual"]==6){
									$estatus = 'Pendiente';             
             			}
							else if($fila["estado_actual"]==4 ){
									$estatus = 'Rechazada';             
             			}
							else if($fila["estado_actual"]==7 ){
									$estatus = 'Aceptada';             
             			}
$folio = $fila["id_documento"];
?>

                    <tr>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"><?php echo $fila["id_documento"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $estatus; ?></a></td>
<?php 	
if($fila["estado_actual"]==7) { 
$adjuntos="SELECT * 
FROM  `adjuntos` 
WHERE  `id_documento` =  '$folio'
AND  `area` =  '6'";
	if ($rs_adjuntos = $mysqli->query($adjuntos)) {
	/* fetch array asociativo*/
		while ($fila_adjuntos =$rs_adjuntos->fetch_array(MYSQLI_ASSOC)) {
			echo '<td><a href="Archivos/'.$fila_adjuntos["nombre"].'" >Descargar Doc</a></td>';
		}
	}
}
?>     						
                    </tr>
                    
<?php 	
			}
					}           
   echo  '</table>';
}
?>
<?php
 
	if(isset($_POST["RFC"])&& ($_POST["RFC"]== "RFC")) {


$rfc = $_POST["tx_RFC"];


			$sql="SELECT  do.solicitudes_idSolicitudes, td.tipo_doc, date(so.fecha_solicitud) as fecha, do.estado_actual, do.id_documento 
        	FROM solicitudes so
  			INNER JOIN documento do ON so.id_solicitudes=do.solicitudes_idSolicitudes
  			
  			INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       	WHERE so.users_id_usuario='$id_user'
         AND do.razon_social='$rfc'";
         
			echo '<br><h2>Razón Social: '.$rfc.'</h2>';
			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estatus</font></td>
                  </tr>';

	if ($rs = $mysqli->query($sql)) {
    
						while ($fila =$rs->fetch_array(MYSQLI_ASSOC)) {

							if($fila["estado_actual"]==0 || $fila["estado_actual"]==1 || $fila["estado_actual"]==2 || $fila["estado_actual"]==3 ||
             				$fila["estado_actual"]==5 || $fila["estado_actual"]==6){
									$estatus = 'Pendiente';             
             			}
							else if($fila["estado_actual"]==4 ){
									$estatus = 'Rechazada';             
             			}
							else if($fila["estado_actual"]==7 ){
									$estatus = 'Aceptada';             
             			}
             			$folio = $fila["id_documento"];
?>

                    <tr>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"><?php echo $fila["id_documento"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                        <td><a href="ver_folio.php?id_doc=<?php echo $fila["id_documento"];?>&id_sol=<?php echo $fila["solicitudes_idSolicitudes"];?>&estado=<?php echo $fila["estado_actual"];?>" title="Folio <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $estatus; ?></a></td>
<?php 	
if($fila["estado_actual"]==7) { 
$adjuntos="SELECT * 
FROM  `adjuntos` 
WHERE  `id_documento` =  '$folio'
AND  `area` =  '6'";
	if ($rs_adjuntos = $mysqli->query($adjuntos)) {
	/* fetch array asociativo*/
		while ($fila_adjuntos =$rs_adjuntos->fetch_array(MYSQLI_ASSOC)) {
			echo '<td><a href="Archivos/'.$fila_adjuntos["nombre"].'" >Descargar Doc</a></td>';
		}
	}
}
?>     						
                    </tr>
                    
<?php 	
			}
					}           
   echo  '</table>';


}
?>
                

<?php
 if(isset($_POST["fol_ATC"])&& $_POST["fol_ATC"]== 'fol_ATC') {

		$folio = $_POST["folio_aclaracion"];
   
			$sql="SELECT * 
					FROM  `aclaracion_queja` 
					WHERE id = '$folio'";
echo '<br><h2>Folio de Aclaración ó Queja: '.$folio.'</h2>';
			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                        <td ><font color="#fff">Tipo Solicitud</font></td>
                        <td ><font color="#fff">Detalle Solicitud</font></td>
                        <td ><font color="#fff">Línea de Negocio</font></td>
                        <td ><font color="#fff">Código de Cliente</font></td>
                        <td ><font color="#fff">Proceso</font></td>
                        <td ><font color="#fff">Fecha Cierre</font></td>
                  </tr>';

					if ($rs = $mysqli->query($sql)) {
    
						while ($fila =$rs->fetch_array(MYSQLI_ASSOC)) {

						echo '<tr>           				
                        <td >'.$fila["id"].'</td>
                        <td >'.$fila["fecha_recep"].'</td>
                        <td >'.$fila["fecha_atenc"].'</td>
								<td >'.utf8_encode($fila["tipo_solic"]).'</td>
                        <td >'.utf8_encode($fila["detalle_solic"]).'</td>
                        <td >'.utf8_encode($fila["linea_negoc"]).'</td>
                        <td >'.$fila["cod_cte"].'</td>
                        <td >'.$fila["proceso"].'</td>
                        <td >'.$fila["fecha_cierre"].'</td>                 
               			</tr>'; 

						}
					}

					 echo  '</table>';

}


?>

<?php
 if(isset($_POST["cod_ATC"])&& $_POST["cod_ATC"]== 'cod_ATC') {

		$cod_ATC = $_POST["cod_aclaracion"];
		

   
			$sql="SELECT * 
					FROM  `aclaracion_queja` 
					WHERE cod_cte = '$cod_ATC'";
					
		//	echo $sql;
echo '<br><h2>Código de cliente de Aclaración o Queja: '.$cod_ATC.'</h2>';
			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                        <td ><font color="#fff">Tipo Solicitud</font></td>
                        <td ><font color="#fff">Detalle Solicitud</font></td>
                        <td ><font color="#fff">Línea de Negocio</font></td>
                        <td ><font color="#fff">Código de Cliente</font></td>
                        <td ><font color="#fff">Proceso</font></td>
                        <td ><font color="#fff">Fecha Cierre</font></td>
                  </tr>';

					if ($rs = $mysqli->query($sql)) {
    
						while ($fila =$rs->fetch_array(MYSQLI_ASSOC)) {

						echo '<tr>           				
                        <td >'.$fila["id"].'</td>
                        <td >'.$fila["fecha_recep"].'</td>
                        <td >'.$fila["fecha_atenc"].'</td>
								<td >'.$fila["tipo_solic"].'</td>
                        <td >'.$fila["detalle_solic"].'</td>
                        <td >'.$fila["linea_negoc"].'</td>
                        <td >'.$fila["cod_cte"].'</td>
                        <td >'.$fila["proceso"].'</td>
                        <td >'.$fila["fecha_cierre"].'</td>                 
               			</tr>'; 

						}
					}

					 echo  '</table>';

}


?>


</div>    
</div>
