<!-- index.inc -->
        <title>{tituloVentana}</title>
    </head>
    <body>
        <form id='form1' name='acceso'>
            <div id='divNotificacion'>
                <div class='contenedor'>
                    <div class='header'>
                        <img alt='Movistar' class='logotipo' src='images/logo.png'>
                        <h1>{nombreProyecto}</h1>
                    </div>
                    <div class='content'>
                        <div id='msg-notif-form' style='display:none;'></div>
                        <br>
                        <div class='login'>
                            <h2>Login</h2>
                            <img src='images/candado.jpg' alt='Login' >
                            <p>
                                <table class='form'>
                                    <tr>
                                        <td><label for='usuario'>Usuario</label></td>
                                        <td>
                                            <input id='usuario' name='usuario' type='text' autofocus maxlength='10'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for='login_pass' >Contraseña</label></td>
                                        <td><input id='login_pass' type='password' name='password' maxlength='11'></td>
                                    </tr>
                                    <tr>
                                        <td><label for='login_submit'></label></td>
                                        <td><input id='login_submit' type='button' value='Ingresar' 
                                        onclick='return validarInicioSesion();' style='margin-left:95px;margin-top:25px;'></td>
                                    </tr>
                                </table>
                            </p>
                        </div> <!-- login -->
                    </div> <!-- content -->
                </div> <!-- contenedor -->
