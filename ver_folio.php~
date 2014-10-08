<script languaje="Javascript">    
function MostrarOcultar(clase,id_b)  
{  
    if (document.getElementById)  
    {  
        var aux = document.getElementById(clase).style;  
        aux.display = aux.display? "":"block";  
    }  
}  

function Ocultar(clase,id_b)  
{  
    if (document.getElementById)  
    {  
        var aux = document.getElementById(clase).style;  
        aux.display = aux.display? "":"none";  
    }  
}  
</script>


<div id="ver_folio">

    <br>
      <h2>Historial de folio</h2>
    <br>
      <table class="gridview">
				 <tr bgcolor="00517A">
                        <td ><font color="#fff">Fecha Observaciòn</font></td>
                        <td ><font color="#fff">Observaciòn</font></td>
                      
                        
            </tr>

<?php 
	include("conectar_bd.php");
$id = $_GET['id'];
session_start();
 $id_user = $_SESSION['uid'];
$estado = $_GET['estado'];
echo $estado;
$sql = "SELECT fecha_observacion as fecha, observacion 
FROM `observaciones` WHERE `solicitudes_id_solicitudes` = '$id'
and estado = '0'
";



if ($rs = mysqli_query($con, $sql)) {
	/* fetch array asociativo*/
while ($fila = mysqli_fetch_assoc($rs)) {
		
?>

    <tr>
            
                        <td><?php echo $fila["fecha"]; ?></td>
                        <td><?php echo utf8_encode($fila["observacion"]); ?></td>
         
                       
                    </tr>
<?php }
}		
?>
  
		</table>           
</div>
<div class="botones">

<input type="submit"  onclick="MostrarOcultar('add_observaciones');"  value="Actualizar Folio"> 
<!-- <a class="texto" href="javascript:MostrarOcultar('add_observaciones');"> ver</a> -->
<!-- <div class="agregar_observacion">Agregar Observacion</div> -->

<form action="homepage.php?id=solicitante&param=Pendiente" method="POST">

<div class="ventana_ocultar" id="add_observaciones">
Comentarios:
<input type="hidden" name="form_1" value="bandera_comentario">
<input type="hidden" name="id" value="<?php echo $id;?>">
<textarea rows="5" cols="60" name="comentario"></textarea>
<table border="0">
<td><input type="submit" value="Guardar"> </td>
<td><input type="submit" onclick="Ocultar('add_observaciones');" value="Cancelar"> </td>
</table>
</div>
</form>
</div>
