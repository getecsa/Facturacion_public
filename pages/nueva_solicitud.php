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
                                            <td><select id="cboDocumentos" name="tipo_documento">
                                                <option value="0">Seleccione un Documento</option>
                                               </select>
                                            </td>
                                        </tr>        
                                      
                                        <tr>
                                           <td>Código cliente:</td>  
                                           <td><input type="text" name="cod_cliente" required="required" required /></td>
                                        </tr>
                                        <tr class="sol_oculto">
                                           <td>Código cliente a afectar:</td>  
                                           <td><input type="text" name="codigo_cliente_afectar" /></td>
                                        </tr>                                      
                                        <tr class="sol_oculto">
                                           <td>Folio de la factura afectar:</td>  
                                           <td><input type="text" name="folio_factura_afectar" /></td>
                                        </tr>


                                        <tr>
                                           <td></td>  
                                           <td><input type="submit" id="Enviar" name="Enviar" value="Enviar" onclick="return validarUsuarioNuevaSolictud();" /></td>
                                        </tr>
                                </table>
                                <div id="errorForm"></div> 
                    </form>

               </div>
        </div>
