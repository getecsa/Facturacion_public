<!--adminAreasForm.inc Plantilla que muestra el formulario para crear o editar una Área. -->
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
                            <th>Nombre Área:</th><td><input type='text' name='nombreArea' id='nombreArea' maxlength='45' 
                            value='{nombreArea}' style='width:250px;' placeholder = 'Escribir Nombre de Área'></td>
                        </tr>
                        <tr>
                            <th>Tipo Área:</th>
                            <td>
                                <select name='tipoArea' id='tipoArea' style='width:260px;'>
                                    <option value='-1'>Seleccione...</option>
                                    <!-- START BLOCK : registros -->
                                    <option value='{idTipoArea}' {selectedTipoArea}>{nombreTipoArea}</option>
                                    <!-- END BLOCK : registros -->
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
                    <input type='hidden' name='idArea' id='idArea' value='{idArea}'>
                    <input type='button' name='btnAtras' value='Cancelar' 
                    onclick="location.href='admin.php?mod=areas&acc=con';" style='margin-left:400px;'>
                    <input type='button' name='btnGuardar' value='Guardar' onclick='return validarAreasForm();' 
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
