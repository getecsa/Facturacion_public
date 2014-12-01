<?php
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
                 <h1 class="h1_header">
                   Nueva Solicitud
                </h1>
            </div>
                <div class="content">
                    <form action="homepage.php?id=nueva_factura" method="post" id="nueva_solicitud" name="nueva_solicitud">
                        <table class="content"><tr>
  <td>Tipo de cliente: </td>
  <td>

            <select id="cboClientes" name="tipo_cliente">
                <option value="0">Seleccione un Tipo de Cliente</option>
                <?php
                    $clientes = obterTiposClientes();
                    echo $clientes;
                    foreach ($clientes as $cliente) { 
                        echo '<option value="'.$cliente->id.'">'.$cliente->nombre.'</option>';        
                    }
                ?>
            </select>
        </div>
            

                                        <tr>
                                            <td>Tipo de documento:</td>    
                                            <td><select id="cboDocumentos" name="tipo_documento" style='width:250px;'>
                                                <option value="0">Seleccione un Documento</option>
                                               </select>
                                            </td>
                                        </tr>        
                                      
                                        <tr class="sol_oculto_cod">
                                           <td>Código cliente:</td>  
                                           <td><input type="text" name="cod_cliente" id='cod_cliente' required="required" required style='width:250px;'></td>
                                        </tr>
                                        <tr class="sol_oculto">
                                           <td>Código cliente a afectar:</td>  
                                           <td><input type="text" name="codigo_cliente_afectar" style='width:25'></td>
                                        </tr>                                      
                                        <tr class="sol_oculto_fac">
                                           <td>Folio de la factura:</td>
                                           <td><input type="text" size="8" name="folio_factura_afectar_a" id="folio_factura_afectar_a" >-<input type="text" size="12" name="folio_factura_afectar_b" id="folio_factura_afectar_b"></td>
                                        </tr>
                                        <tr>
                                           <td></td>

                                            <input type='hidden' name='razon_social' id='razon_social'>
                                            <input type='hidden' name='fecha_emision_nc' id='fecha_emision_nc'>
                                            <input type='hidden' name='leyenda_doc' id='leyenda_doc'>
                                            <input type='hidden' name='mt_fac_orig' id='mt_fac_orig'>
                                            <input type='hidden' name='total_nc' id='total_nc'>
                                            <input type='hidden' name='conceptos' id='conceptos'>

                                            <td><input type="button" id="Enviar" name="Enviar" value="Enviar" onclick="return validarNuevaSolicitud();"></td>
                                        </tr>
                                </table>
                                <div id="errorForm"></div> 
                    </form>

               </div>
        </div>

        <script language='javascript'>
            $(document).on({
                ajaxStart: function(){
                    $("body").addClass("loading");
                },
                ajaxStop: function(){
                    $("body").removeClass("loading");
                }
            });
        </script>
        <div class='modal'></div>

