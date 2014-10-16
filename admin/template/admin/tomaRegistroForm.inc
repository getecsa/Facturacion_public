<!-- tomaRegistroForm.inc Plantilla para mostrar el formulario para tomar de Solicitud -->
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
                            <input type='checkbox' name='justifica_{indice}' id='justifica_{indice}' value='{id}' 
                            {disabled} {checkedJus}> {descripcion}
                        </td>
                    </tr>
                    <!-- END BLOCK : justificaciones -->
                </table>
                <table class='gridview'>
                    <tr>
                        <th>Evaluación</th>
                    </tr>
                    <tr>
                        <td>
                            <input type='checkbox' name='decision' id='decision_1' value='1' onchange="
                            validarEvaluacion(this.id);"> Aceptado
                            <input type='checkbox' name='decision' id='decision_2' value='2' onchange="
                            validarEvaluacion(this.id);"> Rechazado
                            <input type='checkbox' name='decision' id='decision_3' value='3' onchange="
                            validarEvaluacion(this.id);" {disabledPendiente}> Pendiente
                        </td>
                    </tr>
                </table>
                <div id='msg-notif-form' style='display:none;max-width:650px;margin-top:10px;'></div>
                <div style='margin-left:710px;margin-top:15px;'>
                    <input type='button' name='btnCancelar' value='Cancelar' 
                    onclick="return validarTomaFolio('cancelar',{folioAbd});">
                    <input type='button' name='btnAceptar' value='Guardar' 
                    onclick="return validarTomaFolio('guardar',{folioAbd});">
                </div>
            </div> <!-- content -->
        </div> <!-- contenedor -->
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