<!--adminPlantillasCorreoForm.inc Plantilla que muestra las diferentes plantillas de Correo para <img src='images/edit.png' border='0' width='20' height='20'>. -->
                    <h1>Plantillas del Correo Electrónico</h1>
                </div> <!-- header -->
                <div class='content'>
                    <table class='gridview' style='width:40%;'>
                        <tr>
                            <th>#</th><th>Nombre Plantilla</th><th>Acciones</th>
                        </tr>
                        <tr>
                            <td>1</td><td>Correo de Evaluación Aceptada</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=evalaceptada' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td><td>Correo de Evaluación Rechazada</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=evalrechazada' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td><td>Correo de Evaluación Pendiente</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=evalpendiente' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td><td>Correo de Pendiente Respuesta Aceptada</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=penresacept' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td><td>Correo de Pendiente Respuesta Rechazada</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=penresrech' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td><td>Correo de Cobranza en Tiempo</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=cobranzatiempo' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td><td>Correo de Cobranza Demorado</td>
                            <td style='text-align:center;'>
                                <a class='fancybox' href='admin.php?mod=tplcorreo&acc=edit&opc=cobranzademora' 
                                style='text-decoration:none;font-size:11px;'>
                                <img src='images/edit.png' border='0' width='20' height='20' title='Editar Plantilla'>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div> <!-- content -->
            </div> <!-- contenedor -->
            <div class="footer">
                <p>
                    Gestor de Exportaciones y Reversiones. Todos los Derechos Reservados &copy;<br>
                    Resolución Mínima 1280 x 800px
                </p>
            </div> <!-- footer -->
        </form>
        <script type="text/javascript" src="js/jquery.fancybox.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen">
        <script language='javascript'>
            $(document).ready(function() {
                $(".fancybox").fancybox({
                    closeBtn    : true,
                    fitToView   : true,
                    openEffect  : 'elastic',
                    closeEffect : 'elastic',
                    width: '85%',
                    height: '100%',
                    href: $(this).attr('href'),
                    'window.open': $(this).attr('href'),
                    type: 'iframe',
                    helpers : {
                        overlay : {
                            closeClick : false,
                            locked     : false
                        }
                    }
                });
            });
        </script>
    </body>
</html>