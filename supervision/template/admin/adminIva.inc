<!--adminIva.inc Plantilla que muestra la tabla de los distintos IVA's registrados. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>I.V.A.</h2>
                    <br>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <input type='button' name='agregaIva' value='Nueva Tasa' 
                    onclick="location.href='admin.php?mod=iva&acc=form&opc=new';" style='margin-left:auto;margin-right:auto;display:block;'>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo IVA</th>
                                <th>Valor</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- START BLOCK : registros -->
                            <tr>
                                <td>{indice}</td><td>{tipoIva}</td><td>{valorIva}</td><td>{estatus}</td>
                                <td style='text-align:center;'>
                                    <a href='#' onclick="editarTasa({indice});" style='text-decoration:none;'>
                                        <img src='images/edit.png' border='0' width='20' height='20' alt='Editar' title='Editar'>
                                    </a>
                                    <a href='#' onclick="cambioEstatusTasa({estatusVal},{indice});" 
                                    style='text-decoration:none;'>
                                        <img src='images/{nombreArchivo}.png' border='0' width='20' height='20' alt='{titleEstatus}' 
                                        title='{titleEstatus}'>
                                    </a>
                                </td>
                                <input type='hidden' name='idiva_{indice}' id='idiva_{indice}' value='{idIva}'>
                            </tr>
                            <!-- END BLOCK : registros -->
                        </tbody>
                    </table>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
                </div> <!-- content -->
                <link rel='stylesheet' href='css/jquery.dataTables.css'>
                <script src='js/jquery.dataTables.js'></script>
                <script language='javascript'>
                    $(document).ready(function() {
                        $('#tabla-contenido').dataTable({
                            "iDisplayLength": 10,
                            "oLanguage": {
                               "sInfo": "Mostrando _START_ de _END_ Registros - Total de _TOTAL_ Registros",
                               "sLengthMenu": "Mostrar _MENU_ Registros",
                               "sEmptyTable": "No hay registros que mostrar"
                            }
                        });
                    });
                    $(document).on({
                        ajaxStart: function(){
                            $("body").addClass("loading");
                        },
                        ajaxStop: function(){
                            $("body").removeClass("loading");
                        }
                    });
                </script>
                <div class="modal"></div>
            