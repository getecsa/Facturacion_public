<!--adminPermisosPerfil.inc Plantilla que muestra la tabla de los Permisos del Perfil. -->
                <h1></h1>
                </div> <!-- header -->
                <div class='content'>
                    <h2>Permisos de {perfilSel}</h2>
                    <br>
                    <div id='msg-notif-form' style='display:none;'></div>
                    <table class='gridview' id='tabla-contenido'>
                        <thead>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type='hidden' name='acc' id='acc' value='{acc}'>
                    <input type='hidden' name='mod' id='mod' value='{mod}'>
                    <input type='hidden' name='idPerfil' id='idPerfil' value='{idPerfil}'>
                </div> <!-- content -->
                <link rel='stylesheet' href='css/jquery.dataTables.css'>
                <script src='js/jquery.dataTables.js'></script>
            