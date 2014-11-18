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
        switch (true){
            case (documentos==1):
                $(".sol_oculto").css("display","none");
                $(".sol_oculto_fac").css("display","none");
                $(".sol_oculto_cod").show();
                break;
            case (documentos==2):
                $(".sol_oculto").css("display","none");
                $(".sol_oculto_cod").css("display","none");
                $(".sol_oculto_fac").show();
                break;
            case (documentos >= 3 ):
                $(".sol_oculto_cod").show();
                $(".sol_oculto").show();
                $(".sol_oculto_fac").show();
                break;

           default:
                break;
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
                //console.log(x);
                var FieldCount = x-1;
                var y = $("#num_return").val();
                
                if(y!=0){
                  FieldCount=parseFloat(FieldCount)+parseFloat(y)-1;
                  }
                
                $(AddButton).click(function (e)  
                {
                            FieldCount++; 
                            //$(contenedor).append('<tr class="add_factura"><td><input type="text" size="10" name="add_cont['+ FieldCount +'][0]" class="add_cont['+ FieldCount +'][0]" placeholder="Codigo '+ FieldCount +'"/></td><td><input type="text" name="add_cont['+ FieldCount +'][1]"  placeholder="Descripcion '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][2]" class="calcular_subtotal total_unidades"  placeholder="Unidades '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][3]" class="calcular_subtotal" placeholder="Precio '+ FieldCount +'"/></td><td><input type="text" size="10" name="add_cont['+ FieldCount +'][4]" readonly="readonly" class="suma_cargo"  placeholder="Cargo '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][5]" class="calcular_subtotal" placeholder="Descuento '+ FieldCount +'"/></td><td><input type="text" size="10" name="add_cont['+ FieldCount +'][6]"  readonly="readonly" class="suma_subtotal" placeholder="Subtotal '+ FieldCount +'"/></td><td><a href="#" class="eliminar">&times;</a></td></tr>');
                            $(contenedor).append('<tr class="add_factura"><td><select id="add_cont'+ FieldCount +'0" name="add_cont['+ FieldCount +'][0]" class="descripcion_concepto" /></select></td><td><select id="add_cont'+ FieldCount +'1" name="add_cont['+ FieldCount +'][1]" class="descripcion_concepto" /></select></td><td><input type="text" size="9" maxlength="<?=$caracteres ?>" name="add_cont['+ FieldCount +'][7]" /></td><td class="calcular_subtotal"><input type="text" size="5" name="add_cont['+ FieldCount +'][2]" class="calcular_subtotal total_unidades"  placeholder="Unidades '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="9" name="add_cont['+ FieldCount +'][3]" class="calcular_subtotal" placeholder="Precio '+ FieldCount +'"/></td><td><input type="text" size="9" name="add_cont['+ FieldCount +'][4]" readonly="readonly" class="suma_cargo"  placeholder="Cargo '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="9" name="add_cont['+ FieldCount +'][5]" class="calcular_subtotal" placeholder="Descuento '+ FieldCount +'"/></td><td><input type="text" size="9" name="add_cont['+ FieldCount +'][6]"  readonly="readonly" class="suma_subtotal" placeholder="Subtotal '+ FieldCount +'"/></td><td><a href="#" class="eliminar"><span class="icon-close"></span></a></td></tr>');
                            $("#num_concepto").val(x);
                            $.fn.numConceptos('#add_cont'+ FieldCount +'0');
                            $.fn.txtConceptos('#add_cont'+ FieldCount +'1');
                            x++;
                    return false;

                });

                $("body").on("click",".eliminar", function(e){ 
                          if( x > 1 ) {
                                  $(this).parent().parent().remove();
                                  FieldCount--;
                                  x--;

                                  $("#num_concepto").val(x);
                            
                          }
                  return false;
                  });

//agregar campos en nota de credito

                var contenedor      = $("#agregar_detalle"); 
                var AddButton       = $("#agregar_campo_nota"); 
               
                var x = $("#agregar_detalle").length + 1;
                var FieldCount = x-1;
                var y = $("#num_return").val();
                
                if(y!=0){
                  FieldCount=parseFloat(FieldCount)+parseFloat(y)-1;
                  }
                
                
                $(AddButton).click(function (e)  
                {
                                       
                            FieldCount++; 
                            $(contenedor).append('<tr class="add_factura"><td><input type="text" size="10" name="add_cont['+ FieldCount +'][0]"  placeholder="Codigo '+ FieldCount +'"/> </td><td><input type="text" name="add_cont['+ FieldCount +'][1]" size="30"  placeholder="Descripcion '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][2]" placeholder="Unidades '+ FieldCount +'"/></td><td class="calcular_subtotal"><input type="text" size="10" name="add_cont['+ FieldCount +'][3]"  placeholder="Precio '+ FieldCount +'"/><a href="#" class="eliminar">&times;</a></td></tr>');
                      
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
                     var unidad=$(this).find("td:eq(3) > input").val();
                     var unitario=$(this).find("td:eq(4) > input").val();
                     var descuento=$(this).find("td:eq(6) > input").val();
                     total_cargo=unidad*unitario; 
                     total_sub=total_cargo-descuento;
                    $(this).find("td:eq(5) > input").val(total_cargo);
                    $(this).find("td:eq(7) > input").val(total_sub);

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

//funcion para selec de estados en modulo de operacion

$('#select_operador').change(function(){
var id_estado_sol=$(this).val();
$('#id_estados_sol').attr('action', 'homepage.php?id=operador');
$('#id_estados_sol').submit();
});


$('#select_ATC').change(function(){
var id_estado_sol=$(this).val();
$('#id_estados_sol').attr('action', 'homepage.php?id=operacion_ATC');
$('#id_estados_sol').submit();
});

//funcion para tomar solicitud

$('.tomar_solicitud').click(function(){
var id_documento = $(this).attr("id");
$('#tomar_solicitud').attr('action', 'homepage.php?id=operador');
$("#id_documento").val(id_documento);
$("#accion").val(1);
$('#tomar_solicitud').submit();  
});

$('.tomar_solicitudATC').click(function(){
var id_documento = $(this).attr("id");
$('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_ATC');
$("#id_documento").val(id_documento);
$("#accion").val(1);
$('#tomar_solicitud').submit();  
});



//funcion para liberar solicitud

    $('.liberar_solicitud').click(function(){
        var id_documento = $(this).attr("id");
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operador');
        $("#id_documento").val(id_documento);
        $("#accion").val(2);
        $('#tomar_solicitud').submit();
    });
    
    
    $('.liberar_solicitudATC').click(function(){
        var id_documento = $(this).attr("id");
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_ATC');
        $("#id_documento").val(id_documento);
        $("#accion").val(2);
        $('#tomar_solicitud').submit();
    });


//funcion para tomar solicitud

$('.asignar_solicitud').click(function(){
var id_documento = $(this).attr("id");
$('#tomar_solicitud').attr('action', 'homepage.php?id=operador');
$("#id_documento").val(id_documento);
$("#accion").val(3);
$('#tomar_solicitud').submit();  
});



//funcion para seguir solicitud

$('.seguir_solicitud').click(function(){
var id_solicitud = $(this).attr("id");
var id_documento = $(this).attr("rel");
var tipo_documento = $(this).attr("title");
// console.log(tipo_documento);
      if(tipo_documento=="FACTURA"){
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_factura');
      }

      if(tipo_documento=="NOTA DE CREDITO"){
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_nota');
      }

      if(tipo_documento=="REFACTURA CON CAMBIO"){
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_refactura_con_cambio');
      }

      if(tipo_documento=="REFACTURA SIN CAMBIO"){
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_refactura_sin_cambio');
      }
      if(tipo_documento=="ATC"){
        $('#tomar_solicitud').attr('action', 'homepage.php?id=operacion_AQ');
      }
$("#valor_solicitud").val(id_solicitud);
$("#id_documento").val(id_documento);
$('#tomar_solicitud').submit();  
});

//funcion para gen_fac_not que aparezca mas parametros.

    $("#gen_fac_not").click(function(){
      $('#operador_nc').show("slow");
      $('#operador_fac').show("fast");
      });

    $("#gen_fac").click(function(){
      $('#operador_nc').hide("fast");
      $('#operador_fac').show("fast");
      });

    $("#gen_not").click(function(){
      $('#operador_fac').hide("fast");
       $('#operador_nc').show("slow");
      });


        $.imprimirconceptos = function(){
            $.each(arreglo_conceptos, function(id,concepto){
               // console.log('el id es: '+id+' su concepto es'+concepto);

            });
        }



    //////


    var arreglo_codigo = new Array();
    var arreglo_conceptos = new Array();

//funcion para llenar el arreglo con los conceptos
   // function listaConceptos() {
    jQuery.fn.listaConceptos = function(){
        $.ajax({
            url: "scripts/funciones.php",
            data: { request: "getConceptosdoc" },
            async: false,
            type: "POST"
        }).done(function(data) {
            if (data.length > 0) {
                for (i=0;i<data.length;i++) {
                    arreglo_codigo[i] = data[i]['CODIGO'];
                    arreglo_conceptos[i] = data[i]['DESCRIPCION'];
                 //    $('#cod_datos_conceptos').append(new Option(data[i]['CODIGO'],data[i]['CODIGO']));
                 //    $('#des_datos_conceptos').append(new Option(data[i]['DESCRIPCION'],data[i]['DESCRIPCION']));
                }
                $("#lista_concepto_cod").val(arreglo_codigo);
                $("#lista_concepto_tex").val(arreglo_conceptos);
            } else {
                $('#cod_datos_conceptos').children().each(function() {
                    $(this).remove();
                });
                alert ("No existen conceptos");
            }
        }).fail(function() {
            listaConceptos();
        });
    };

//funcion para llenar los conceptos en formulario
    jQuery.fn.numConceptos = function(idPrint){
        if(arreglo_codigo.length > 0) {
            for (i = 0; i < arreglo_codigo.length; i++) {
                $(''+idPrint).append("<option value='"+i+"'>"+arreglo_codigo[i]+"</option>");
            }
        }else{
            $(idPrint).append("<option>Error en carga</option>");
        }

    };

    jQuery.fn.txtConceptos = function(idPrint){
            if(arreglo_conceptos.length > 0) {
                for (i = 0; i < arreglo_codigo.length; i++) {
                    $(idPrint).append("<option value='"+i+"'>"+arreglo_conceptos[i]+"</option>");
                }
            }else{
                $(idPrint).append("<option>Error en carga</option>");
            }

        };




//funcion solicita datos de usuario

//    function docFactura(idCliente){
    /*jQuery.fn.docFactura = function(idCliente){
        $.ajax({
            url: "scripts/funciones.php",
            data: {request: "getdocfactura", id: idCliente},
            async: false,
            type: "POST"
        }).done(function(data){
            if (data!=null){
               // console.log(data);
                $('#razon_social').val(data);
                return data;
            } else {
                return data;
            }
        }).error(function(A,B,C){
           // console.log(B);
            alert("Error en la conexion para datos del cliente");
        });
    };*/

//funciona que proporcionas indice y te da el codigo y el concepto


    jQuery.fn.getDatosconceptos = function(indice){

    var datos = Array();
        datos['CODIGO']=arreglo_codigo[indice];
        datos['CONCEPTO']=arreglo_conceptos[indice];
        return datos;
    };

//funcion para ligar los conceptos al codigo
    $("#agregar_detalle").click(function(){
       //var codigo=$(this).find("td:eq(0)  select option").val();
        var codigo = $(this).find('td:eq(2) > input').val();
      //  console.log(codigo);
    });


    /*
     $( "#agregar_detalle" ).click(function() {

     $(".add_factura").keyup(function()
     {
     var unidad=$(this).find("td:eq(3) > input").val();
     var unitario=$(this).find("td:eq(4) > input").val();
     var descuento=$(this).find("td:eq(6) > input").val();
     total_cargo=unidad*unitario;
     total_sub=total_cargo-descuento;
     $(this).find("td:eq(5) > input").val(total_cargo);
     $(this).find("td:eq(7) > input").val(total_sub);

     });

     */


}); 

//funcion daniel

$(function(){
    $(".custom-input-file input:file").change(function(){
        $(this).parent().find(".archivo").html($(this).val());
    }).css('border-width',function(){
        if(navigator.appName == "Microsoft Internet Explorer")
            return 0;
    });
});

