<?php
include("conectar_bd.php");	

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
                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                <h1>
                    <?php echo utf8_encode($_SESSION['username']);?>
                </h1>
            </div>
            <div class="content">

<form action="homepage.php?id=buscar" method="post">                 
<table width=30%>
<tr>
<td><h2 class="block">Folio:</h2></td>
<td>  <input type="text" name="folio"></td>
<td> <input type="submit" value="Buscar Folio" name="buscar"></td>
<td></td>
</tr>
<tr>
<td><h2 class="block">Tipo Solicitud:</h2></td>
<td> <select>
                <option>Seleccione Solicitud</option>
                <option value="Factura">Factura</option>
                <option value="NC">Nota de Crédito</option>
                <option value="RFCon">Refactura Con Cambio</option>
                <option value="RFSin">Refactura Sin Cambio</option>
                 
                 </select></td>
<td> <input type="submit" value="Buscar Tipo" name="buscar"></td>
<td></td>
</tr>
</table>
</form>
                
<?php
 
	if(isset($_POST["buscar"])&& $_POST["buscar"]== 'Buscar Folio') {
 
   		$folio = $_POST["folio"];
   
			$sql="SELECT distinct so.id_solicitudes, td.tipo_doc, date(so.fecha_solicitud) as fecha, do.estado_actual
        	FROM solicitudes so
  			INNER JOIN documento do ON so.id_solicitudes=do.solicitudes_idSolicitudes
  			
  			INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       	WHERE so.users_id_usuario='$id_user'
         AND so.id_solicitudes='$folio'";

			echo '<table class="gridview">
						<tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estatus</font></td>
                  </tr>';

					if ($rs = mysqli_query($con, $sql)) {
    
						while ($fila = mysqli_fetch_assoc($rs)) {

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
?>

                    <tr>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>&bandera=buscar" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"><?php echo $fila["id_solicitudes"]; ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                       <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"> <?php echo $estatus; ?></a></td>
     						
                    </tr>
                    
<?php 	
if($fila["estado_actual"]==7) { 

$adjuntos="SELECT * 
FROM  `adjuntos` 
WHERE  `id_documento` =  '$folio'
AND  `area` =  '6'";
if ($rs_adjuntos = mysqli_query($con, $adjuntos)) {
	/* fetch array asociativo*/
		while ($fila_adjuntos = mysqli_fetch_assoc($rs_adjuntos)) {
				echo '<a href="Archivos/'.$fila_adjuntos["nombre"].'"><h2>DESCARGAR DOCUMENTO GENERADO</h2></a>';
		}
}
}

			}

					}       

				echo '<tr bgcolor="00517A">                   
                        <td colspan="2" ><font color="#fff">Fecha Observación</font></td>
                        <td colspan="2"><font color="#fff">Observación</font></td>
                  </tr>';
                    
$sql = "SELECT fecha_observacion as fecha, observacion 
FROM `observaciones` WHERE `solicitudes_id_solicitudes` = '$folio'";

	if ($rs = mysqli_query($con, $sql)) {
	/* fetch array asociativo*/
		while ($fila = mysqli_fetch_assoc($rs)) {

			echo '<tr>           				
                        <td colspan="2">'.$fila["fecha"].'</td>
                        <td colspan="2">'.utf8_encode($fila["observacion"]).'</td>                 
               </tr>';                    
 			
		}

	}
    
   echo  '</table>';
}

else if(isset($_POST["buscar"])&& $_POST["buscar"]== 'Buscar Tipo') {
echo $_POST["buscar"].' Buscar Tipo'; 
   
}

?>

</div>    
</div>
