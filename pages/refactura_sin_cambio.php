<?php
include("configuracion.php");
if( (!isset($_POST["tipo_cliente"])) || (!isset($_POST["tipo_documento"]))  ){
    header('Location: homepage.php?id=nueva_solicitud');
}
$tipo_cliente=$_POST["tipo_cliente"];

$sql="select * from tipo_cliente where id_tipo_cliente='$tipo_cliente'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);

$sql_iva="select * from iva";
$result_iva=$mysqli->query($sql_iva);

$sql_moneda="select * from moneda";
$result_moneda=$mysqli->query($sql_moneda);


$tipo_documento=$_POST["tipo_documento"];
$return=0;
$num_return=0;

if(isset($_POST["submit_return"])) {    
$return=1;

      $array_cont=$_POST["array_cont"];  
      $num_concepto=$_POST['num_concepto'];
      $num_return=$num_concepto;
      $cod_cliente=$_POST['cod_cliente'];
      $motivo_sol=$_POST['motivo_sol'];
      $leyenda_doc=$_POST['leyenda_doc'];
      $dias_ven=$_POST['dias_ven'];
      $codigo_cliente_afectar=$_POST['codigo_cliente_afectar'];
      $fecha_emision_nc=$_POST['fecha_emision_nc'];
      $moneda=$_POST['moneda'];
      $iva=$_POST["iva"];
      $folio_fac_origen=$_POST['folio_fac_origen'];
      $folio_nc=$_POST['folio_nc'];
      $fecha_emision_fac_or=$_POST['fecha_emision_fac_or'];
      $razon_social=$_POST['razon_social'];
      $entrada=$_POST['entrada'];
      $motivo_nc=$_POST['motivo_nc'];
      $mt_fac_orig=$_POST['mt_fac_orig'];
      $monto_afectar_nc=$_POST['monto_afectar_nc'];
      $importe_total=$_POST['importe_total']; 
      $tipo_cliente=$_POST['tipo_cliente'];
      $tipo_documento=$_POST['tipo_documento'];
      $id_area=$_SESSION['area'];
      $id_usuario=$_SESSION['uid'];

}
//termina return
$razon_social="";

