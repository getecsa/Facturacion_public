<!-- desbloqueoFolio.inc Plantilla para mostrar la Información del Folio Consultado para Desbloqueo. -->
                    <h1>{titulo}</h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Folio ABD {folioAbd}</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <table class='gridview' style='width:50%;margin-left:auto;margin-right:auto;'>
                        <tr>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                        <tr>
                            <td style='text-align:center;'><span class='{estatusClass}'>{estatus}</span></td>
                            <td style='text-align:center;'>
                                <input type='button' name='btnCancelar' value='Cancelar' 
                                onclick="validarDesbloqueo('cancelar','desbloqueo','{folioAbd}');">
                                <input type='button' name='btnAccion' value='Desbloquear' 
                                onclick="validarDesbloqueo('desbloqueo','desbloqueo','{folioAbd}');">
                            </td>
                        </tr>
                    </table>
                    <input type='hidden' name='estatusBloqueo' value='{estatusVal}'>
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