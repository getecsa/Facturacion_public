<?php
include("config.php");

$sql_iva="select * from iva";
$result_iva=mysql_db_query($db, $sql_iva,$link);

$sql_moneda="select * from moneda";
$result_moneda=mysql_db_query($db, $sql_moneda,$link);

if( (!isset($_POST["tipo_cliente"])) || (!isset($_POST["tipo_documento"]))  ){

    header('Location: homepage.php?id=nueva_solicitud');
}

$tipo_cliente=$_POST["tipo_cliente"];
$tipo_documento=$_POST["tipo_documento"];
$return=0;
$num_return=0;

//return

if(isset($_POST["submit_return"])) {    
$return=1;

  $array_cont=$_POST["array_cont"];  
  $num_concepto=$_POST['num_concepto'];
  $num_return=$num_concepto;
  $cod_cliente=$_POST['cod_cliente'];
  $motivo_sol=$_POST['motivo_sol'];
  $folio_fac_origen=$_POST['folio_fac_origen'];
  $leyenda_doc=$_POST['leyenda_doc'];
  $tipo_nc=$_POST['tipo_nc'];
  $iva=$_POST["iva"];
  $mt_fac_orig=$_POST['mt_fac_orig'];
  $fecha_emision_nc=$_POST['fecha_emision_nc'];
  $razon_social=$_POST['razon_social'];
  $monto_afectar_nc=$_POST['monto_afectar_nc'];
  $moneda=$_POST['moneda'];
$tipo_cliente=$_POST['tipo_cliente'];
$tipo_documento=$_POST['tipo_documento'];
$id_area=$_SESSION['area'];
$id_usuario=$_SESSION['uid'];

}
//termina return

