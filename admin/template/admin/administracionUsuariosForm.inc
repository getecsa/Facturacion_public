<!--administracionUsuariosForm.inc Plantilla que muestra el formulario para crear o editar un Usuario. -->
                    <h1>Administración de Usuarios</h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>{tituloPagina}</h2>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <br>
                    <br>
                    <br>
                    <table class='gridview' id='tabla-contenido'>
                        <tr>
                            <th style='width:180px;'>Perfil: </th>
                            <td>
                                <select name='perfilSel' style='width:200px;'>
                                    <option value='0'>Seleccione...</option>
                                    <option value='1' {selectedAdmin}>Administrador</option>
                                    <option value='2' {selectedCobr}>Cobranza</option>
                                    <option value='3' {selectedDf}>Exportaciones D.F.</option>
                                    <option value='4' {selectedMty}>Exportaciones Mty.</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Nombre:</th><td><input type='text' name='nombre' maxlength='30' value='{nombre}' 
                            style='width:190px;' placeholder = 'Escribir Nombre'></td>
                        </tr>
                        <tr>
                            <th>Usuario:</th><td><input type='text' name='usuario' maxlength='15' value='{usuario}' 
                            style='width:190px;text-transform:uppercase;' {readOnlyUser} 
                            placeholder = 'Escribir el Usuario (MRT)'></td>
                        </tr>
                        <tr>
                            <th>Contraseña:</th><td><input type='password' name='pass' maxlength='10' 
                            style='width:190px;' placeholder = 'Longitud de 10 carácteres'></td>
                        </tr>
                        <tr>
                            <th>Volver a Escribir Contraseña:</th><td><input type='password' name='passVol' 
                            maxlength='10' style='width:190px;'></td>
                        </tr>
                    </table>
                    <br>
                    <input type='hidden' name='acc' id='acc' value='{acc}'>
                    <input type='hidden' name='idUser' id='idUser' value='{idUser}'>
                    <input type='button' name='btnAtras' value='Cancelar' 
                    onclick="location.href='admin.php?mod=users&acc=con';" style='margin-left:400px;'>
                    <input type='button' name='btnGuardar' value='Guardar' onclick='return validarUsuarioForm();' 
                    style='margin-left:20px;'>
                </div> <!-- content -->
            </div> <!-- contenedor -->
            <div class="footer">
                <p>
                    Gestor de Exportaciones y Reversiones. Todos los Derechos Reservados &copy;<br>
                    Resolución Mínima 1280 x 800px
                </p>
            </div> <!-- footer -->
        </form>
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
    </body>
</html>