$(document).ready(function(){

    // funcion para cambio de select en solicitud 
    $("#cboClientes").change(function() {
        // obtenemos el valor seleccionado
        var cliente = $(this).val();
        // si es 0, no es un cliente
        if(cliente > 0)
        {
            //creamos un objeto JSON
            var datos = {
                idCliente : $(this).val()  
            };
            // utilizamos la función post, para hacer una llamada AJAX
            $.post("pages/documentos.php", datos, function(documentos) {
                // obtenemos el combo de documentos
                var $comboDocumentos = $("#cboDocumentos");
                // lo vaciamos
                $comboDocumentos.empty();
                // iteramos a través del arreglo
                $.each(documentos, function(index, documento) {
                    // agregamos opciones al combo
                    $comboDocumentos.append("<option value="+documento.id+">" + documento.nombre + "</option>");
                });
            }, 'json');
        }
        else
        {
            var $comboDocumentos = $("#cboDocumentos");
            $comboDocumentos.empty();
            $comboDocumentos.append("<option>Seleccione un Documento</option>");
        }
    });

    
    //funcion para refactura 
    $("#cboDocumentos").change(function() {
        // obtenemos el valor seleccionado
        var documentos = $(this).val();
      if((documentos==3) || (documentos==4)){
        //$(".sol_oculto").css("display","block");
        $(".sol_oculto").show();
      }
      else {
       $(".sol_oculto").css("display","none");
      
      }

    });

    //funcion para action solicitud
    $("#cboDocumentos").change(function() {
         var documentos = $(this).val();
            if(documentos==1){
              $('#nueva_solicitud').attr('action', 'homepage.php?id=nueva_factura');
            }

            if(documentos==2){
              $('#nueva_solicitud').attr('action', 'homepage.php?id=nueva_nota');
            }

            if(documentos==3){
              $('#nueva_solicitud').attr('action', 'homepage.php?id=refactura_con_cambio');
            }

            if(documentos==4){
              $('#nueva_solicitud').attr('action', 'homepage.php?id=refactura_sin_cambio');
            }
    });
    //funcion submit nueva factura pro regresar
            $('#submit_return_nf').click(function(){
              $('#nueva_factura').attr('action', 'homepage.php?id=nueva_factura');
              });

            $('#submit_return_nc').click(function(){
              $('#nueva_nota').attr('action', 'homepage.php?id=nueva_nota');
              }); 
    
            $('#submit_return_re_cc').click(function(){
              $('#nueva_refactura_cc').attr('action', 'homepage.php?id=refactura_con_cambio');
              }); 
    
            $('#submit_return_re_sc').click(function(){
              $('#nueva_refactura_sc').attr('action', 'homepage.php?id=refactura_sin_cambio');
              }); 

    //funcion para agregar en facturacion

                var contenedor      = $("#agregar_detalle"); 
                var AddButton       = $("#agregar_campo_fac"); 
               
                var x = $("#agregar_detalle").length + 1;
                var FieldCount = x-1;
                var y = $("#num_return").val();
                
                if(y!=0){
                  FieldCount=parseFloat(FieldCount)+parseFloat(y)-1;
                  }
                
                
                $(AddButton).click(function (e)  
                {
                	                     
                            FieldCount++; 
                            $(contenedor).append('<tr class="add_factura"><td><input type="text" size="10" name="add_cont['+ FieldCount +'][0]"  placeholder="Codigo '+ FieldCount +'"/> </td><td><input type="text" name="add_cont['+ FieldCount +'][1]"  placeholder="Descripcion '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][2]" class="calcular_subtotal total_unidades"  placeholder="Unidades '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][3]" class="calcular_subtotal" placeholder="Precio '+ FieldCount +'"/></td><td><input type="text" size="10" name="add_cont['+ FieldCount +'][4]" readonly="readonly" class="suma_cargo"  placeholder="Cargo '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][5]" class="calcular_subtotal" placeholder="Descuento '+ FieldCount +'"/></td><td><input type="text" size="10" name="add_cont['+ FieldCount +'][6]"  readonly="readonly" class="suma_subtotal" placeholder="Subtotal '+ FieldCount +'"/><a href="#" class="eliminar">&times;</a></td></tr>');
                            $("#num_concepto").val(x);
                            x++; 
                     
                return false;
                });

                $("body").on("click",".eliminar", function(e){ 
                          if( x > 1 ) {
                                  $(this).parent().parent().remove();
                                  FieldCount--;
                                  x--;

                                  $("#num_concepto").val(x-1);
                            
                          }
                  return false;
                  });


 // calculamos el total de todos los grupos


var total_cargo = 0;
var total_sub=0;
var total_subtotal=0;
var descuento=0;

            //funcion para sumar en factura los subtotales
            $( "#agregar_detalle" ).click(function() {

                     $(".add_factura").keyup(function()
                         {       
                     var unidad=$(this).find("td:eq(2) > input").val();  
                     var unitario=$(this).find("td:eq(3) > input").val(); 
                     var descuento=$(this).find("td:eq(5) > input").val(); 
                     total_cargo=unidad*unitario; 
                     total_sub=total_cargo-descuento;
                    $(this).find("td:eq(4) > input").val(total_cargo);
                    $(this).find("td:eq(6) > input").val(total_sub);

                          });


                    $( ".calcular_subtotal" ).blur(function() {
                        
                           //alert($(".suma_subtotal").val());
                       total_subtotal = total_subtotal + total_sub;
                       $(".total_subtotal").html(total_subtotal);

                     });




/*
                            $(".suma_subtotal").each(function(i){


                                var n = parseFloat(this.value);
                                if(!isNaN(n))
                                total_subtotal += n;

*/
                               /*}); console.log(total_subtotal);
                                    $(".total_subtotal").html(total_subtotal);*/


               });

//funcion campo fecha

          jQuery(function($){
              $.datepicker.regional['es'] = {
                  closeText: 'Cerrar',
                  prevText: '&#x3c;Ant',
                  nextText: 'Sig&#x3e;',
                  currentText: 'Hoy',
                  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                  'Jul','Ago','Sep','Oct','Nov','Dic'],
                  dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                  dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                  weekHeader: 'Sm',
                  dateFormat: 'yy/mm/dd',
                  firstDay: 1,
                  isRTL: false,
                  showMonthAfterYear: false,
                  yearSuffix: ''};
              $.datepicker.setDefaults($.datepicker.regional['es']);
          });    
           
          $(document).ready(function() {
             $("#fecha_emision_nc").datepicker();
             $("#fecha_emision_nc2").datepicker();
           });
//fin funcion fecha

}); 

