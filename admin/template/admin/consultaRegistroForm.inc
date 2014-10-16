<!-- consultaRegistroForm.inc Plantilla para mostrar el formulario para conocer la evaluación y emitir una decisión de Exportación -->
            <div class='content'>
                <h2>Folio ABD: {folioAbd}</h2>
                <table class='gridview'>
                    <tr>
                        <th>Nombre del Cliente</th>
                        <th>Fecha de Inicio de Contrato</th>
                        <th>Fecha de Fin de Contrato</th>
                        <th>Fecha de Emisión de Factura</th>
                        <th>Fecha de Corte</th>
                    </tr>
                    <tr>
                        <td>{nombreCliente}</td>
                        <td>{fechaInicioContrato}</td>
                        <td>{fechaFinContrato}</td>
                        <td>{fechaEmisionFactura}</td>
                        <td>{fechaCorte}</td>
                    </tr>
                </table>
                <table class='gridview'>
                    <tr>
                        <th>Estado de la Línea</th>
                        <th>Clave de Plan Comercial</th>
                        <th>Fecha de Alta</th>
                        <th>Segmento</th>
                        <th>CC</th>
                        <th>Tipo de ABD</th>
                        <th>No. de DN</th>
                        <th>Estado SCL</th>
                    </tr>
                    <tr>
                        <td>{estadoLinea}</td>
                        <td>{clavePlan}</td>
                        <td>{fechaAlta}</td>
                        <td>{segmento}</td>
                        <td>{cc}</td>
                        <td>{tipoAbd}</td>
                        <td>{noDn}</td>
                        <td>{estadoScl}</td>
                    </tr>
                </table>
                <table class='gridview'>
                    <tr>
                        <th>Justificación</th>
                    </tr>
                    <!-- START BLOCK : justificaciones -->
                    <tr>
                        <td>
                            <input type='checkbox' disabled {checkedJust}>{descripcion}</td>
                    </tr>
                    <!-- END BLOCK : justificaciones -->
                </table>
                <table class='gridview'>
                    <tr>
                        <th>Evaluación</th>
                    </tr>
                    <tr>
                        <td>
                            <input type='checkbox' disabled {checkedAceptado}>Aceptado
                            <input type='checkbox' disabled {checkedRechazado}>Rechazado
                            <input type='checkbox' disabled {checkedPendiente}>Pendiente
                            <input type='hidden' id='estatusEval' value='{estatusEval}'>
                        </td>
                    </tr>
                </table>
                <table class='gridview'>
                    <tr>
                        <th>¿Se va a Exportar?</th><th>Fecha FVC</th>
                    </tr>
                    <tr>
                        <td>
                            Sí <input type='radio' name='decision' id='decision_s' value='1' 
                            onclick='document.form1.fechaFvc.disabled = false;'>
                            No <input type='radio' name='decision' id='decision_n' value='2' 
                            onclick="document.form1.fechaFvc.disabled = true;document.form1.fechaFvc.value = '';">
                        </td>
                        <td>
                            <input type='text' id='fechaFvc' name='fechaFvc' disabled>
                        </td>
                    </tr>
                </table>
                <div id='msg-notif-form' style='display:none;max-width:650px;margin-top:10px;'></div>
                <div style='margin-left:710px;margin-top:15px;'>
                    <input type='button' id='cancelar' value='Cancelar' onclick="return validarRespuestaFolio(this.id,
                    {folioAbd});">
                    <input type='button' id='guardar' value='Guardar' onclick="return validarRespuestaFolio(this.id,
                    {folioAbd});">
                </div>
            </div> <!-- content -->
        </div> <!-- contenedor -->
        <link rel='stylesheet' href='css/redmond/jquery-ui-1.8.16.custom.css'/>
        <script src='js/jquery.ui.datepicker-es.js'></script>
        <script language='javascript'>
            $(document).ready(function(){
                var hoy = new Date();
                $('#fechaFvc').datepicker({
                    showOn: 'both',
                    buttonImage: 'images/calendar.png',
                    buttonImageOnly: true,
                    changeYear: true,
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: hoy,
                    dateFormat: 'dd/mm/yy',
                });
            });
        </script>
        <script>
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
    </body>
</html>