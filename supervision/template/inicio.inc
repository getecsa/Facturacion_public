<!-- inicio.inc Plantilla que muestra el Inicio del Perfil de Supervisor por Área. -->
                        <h1 class='h1_header'>Bandeja de {nombreArea}</h1>
                    </div> <!-- header -->
                    <div class='content'>
                        <form name='formBandeja' id='formBandeja'>
                            <div class='column'>
                                <label for='fechaInicio'>Fecha Inicio:</label>
                                <input type='text' name='fechaInicio' id='fechaInicio' maxlength='10' style='width:100px;'>
                                <label for='fechaFin'>Fecha Fin:</label>
                                <input type='text' name='fechaFin' id='fechaFin' maxlength='10' style='width:100px;'>
                                <input type='button' value='Consultar' id='btnConsulta' onclick='return validarBandejaFiltro();'>
                            </div>
                            <div class="datos_informacion" style='margin-top:30px;margin-bottom:30px;'>
                                <div class="datos_totales">
                                    <p>Total de solicitudes en Bandeja: <span>{totalSolicitudBandeja}</span></p> 
                                    <p>Total de solicitudes Liberadas: <span>{totalSolicitudLiberada}</span></p> 
                                    <p>Total de solicitudes Rechazadas: <span>{totalSolicitudRechazada}</span> </p> 
                                </div> <!-- datos_totales -->
                                <div class="datos_totales" style='margin-left:200px;'>
                                    <p>Total de solicitudes en Bandeja: <span>{totalSolicitudBandeja}</span></p> 
                                    <p>Total de solicitudes Liberadas: <span>{totalSolicitudLiberada}</span></p> 
                                    <p>Total de solicitudes Rechazadas: <span>{totalSolicitudRechazada}</span> </p> 
                                </div> <!-- datos_totales -->
                            </div> <!-- datos_informacion -->
                            <label for='tipoSolicitudSel'>Tipo Solicitud: </label>
                            <select name='tipoSolicitudSel' id='tipoSolicitudSel' style='width:200px;margin-bottom:30px;'>
                                <option value='0'>Seleccione...</option>
                                <!-- START BLOCK : tiposSolicitudes -->
                                <option value='{cveTipoSol}'>{descripTipoSolicitud}</option>
                                <!-- END BLOCK : tiposSolicitudes -->
                            </select>
                        </form>
                        <table class='gridview' id='tabla-contenido'>
                            <thead>
                                <tr>
                                    <th>ID</th><th>Solicitante</th><th>Área</th><th>Tipo de Solicitud</th><th>Fecha y Hora de Ingreso</th>
                                    <th>Fecha y Hora de Atención</th><th>Estado</th><th>Tiempo Espera</th><th>Usuario de Atención</th>
                                    <th>Fecha y Hora de Cambio de Estado</th><th>Tiempo de Atención</th><th>Tiempo Total Ingreso-Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- START BLOCK : registros -->
                                <tr class='{classEstatusTiempo}'>
                                    <td>{id}</td><td>{nombreSolicitante}</td><td>{nombreArea}</td><td>{tipoSolicitud}</td>
                                    <td>{fechaHoraIngreso}</td><td>{fechaHoraAtencion}</td><td>{estado}</td><td>{tiempoEspera}</td>
                                    <td>{usuarioAtencion}</td><td>{fechaHoraCambioEstado}</td><td>{tiempoAtencion}</td>
                                    <td>{tiempoTotal}</td>
                                </tr>
                                <!-- END BLOCK : registros -->
                            </tbody>
                        </table>
                    </div> <!-- content -->
                </div> <!-- contenedor -->
                <link rel='stylesheet' href='css/redmond/jquery-ui-1.8.16.custom.css'/>
                <script src='js/jquery.ui.datepicker-es.js'></script>
                <link rel='stylesheet' href='css/jquery.dataTables.css'>
                <script src='js/jquery.dataTables.js'></script>
                <script language='javascript'>
                	var hoy = new Date();
                    $(document).ready(function(){
                        $('#tabla-contenido').dataTable({
                            "iDisplayLength": 10,
                            "oLanguage": {
                                "sInfo": "Mostrando _START_ de _END_ Solicitudes - Total de _TOTAL_ Solicitudes",
                                "sLengthMenu": "Mostrar _MENU_ Solicitudes",
                                "sEmptyTable": "No hay Solicitudes que mostrar",
                                "sInfoEmpty": "Mostrando 0 de 0 de 0 Solicitudes",
                            }
                        });
                        $('#fechaInicio').datepicker({
                            showOn: 'both',
                            buttonImage: 'images/calendar.png',
                            buttonImageOnly: true,
                            changeYear: true,
                            changeMonth: true,
                            numberOfMonths: 1,
                            maxDate : hoy,
                            dateFormat: 'dd/mm/yy',
                        });
                        $('#fechaFin').datepicker({
                            showOn: 'both',
                            buttonImage: 'images/calendar.png',
                            buttonImageOnly: true,
                            changeYear: true,
                            changeMonth: true,
                            numberOfMonths: 1,
                            maxDate : hoy,
                            dateFormat: 'dd/mm/yy',
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