?>
<div id="divNotificacion" />
  <div class="contenedor">
              <div class="header">
                  <img alt="Movistar" class="logotipo" src="images/logo.png" />
                  <h1 class="h1_header">Nueva Refactura sin cambio</h1> <h2 class="subtitulo"><?=$row['tx_tipo_cliente']?></h2>
              </div>
  <div class="content">
                  <form class="formulario_n" action="homepage.php?id=refactura_sin_cambio_pro" method="post" name="form1" id="form1">
                      <div class="column">
                        <label for="cod_cliente"><p>Código de cliente:</p></label><input type="text" name="cod_cliente" id="cod_cliente" <?php if($return==1){ echo 'value="'.$cod_cliente.'"';} else{ ?>  value="<?php echo $_POST['codigo_cliente']; }?>" readonly="readonly" />
                        <label for="motivo_sol"><p>Motivo de solicitud:</p></label><input type="text" name="motivo_sol" id="motivo_sol" <?php if($return==1){ echo 'value="'.$motivo_sol.'"';} ?>/>
                        <label for="leyenda_doc"><p>Leyenda del documento:</p></label><input type="text" name="leyenda_doc" id="leyenda_doc" <?php if($return==1){ echo 'value="'.$leyenda_doc.'"';} ?> />
                        <label for="dias_ven"><p>Dias de vencimiento:</p></label><input type="text" name="dias_ven" id="dias_ven" <?php if($return==1){ echo 'value="'.$dias_ven.'"';} ?> />
                        <label for="codigo_cliente_afectar"><p>Codigo C.(Fac. Afectar):</p></label><input type="text" name="codigo_cliente_afectar" id="codigo_cliente_afectar" <?php if($return==1){ echo 'value="'.$codigo_cliente_afectar.'"';} else{ ?>  value="<?php echo $_POST['codigo_cliente_afectar'];} ?>" readonly="readonly" />
                        <label for="fecha_emision_nc"><p>Fecha Emision NC:</p></label><input type="text" name="fecha_emision_nc" id="fecha_emision_nc" readonly="readonly" <?php if($return==1){ echo 'value="'.$fecha_emision_nc.'"';} ?> />
                       
                      </div>
                      <div class="column_rz_con">
                          <label for="razon_social"><p>Razón Social:</p></label><input type="text" size="73" name="razon_social" id="razon_social" readonly <?php echo 'value="'.$razon_social.'"'; ?> />
                      </div>
                      <div class="column espacio">
                      <label for="moneda"><p>Moneda:</p></label>
                         <select name="moneda">
                         <option value="0">Seleccione Moneda</option>
                          <?php 
                            while($row=$result_moneda->fetch_array(MYSQLI_ASSOC)){
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

                      <label for="iva"><p>IVA:</p></label>
                      <select id="iva" name="iva">
                      <option value="0">Seleccione IVA</option>
                      <?php 
                            while($row=$result_iva->fetch_array(MYSQLI_ASSOC)){
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
                      <label for="folio_fac_origen"><p>Folio factura origen:</p></label><input type="text" name="folio_fac_origen" id="folio_fac_origen" <?php if($return==1){ echo 'value="'.$folio_fac_origen.'"';} else{ ?> value="<?php echo $_POST['folio_factura_afectar']; }?>" readonly="readonly" />
                      <label for="folio_nc"><p>Folio NC:</p></label><input type="text" name="folio_nc" id="folio_nc" <?php if($return==1){ echo 'value="'.$folio_nc.'"';} ?> />
                      <label for="fecha_emision_nc2"><p>Fecha Emision Fac. Origen:</p></label><input type="text" name="fecha_emision_fac_or" id="fecha_emision_nc2" <?php if($return==1){ echo 'value="'.$fecha_emision_fac_or.'"';} ?> readonly="readonly" />
                       
                      </div>

                      <div class="column">      
                       <!-- <label for="razon_social"><p>Razón Social:</p></label><input type="text" name="razon_social" id="razon_social" <?php if($return==1){ echo 'value="'.$razon_social.'"';} ?>/>
                        --><label for="entrada"><p>Entrada:</p></label><input type="text" name="entrada" id="entrada" <?php if($return==1){ echo 'value="'.$entrada.'"';} ?>/>
                        <label for="motivo_nc"><p>Motivo NC:</p></label><input type="text" name="motivo_nc" id="motivo_nc" <?php if($return==1){ echo 'value="'.$motivo_nc.'"';} ?> />
                        <label for="mt_fac_orig"><p>Monto Total (Fac Origen):</p></label><input type="text" name="mt_fac_orig" id="mt_fac_orig" <?php if($return==1){ echo 'value="'.$mt_fac_orig.'"';} ?>/>
                        <label for="monto_afectar_nc"><p>Monto Afectar con NC:</p></label><input type="text" name="monto_afectar_nc" id="monto_afectar_nc" <?php if($return==1){ echo 'value="'.$monto_afectar_nc.'"';} ?> />
                        <label for="importe_total"><p>Importe total:</p></label><input type="text" name="importe_total" id="importe_total" <?php if($return==1){ echo 'value="'.$importe_total.'"';} ?> />
                        
                      </div>
                    
  <div id="detalles_factura">
  <table class="gridview" id="agregar_detalle">
    <tr>
      <td>Codigo Concepto</td>
      <td>Descripcion Concepto</td>
      <td>Unidades</td>
      <td>Precio Unitario</td>
      <td>Cargo</td>
      <td>Descuento</td>
      <td>Subtotal</td>
    </tr>
         <?php
    if($return==1){
    $subtotal=0;
    for($i=1;$i<=$num_concepto;$i++){
    $subtotal=$subtotal+$array_cont[$i][6];
    ?>
  
    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>"/> </td>
      <td><input type="text" name="add_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][2]" class="calcular_subtotal total_unidades" value="<?php echo $array_cont[$i][2]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][3]" class="calcular_subtotal" value="<?php echo $array_cont[$i][3]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][4]" readonly class="suma_cargo" value="<?php echo $array_cont[$i][4]; ?>"/></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][5]" class="calcular_subtotal" value="<?php echo $array_cont[$i][5]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][6]" readonly class="suma_subtotal" value="<?php echo $array_cont[$i][6]; ?>" /></td>
    </tr>
    
     <?php }  } else {?>
    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[1][0]" /> </td>
      <td><input type="text" name="add_cont[1][1]" /></td>
      <td><input type="text" size="10" name="add_cont[1][2]" class="calcular_subtotal total_unidades" /></td>
      <td><input type="text" size="10" name="add_cont[1][3]" class="calcular_subtotal" /></td>
      <td><input type="text" size="10" name="add_cont[1][4]" readonly="readonly" class="suma_cargo"/></td>
      <td><input type="text" size="10" name="add_cont[1][5]" class="calcular_subtotal" /></td>
      <td><input type="text" size="10" name="add_cont[1][6]" readonly="readonly" class="suma_subtotal" /></td>
    </tr>
    <?php } ?>
    </table>
    <table class="gridview">
    <tr>
    <td colspan="3"><a href="#" id="agregar_campo_fac"><div class="agregar_observacion botones">Agregar Concepto</div></a></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr> 
 <!--  <tr>
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
   </tr> -->	
  </table> 
  <div id="errorForm"></div>
                   <div class="boton_envio">
                    <input  type="hidden" value="<?php echo $return; ?>" name="return" id="return">
                    <input  type="hidden" value="<?php echo $num_return; ?>" name="num_return" id="num_return">
                    <input  type="hidden" id="num_concepto" value="1" name="num_concepto">
                    <input  type="hidden"  value="<?php echo $tipo_cliente; ?>" name="tipo_cliente">
                    <input  type="hidden"  value="<?php echo $tipo_documento; ?>" name="tipo_documento">
                    <input type="submit" id="submit" name="submit" value="Enviar" onclick="return validarUsuarioRefacturaSin();">
                    <input type="reset" value="Borrar" >
                  </div>

        </form>




       </div>
    </div>
 </div>   