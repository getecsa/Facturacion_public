<!-- muestraReporte.inc Plantilla que muestra el Reporte generado en base a los criterios del Usuario. -->
                        <h1 class='h1_header'>Reportes de SLA's</h1>
                    </div> <!-- header -->
                    <div class='content'>
                        <input type='button' onclick="location.href='reportes.php?mod=reportes&acc=form';" value='Otra Consulta' 
                        style='margin-bottom:30px;'>
                        <table class='gridview'>
                            <thead>
                                <tr>
                                    <th>Área</th><th>Indicador</th><th>Solicitudes</th><th>En SLA</th><th>Fuera SLA</th>
                                    <th>Objetivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan='2'>{nombreArea}</td>
                                <!-- START BLOCK : registros -->
                                    <td>{indicador}</td><td>{numSolicitudes}</td><td>{enSLA}</td>
                                    <td>{fueraSLA}</td>
                                    <td style='background-color:{semaforo};color:{colorText};text-align:center;'>{objetivo}</td>
                                </tr>
                                <!-- END BLOCK : registros -->
                            </tbody>
                        </table>
                        <br>
                        <input type='button' onclick="location.href='reportes.php?mod=reportes&acc=form';" value='Otra Consulta' 
                        style='margin-top:30px;'>
                    </div> <!-- content -->
                </div> <!-- contenedor -->
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