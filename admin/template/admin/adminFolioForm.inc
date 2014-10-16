<!-- adminFolioForm.inc Plantilla para mostrar la Forma para Consultar un Folio. -->
                    <h1>{titulo}</h1>
                </div> <!-- header -->
                <div class='content'>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <p style='margin-left:50px;'>
                        <label>Folio ABD </label>
                        <input type='text' name='folio' placeholder='Escribir Folio ABD' 
                        style='width:120px;margin-left:10px;' maxlength='10'>
                        <input type='button' name='btnAction' value='Enviar' onclick="return validarEnviar('{mod}');">
                    </p>
                </div> <!-- content -->
            </div> <!-- contenedor -->
            <div class="footer">
                <p>
                    Gestor de Exportaciones y Reversiones. Todos los Derechos Reservados &copy;<br>
                    Resolución Mínima 1280 x 800px
                </p>
            </div> <!-- footer -->
        </form>
    </body>
</html>