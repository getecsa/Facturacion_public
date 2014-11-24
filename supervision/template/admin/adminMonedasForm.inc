<!--adminMonedasForm.inc Plantilla que muestra el formulario para crear o editar una Moneda. -->
                    <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>{tituloPagina}</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <table class='gridview' id='tabla-contenido'>
                        <tr>
                            <th>Nombre Moneda:</th><td><input type='text' name='nombreMoneda' id='nombreMoneda' maxlength='5' 
                            value='{nombreMoneda}' style='width:250px;' placeholder = 'Escribir Nombre de Moneda'></td>
                        </tr>
                    </table>
                    <br>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
                    <input type='hidden' name='idMoneda' id='idMoneda' value='{idMoneda}'>
                    <input type='button' name='btnAtras' value='Cancelar' 
                    onclick="location.href='admin.php?mod=monedas&acc=con';" style='margin-left:400px;'>
                    <input type='button' name='btnGuardar' value='Guardar' onclick='return validarMonedasForm();' 
                    style='margin-left:20px;'>
                </div> <!-- content -->
                <script language='javascript'>
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
