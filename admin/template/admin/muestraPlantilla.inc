<!-- muestraPlantilla.inc Plantilla para mostrar la Plantilla del Correo. -->
                <div class='content'>
                    <h2>{titulo}</h2>
                    <div id='msg-notif-form' style='display:none;max-width:830px;'></div>
                    <br>
                    <textarea class="jqte" name='text-area' id='text-area'>{texto}</textarea>
                    <input type='button' name='btnSve' value='Guardar' onclick="return guardaPlantilla('{opc}');" 
                    style='margin-left:390px;'>
                </div> <!-- content -->
            </div> <!-- contenedor -->
        </form>
        <link type="text/css" rel="stylesheet" href="css/jquery-te-1.4.0.css">
        <script type="text/javascript" src="js/jquery-te-1.4.0.min.js"></script>
        <script language='javascript'>
            $('.jqte').jqte();
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