?>
<div id="divNotificacion" />
  <div class="contenedor">
              <div class="header">
                  <img alt="Movistar" class="logotipo" src="images/logo.png" />
                  <h1>Nueva nota de crédito</h1>
              </div>
  <div class="content">
                  <form class="formulario_n" action="homepage.php?id=nueva_nota_pro" method="post" name="form1" id="form1">
                    <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><input type="text" name="cod_cliente" id="cod_cliente" <?php if($return==1){ echo 'value="'.$cod_cliente.'"';} else{ ?> value="<?php echo $_POST['codigo_cliente']; }?>" />
                        <label for="motivo_sol">Motivo de solicitud:</label><input type="text" name="motivo_sol" id="motivo_sol" <?php if($return==1){ echo 'value="'.$motivo_sol.'"';} ?>/>
                        <label for="leyenda_doc">Leyenda del documento:</label><input type="text" name="leyenda_doc" id="leyenda_doc" <?php if($return==1){ echo 'value="'.$leyenda_doc.'"';} ?>/>
                        <label for="folio_fac_origen">Folio factura origen:</label><input type="text" name="folio_fac_origen" id="folio_fac_origen" <?php if($return==1){ echo 'value="'.$folio_fac_origen.'"';} ?> />
                      </div>  
                      <div class="column bottom_nc">   
                      <label for="tipo_nc">Tipo Nota:</label>
                      <select name="tipo_nc">
                        <option value="0">Seleccione Tipo</option>
                        <option <?php if($return==1){ if($tipo_nc=="Parcial") { echo"selected"; } } ?> >Parcial</option>
                        <option <?php if($return==1){ if($tipo_nc=="Total") { echo"selected"; } } ?> >Total</option>
                      </select>
                      <label for="iva">IVA:</label>
                      <select id="iva" name="iva">
                      <option value="0">Seleccione IVA</option>
                      <?php 
                            while($row=mysql_fetch_array($result_iva)){
                            echo "<option value='",$row['id_iva'],"'";
                              if($return==1){ 
                                if($row['id_iva']==$iva)
                                  {
                                    echo"selected";
                                  }
                                } 
                            echo ">",$row['valor_tx'],"</option>";
                              }
                          ?>
                      </select>
                      <label for="mt_fac_orig">Monto Total (Fac Origen):</label><input type="text" name="mt_fac_orig" id="mt_fac_orig" <?php if($return==1){ echo 'value="'.$mt_fac_orig.'"';} ?>/>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><input type="text" name="razon_social" id="razon_social" <?php if($return==1){ echo 'value="'.$razon_social.'"';} ?>/>
                        <label for="moneda">Moneda:</label>
                        <select name="moneda">
                        <option value="0">Seleccione Moneda</option>
                          <?php 
                            while($row=mysql_fetch_array($result_moneda)){
                            echo "<option value='",$row['id_moneda'],"'";
                              if($return==1){ 
                                if($row['id_moneda']==$moneda)
                                  {
                                    echo"selected";
                                  }
                                } 
                            echo ">",$row['moneda'],"</option>";
                              }
                          ?>
                        </select>
                        <label for="fecha_emision_nc">Fecha Emisión:</label><input type="text" name="fecha_emision_nc" id="fecha_emision_nc" readonly="readonly" <?php if($return==1){ echo 'value="'.$fecha_emision_nc.'"';} ?> />
                        <label for="monto_afectar_nc">Monto Afectar con NC:</label><input type="text" name="monto_afectar_nc" id="monto_afectar_nc" <?php if($return==1){ echo 'value="'.$monto_afectar_nc.'"';} ?> />
                      </div>
                    
  <div id="detalles_factura">
  <table class="gridview" id="agregar_detalle">
    <tr>
      <td>Código Concepto</td>
      <td>Descripción Concepto</td>
      <td>Importe Disponible</td>
      <td>Monto Afectar</td>
    </tr>
      <?php
    if($return==1){
    $subtotal=0;
    for($i=1;$i<=$num_concepto;$i++){	
    $subtotal=$subtotal+$array_cont[$i][3];
    ?>
  
    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>"/> </td>
      <td><input type="text" size="30" name="add_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][2]" class="calcular_subtotal total_unidades" value="<?php echo $array_cont[$i][2]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][3]" class="calcular_subtotal" value="<?php echo $array_cont[$i][3]; ?>" /></td>
    </tr>
    
     <?php }  } else {?>

    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[1][0]" /> </td>
      <td><input type="text" size="30" name="add_cont[1][1]" /></td>
      <td><input type="text" size="10" name="add_cont[1][2]" /></td>
      <td><input type="text" size="10" name="add_cont[1][3]" /></td>
    </tr>
    <?php } ?>
    </table>
    <table class="gridview">
    <tr>
    <td colspan="3"><a href="#" id="agregar_campo_nota"><div class="agregar_observacion botones">Agregar Concepto</div></a></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr> 
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>SubTotal:</td>
    <td></td>
    <td></td>
    <td class="total_subtotal">$0</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IVA:</td>
    <td></td>
    <td></td>
    <td>$32</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IEPS:</td>
    <td></td>
    <td></td>
    <td>$0</td>
   </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>Total:</td>
    <td></td>
    <td></td>
    <td>$200</td>
   </tr>
  </table> 
  <div id="errorForm"></div>
        </fieldset>
                   <div class="boton_envio">
                    <input  type="hidden" value="<?php echo $return; ?>" name="return" id="return">
                    <input  type="hidden" value="<?php echo $num_return; ?>" name="num_return" id="num_return">
                    <input  type="hidden" id="num_concepto" value="1" name="num_concepto">
                    <input  type="hidden"  value="<?php echo $tipo_cliente; ?>" name="tipo_cliente">
                    <input  type="hidden"  value="<?php echo $tipo_documento; ?>" name="tipo_documento">
                    <input type="submit" id="submit" name="submit" value="Enviar" onclick="return validarUsuarioNotaCredito();">
                    <input type="reset" value="Borrar" >
                  </div>

        </form>




       </div>
    </div>
 </div>   