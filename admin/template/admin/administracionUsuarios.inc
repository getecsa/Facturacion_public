<!--administracionUsuarios.inc Plantilla que muestra la tabla con los Usuarios Registrados. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Usuarios</h2>
                    <br>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <input type='button' name='agregaUsuario' value='Nuevo Usuario' 
                    onclick="location.href='admin.php?mod=users&acc=form';" style='margin-left:auto;margin-right:auto;display:block;'>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Mail</th>
                                <th>Área</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- START BLOCK : registros -->
                            <tr>
                                <td>{indice}</td><td>{nombre}</td><td>{usuario}</td><td>{email}</td><td>{area}</td><td>{estatus}</td>
                                <td style='text-align:center;'>
                                    <a href='#' onclick="editarUsuario({indice});" style='text-decoration:none;'>
                                        <img src='images/edit.png' border='0' width='20' height='20' alt='Editar' title='Editar'>
                                    </a>
                                    <a href='#' onclick="cambioEstatusUsuario({estatusVal},{indice});" 
                                    style='text-decoration:none;'>
                                        <img src='images/{nombreArchivo}.png' border='0' width='20' height='20' alt='{titleEstatus}' 
                                        title='{titleEstatus}'>
                                    </a>
                                </td>
                                <input type='hidden' name='iduser_{indice}' id='iduser_{indice}' value='{id}'>
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
                               "sInfo": "Mostrando _START_ de _END_ Usuarios - Total de _TOTAL_ Usuarios",
                               "sLengthMenu": "Mostrar _MENU_ Usuarios",
                               "sEmptyTable": "No hay registros de Usuarios que mostrar"
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
            