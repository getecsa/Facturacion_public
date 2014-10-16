<!-- consultaHistoricoFolio.inc Plantilla para mostrar la Información del Histórico del Folio Consultado. -->
                <h1>{titulo}</h1>
            </div> <!-- header -->
            <div class='content'>
                <h2>Historial del Folio ABD: {folioAbd}</h2>
                <br>
                <table id='tabla-contenido' class='gridview'>
                    <thead>
                        <tr>
                            <th style='width:20px;'>#</th>
                            <th style='width:70px;'>Folio ABD</th>
                            <th style='width:55px;'>Tipo ABD</th>
                            <th style='width:60px;'>No. de Dn's</th>
                            <th style='width:90px;'>Perfil</th>
                            <th style='width:90px;'>Usuario</th>
                            <th style='width:90px;'>Bandeja</th>
                            <th style='width:105px;'>Fecha de Operación</th>
                            <th style='width:120px;'>Justificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- START BLOCK : registros -->
                        <tr>
                            <td style='text-align:right;'>{num_i}</td>
                            <td style='text-align:right;'>{folioAbd}</td>
                            <td>{tipoAbd}</td>
                            <td style='text-align:right;'>{noDn}</td>
                            <td>{perfil}</td>
                            <td>{usuario}</td>
                            <td>{nombreBandeja}</td>
                            <td>{fechaOperacion}</td>
                            <td>{justificacion}</td>
                        </tr>
                        <!-- END BLOCK : registros -->
                    </tbody>
                </table>
            </div> <!-- content -->
        </div> <!-- contenedor -->
        <div class="footer">
            <p>
                Gestor de Exportaciones y Reversiones. Todos los Derechos Reservados &copy;<br>
                Resolución Mínima 1280 x 800px
            </p>
        </div> <!-- footer -->
        <link rel='stylesheet' href='css/jquery.dataTables.css'>
        <script src='js/jquery.dataTables.js'></script>
        <script language='javascript'>
            $(document).ready(function() {
                $('#tabla-contenido').dataTable({
                    "iDisplayLength": 10,
                    "oLanguage": {
                       "sInfo": "Mostrando _START_ de _END_ Registros - Total de _TOTAL_ Registros",
                       "sLengthMenu": "Mostrar _MENU_ Registros",
                       "sEmptyTable": "No hay registros que mostrar"
                    }
                });
            });
        </script>
    </body>
</html>