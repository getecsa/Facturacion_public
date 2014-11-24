<!--adminMonedas.inc Plantilla que muestra la tabla de las Monedas registradas. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Monedas</h2>
                    <br>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <input type='button' name='agregaMoneda' value='Nueva Moneda' 
                    onclick="location.href='admin.php?mod=monedas&acc=form';" style='margin-left:auto;margin-right:auto;display:block;'>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Moneda</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- START BLOCK : registros -->
                            <tr>
                                <td>{indice}</td><td>{moneda}</td><td>{estatus}</td>
                                <td style='text-align:center;'>
                                    <a href='#' onclick="editarMoneda({indice});" style='text-decoration:none;'>
                                        <img src='images/edit.png' border='0' width='20' height='20' alt='Editar' title='Editar'>
                                    </a>
                                    <a href='#' onclick="cambioEstatusMoneda({estatusVal},{indice});" 
                                    style='text-decoration:none;'>
                                        <img src='images/{nombreArchivo}.png' border='0' width='20' height='20' alt='{titleEstatus}' 
                                        title='{titleEstatus}'>
                                    </a>
                                </td>
                                <input type='hidden' name='idmoneda_{indice}' id='idmoneda_{indice}' value='{idMoneda}'>
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
                               "sInfo": "Mostrando _START_ de _END_ Monedas - Total de _TOTAL_ Monedas",
                               "sLengthMenu": "Mostrar _MENU_ Monedas",
                               "sEmptyTable": "No hay registros de Monedas que mostrar"
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
            