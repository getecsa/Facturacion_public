<!--adminIvaForm.inc Plantilla que muestra el formulario para crear o editar una Tasa de IVA. -->
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
                            <th>Nombre Tasa:</th><td><input type='text' name='nombreTasa' id='nombreTasa' maxlength='45' 
                            value='{nombreTasa}' style='width:250px;' placeholder = 'Escribir Nombre de Tasa'></td>
                        </tr>
                        <tr>
                            <th>Valor Tasa:</th><td><input type='number' name='valorTasa' id='valorTasa' value='{valorTasa}' 
                            style='width:250px;' placeholder = 'Escribir Valor de Tasa'></td>
                        </tr>
                    </table>
                    <br>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
                    <input type='hidden' name='idIva' id='idIva' value='{idIva}'>
                    <input type='button' name='btnAtras' value='Cancelar' 
                    onclick="location.href='admin.php?mod=iva&acc=con';" style='margin-left:400px;'>
                    <input type='button' name='btnGuardar' value='Guardar' onclick='return validarTasasForm();' 
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
