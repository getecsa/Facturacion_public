<!--adminAreas.inc Plantilla que muestra la tabla de Áreas registradas. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Áreas</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br><br>
                    <input type='button' name='agregaArea' value='Nueva Área' 
                    onclick="location.href='admin.php?mod=areas&acc=form&opc=new';" style='margin-left:auto;margin-right:auto;
                    display:block;'>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre Área</th>
                                <th>Tipo</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- START BLOCK : registros -->
                            <tr>
                                <td>{indice}</td><td>{nombreArea}</td><td>{tipoArea}</td><td>{estatus}</td>
                                <td style='text-align:center;'>
                                    <a href='#' onclick="editarArea({indice});" style='text-decoration:none;'>
                                        <img src='images/edit.png' border='0' width='20' height='20' alt='Editar Área' title='Editar Área'>
                                    </a>
                                    <a href='#' onclick="cambioEstatusArea({estatusVal},{indice});" 
                                    style='text-decoration:none;'>
                                        <img src='images/{nombreArchivo}.png' border='0' width='20' height='20' alt='{titleEstatus}' 
                                        title='{titleEstatus}'>
                                    </a>
                                </td>
                                <input type='hidden' name='idarea_{indice}' id='idarea_{indice}' value='{idArea}'>
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
                               "sInfo": "Mostrando _START_ de _END_ Áreas - Total de _TOTAL_ Áreas",
                               "sLengthMenu": "Mostrar _MENU_ Áreas",
                               "sEmptyTable": "No hay registros de Áreas que mostrar"
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
            