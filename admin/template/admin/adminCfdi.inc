<!--adminCfdi.inc Plantilla que muestra la tabla de los catálogos CFDI registrados. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>CFDI</h2>
                    <br>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <input type='button' name='agregaCfdi' value='Nuevo Cfdi' 
                    onclick="location.href='admin.php?mod=cfdi&acc=form';" style='margin-left:auto;margin-right:auto;display:block;'>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código de Catálogo</th>
                                <th>Catálogo</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- START BLOCK : registros -->
                            <tr>
                                <td>{indice}</td><td>{idCfdi}</td><td>{catalogoCfdi}</td><td>{estatus}</td>
                                <td style='text-align:center;'>
                                    <a href='#' onclick="editarArea({indice});" style='text-decoration:none;'>
                                        <img src='images/edit.png' border='0' width='20' height='20' alt='Editar' title='Editar'>
                                    </a>
                                    <a href='#' onclick="cambioEstatusArea({estatusVal},{indice});" 
                                    style='text-decoration:none;'>
                                        <img src='images/{nombreArchivo}.png' border='0' width='20' height='20' alt='{titleEstatus}' 
                                        title='{titleEstatus}'>
                                    </a>
                                </td>
                                <input type='hidden' name='idcfdi_{indice}' id='idcfdi_{indice}' value='{id}'>
                            </tr>
                            <!-- END BLOCK : registros -->
                        </tbody>
                    </table>
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
            