<!--adminPermisosSelPerfil.inc Plantilla que muestra el formulario para seleccionar los Permisos del Perfil. -->
                    <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Permisos Documentos</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <table class='gridview' id='tabla-contenido' style='width:40%;'>
                        <tr>
                            <th style='width:180px;'>Perfil a Modificar: </th>
                            <td>
                                <select name='perfilSel' style='width:200px;' onchange='return validarPerfilSel();'>
                                    <option value='0'>Seleccione...</option>
                                    <!-- START BLOCK : registros -->
                                    <option value='{idPerfil}'>{nombrePerfil}</option>
                                    <!-- END BLOCK : registros -->
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type='hidden' name='acc' id='acc' value='{acc}'>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
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
