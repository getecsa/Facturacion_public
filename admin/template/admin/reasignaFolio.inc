<!-- reasignaFolio.inc Plantilla para mostrar la Reasignación de un Folio. -->
                    <h1>{titulo}</h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Folio ABD {folioAbd}</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <table class='gridview'>
                        <tr>
                            <th style='width:85px;'>Perfil Actual</th>
                            <th style='width:85px;'>Perfil Destino</th>
                            <th style='width:90px;'>Bandeja Actual</th>
                            <th style='width:90px;'>Bandeja Destino</th>
                            <th style='width:120px;'>Acción</th>
                        </tr>
                        <tr>
                            <td>{perfilActual}</td>
                            <input type='hidden' id='ultimaBandejaVal' value='{ultimaBandejaVal}'>
                            <td style='text-align:center;'>
                                <select name='perfilSel' id='perfilSel' onchange='validaPerfilSel();'>
                                    <option value='0'>Seleccione...</option>
                                    <!-- START BLOCK : perfiles -->
                                    <option value='{valuePerfil}'>{nombrePerfil}</option>
                                    <!-- END BLOCK : perfiles -->
                                </select>
                            </td>
                            <td>{bandejaActual}</td>
                            <td style='text-align:center;'>
                                <select name='bandejaSel' id='bandejaSel' onchange='validaBandejaSel();'>
                                    <option value='0'>Seleccione...</option>
                                    <!-- START BLOCK : bandejas -->
                                    <option value='{valueBandeja}'>{nombreBandeja}</option>
                                    <!-- END BLOCK : bandejas -->
                                </select>
                            </td>
                            <td>
                                <input type='button' name='btnCancelar' value='Cancelar' 
                                onclick="validarReasigna('cancelar','reasigna','{folioAbd}');">
                                <input type='button' name='btnAccion' value='Reasignar' 
                                onclick="validarReasigna('reasigna','reasigna','{folioAbd}');">
                            </td>
                        </tr>
                    </table>
                </div> <!-- content -->
            </div> <!-- contenedor -->
            <div class="footer">
                <p>
                    Gestor de Exportaciones y Reversiones. Todos los Derechos Reservados &copy;<br>
                    Resolución Mínima 1280 x 800px
                </p>
            </div> <!-- footer -->
        </form>
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