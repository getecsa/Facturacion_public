<?php
 include("configuracion.php");

 $area_operador=$_SESSION['tx_area'];
 if(isset($_POST["valor_solicitud"])) {

  
  $id_solicitud=$_POST["valor_solicitud"];
  $id_documento=$_POST["id_documento"];
  
echo $id_solicitud;

echo $id_documento;

$sql = "SELECT *  FROM `aclaracion_queja` WHERE `id` = '$id_solicitud'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);



}  
  
?>
<div id="divNotificacion" />

        <div class="contenedor">
            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                <h1><?php echo $area_operador;?>
                </h1>    
            </div>
            <div class="content">
<form method="POST" action="homepage.php?id=operacion_ATC">  
<input type="hidden" name="bandera"> 
<input type="hidden" name="id" value="<?php echo $id_solicitud;?>">              
               <table class="gridview"  id="tabla" >
                    
 <tr bgcolor="00517A">
                        <td ><font color="#fff">Código de Cliente</font></td>
								<td ><font color="#fff">Línea de Negocio</font></td>                                               
                        <td ><font color="#fff">Tipo Solicitud</font></td>                        
                        
                       	<td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                       
                       
                       
                  </tr>	
 						 <tr >
                        <td ><?php echo $row["cod_cte"]; ?></td>
    							<td ><?php echo $row["linea_negoc"]; ?></td>                    
								<td ><?php echo $row["tipo_solic"]; ?></td>                        
                        <td ><?php echo $row["fecha_recep"]; ?></td>
                        <td ><?php echo $row["fecha_atenc"]; ?></td>
								
                                                                                       
                    </tr>	                                      
                    
						  <tr bgcolor="00517A">
								<td ><font color="#fff">Detalle Solicitud</font></td>
								<td ><font color="#fff">Fecha Observación</font></td>
								<td ><font color="#fff">Usuario</font></td>
								<td ><font color="#fff">Área</font></td>
                    </tr>


<?php 

$sql = "SELECT ob.`observacion`, ob.`fecha_observacion`, us.nombre, us.area_idarea, ar.tx_area from observaciones ob
inner join users us on ob.`users_id_usuario` = us.id_usuario
inner join area ar on us.area_idarea = ar.id_area
where `estado` = 2
and solicitudes_id_solicitudes = '$id_solicitud'
order by fecha_observacion asc
";

$result=$mysqli->query($sql);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {


?>

                      <tr >
								<td ><?php echo $row['observacion']; ?></td>
								<td ><?php echo $row['fecha_observacion']; ?></td>
								<td ><?php echo $row['nombre']; ?></td>
								<td ><?php echo $row['tx_area']; ?></td>
                    </tr>
                    
 <?php 
 }
 
 ?>                   
                      <tr bgcolor="00517A">
								<td ><font color="#fff">Agregar observación</font></td>
								<td ><font color="#fff">Estatus</font></td>
								<td></td>
                    </tr>
                    <tr >
								 <td ><textarea COLS="25" ROWS="2" name="detalle_solic">
                             </textarea></td>
                         <td><select name="estatus">
                         <option value='0'>SELECCIONE ESTATUS</option>
<?php


if($area_operador <> 'REPORTE TEMM' && $area_operador <> 'REPORTEO') {

  	$sql_per="SELECT *
             FROM area 
             WHERE oper_sol = '0'";
   $result=$mysqli->query($sql_per);
    	
    	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
	
	    	if($row['tx_area']<>'DIRECCIONAMIENTO' && $row['tx_area']<>'ASIGNACION TEMM' && $row['tx_area']<>'ENTREGA DE DOCUMENTOS' && $row['tx_area']<> $area_operador) {
?>             
            
 <option value='<?php echo $row['id_area']; ?>'><?php echo $row['tx_area']; ?></option> 
                        
<?php 
			}
		
		}
?>


		
<?php		 
}

else if($area_operador == 'REPORTEO') {
?>

<?php

}

else if ($area_operador == 'REPORTE TEMM'){
?>
<option value='26'>REPORTEO</option>

<?php
}
?>
<option value='Cerrar'>CERRAR FOLIO</option>

                         </select></td>
                         <td  align="center"><input type="submit" ID="btnLogin"  value="Enviar" ></td>
                    </tr>             
                   
                    <tr>
                     
                       
                    </tr>
            </table>
            
</form>
                
            </div>
            
        </div>
    


 </div>   	