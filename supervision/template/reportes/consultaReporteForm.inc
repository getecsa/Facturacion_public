<!-- consultaReporteForm.inc Plantilla que muestra el Inicio del Perfil de Supervisor por Área. -->
                        <h1 class='h1_header'>Reportes de SLA's</h1>
                    </div> <!-- header -->
                    <div class='content'>
                        <form id='formRep' name='formRep'>
                            <div class='column'>
                                <label for='fechaInicio'>Fecha Inicio:</label>
                                <input type='text' name='fechaInicio' id='fechaInicio' maxlength='10' style='width:240px;'>
                                <label for='fechaFin'>Fecha Fin:</label>
                                <input type='text' name='fechaFin' id='fechaFin' maxlength='10' style='width:240px;'>
                                <label for='areasSel'>Áreas:</label>
                                <select name='areasSel' id='areasSel' style='width:250px;'>
                                    <option value='0'>Seleccione...</option>
                                    <!-- START BLOCK : areas -->
                                    <option value='{codigoArea}'>{nombreArea}</option>
                                    <!-- END BLOCK : areas -->
                                </select>
                            </div>
                            <div class='column'>
                                <label for='slaSel'>SLA's:</label>
                                <select name='slaSel' id='slaSel' style='width:200px;'>
                                    <option value='0'>Seleccione...</option>
                                    <!-- START BLOCK : slas -->
                                    <option value='{codigoSla}'>{nombreSla}</option>
                                    <!-- END BLOCK : slas -->
                                </select>
                            </div>
                            <input type='hidden' name='acc' id='acc'>
                            <input type='button' name='btnConsultar' id='btnConsultar' value='Consultar' 
                            onclick='return validarReporteForm();'>
                            <div id='errorForm'>
                        </form>
                    </div> <!-- content -->
                </div> <!-- contenedor -->
                <link rel='stylesheet' href='css/redmond/jquery-ui-1.8.16.custom.css'/>
                <script src='js/jquery.ui.datepicker-es.js'></script>
                <script language='javascript'>
                    var hoy = new Date();
                    $(document).ready(function(){
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
                </script>