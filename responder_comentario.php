<?php
    include("configuracion.php");

$id_observacion=$_GET['id_observacion'];

	


?>
<div id="ver_folio">
    <br>
      <h2>Historial de folio</h2>
    <br>

    <table border=0>
    <tr>  
      <td class="title"></td>
      <td class="title"></td>
      <td class="title"></td>
      <td class="title"></td>
    </tr>
    </table>
<form action="#" method="POST">  
            <article class="detalle_historial">
                <ul>
                  <li class="title">Comentario:</li>
                  <li class="uno"><textarea name="comentario"></textarea></li>
                  <input type="hidden" name="bandera">
                  <input type="hidden" name="id_observacion" value="<?php echo $id_observacion; ?>">
                   <li class="uno"><input type="submit" value="Enviar"></li>
                </ul>

            </article>
</form>            
</div>