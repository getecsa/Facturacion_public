function validarUsuarioForm()
{
    var formulario = document.form1;
    var msgError   = '';
    var flagError  = true;
    if(formulario.motivo_sol.value == 0){
        msgError  = 'Ingresar motivo de solicitud';
        showError(msgError);
        flagError = false;
        formulario.motivo_sol.focus();
        return false;
    }
    else if(formulario.dias_ven.value == 0){
        msgError  = 'Ingresar días de vencimiento';
        showError(msgError);
        flagError = false;
        formulario.dias_ven.focus();
        return false;
    }
        else if(formulario.leyenda_doc.value == 0){
        msgError  = 'Ingresar leyenda d	e documento';
        showError(msgError);
        flagError = false;
        formulario.leyenda_doc.focus();
        return false;
    }
    else if(formulario.iva.value == 0){
        msgError  = 'Ingresar IVA';
        showError(msgError);
        flagError = false;
        formulario.iva.focus();
        return false;
    }
    
     else if(formulario.leyenda_mat.value == 0){
        msgError  = 'Ingresar leyenda de material';
        showError(msgError);
        flagError = false;
        formulario.leyenda_mat.focus();
        return false;
    }
    else if(formulario.razon_social.value == 0){
        msgError  = 'Ingresar razón social';
        showError(msgError);
        flagError = false;
        formulario.razon_social.focus();
        return false;
    }
     else if(formulario.compa_fac.value == 0){
        msgError  = 'Ingresar compañia facturadora';
        showError(msgError);
        flagError = false;
        formulario.compa_fac.focus();
        return false;
    }
     else if(formulario.moneda.value == 0){
        msgError  = 'Ingresar moneda';
        showError(msgError);
        flagError = false;
        formulario.moneda.focus();
        return false;
    }
    
     else if(formulario.salida.value == 0){
        msgError  = 'Ingresar salida';
        showError(msgError);
        flagError = false;
        formulario.salida.focus();
        return false;
    }

   
     else if(formulario.elements[11].value == 0){
     	
        msgError  = 'Ingresar código';
        showError(msgError);
        flagError = false;
        formulario.elements[11].focus();
        return false;
    }
 

     else if(formulario.elements[12].value == 0){
        msgError  = 'Ingresar descripción';
        showError(msgError);
        flagError = false;
        formulario.elements[12].focus();
        return false;
    }
    
        else if(formulario.elements[13].value == 0){
        msgError  = 'Ingresar unidades';
        showError(msgError);
        flagError = false;
        formulario.elements[13].focus();
        return false;
    }
    
    else if(formulario.elements[14].value == 0){
        msgError  = 'Ingresar precio unitario';
        showError(msgError);
        flagError = false;
        formulario.elements[14].focus();
        return false;
    }
    else if(formulario.elements[16].value.length == 0){
        msgError  = 'Ingresar descuento';
        showError(msgError);
        flagError = false;
        formulario.elements[16].focus();
        return false;
    }

   
  }

function validarUsuarioNotaCredito()
{
    var formulario = document.form1;
    var msgError   = '';
    var flagError  = true;

if(formulario.motivo_sol.value == 0){
        msgError  = 'Ingresar motivo de solicitud';
        showError(msgError);
        flagError = false;
       formulario.motivo_sol.focus();
        return false;
    }
    
  
   
else if(formulario.leyenda_doc.value == 0){
        msgError  = 'Ingresar leyenda de documento';
        showError(msgError);
        flagError = false;
       formulario.leyenda_doc.focus();
        return false;
    }
   
   
else if(formulario.folio_fac_origen.value == 0){
        msgError  = 'Ingresar folio factura origen';
        showError(msgError);
        flagError = false;
       formulario.folio_fac_origen.focus();
        return false;
    }

else if(formulario.tipo_nc.value == 0){
        msgError  = 'Ingresar tipo nota de crédito';
        showError(msgError);
        flagError = false;
       formulario.tipo_nc.focus();
        return false;
    }

else if(formulario.iva.value == 0){
        msgError  = 'Ingresar IVA';
        showError(msgError);
        flagError = false;
       formulario.iva.focus();
        return false;
    }

else if(formulario.mt_fac_orig.value == 0){
        msgError  = 'Ingresar monto factura origen';
        showError(msgError);
        flagError = false;
       formulario.mt_fac_orig.focus();
        return false;
    }

else if(formulario.razon_social.value == 0){
        msgError  = 'Ingresar razón social';
        showError(msgError);
        flagError = false;
       formulario.razon_social.focus();
        return false;
    }   

else if(formulario.moneda.value == 0){
        msgError  = 'Ingresar moneda';
        showError(msgError);
        flagError = false;
       formulario.moneda.focus();
        return false;
    }   

else if(formulario.fecha_emision_nc.value == 0){
        msgError  = 'Ingresar fecha emisión NC';
        showError(msgError);
        flagError = false;
       formulario.fecha_emision_nc.focus();
        return false;
    }   

else if(formulario.monto_afectar_nc.value == 0){
        msgError  = 'Ingresar monto afectar NC';
        showError(msgError);
        flagError = false;
       formulario.monto_afectar_nc.focus();
        return false;
    }   


else if(formulario.elements[12].value == 0){
     	
        msgError  = 'Ingresar código';
        showError(msgError);
        flagError = false;
        formulario.elements[12].focus();
        return false;
    }
 

     else if(formulario.elements[13].value == 0){
        msgError  = 'Ingresar descripción';
        showError(msgError);
        flagError = false;
        formulario.elements[13].focus();
        return false;
    }
    
        else if(formulario.elements[14].value == 0){
        msgError  = 'Ingresar unidades';
        showError(msgError);
        flagError = false;
        formulario.elements[14].focus();
        return false;
    }
    
    else if(formulario.elements[15].value == 0){
        msgError  = 'Ingresar precio unitario';
        showError(msgError);
        flagError = false;
        formulario.elements[15].focus();
        return false;
    }
    else if(formulario.elements[17].value.length == 0){
        msgError  = 'Ingresar descuento';
        showError(msgError);
        flagError = false;
        formulario.elements[17].focus();
        return false;
    }

}


function validarUsuarioRefacturaCon()
{
    var formulario = document.form1;
    var msgError   = '';
    var flagError  = true;

if(formulario.motivo_sol.value == 0){
        msgError  = 'Ingresar motivo de solicitud';
        showError(msgError);
        flagError = false;
       formulario.motivo_sol.focus();
        return false;
    }
      
else if(formulario.leyenda_doc.value == 0){
        msgError  = 'Ingresar leyenda de documento';
        showError(msgError);
        flagError = false;
       formulario.leyenda_doc.focus();
        return false;
    }
   
   
else if(formulario.dias_ven.value == 0){
        msgError  = 'Ingresar días vencimiento';
        showError(msgError);
        flagError = false;
       formulario.dias_ven.focus();
        return false;
    }

else if(formulario.codigo_cliente_afectar.value == 0){
        msgError  = 'Ingresar código cliente afectar';
        showError(msgError);
        flagError = false;
       formulario.codigo_cliente_afectar.focus();
        return false;
    }


else if(formulario.fecha_emision_nc.value == 0){
        msgError  = 'Fecha emisión NC';
        showError(msgError);
        flagError = false;
       formulario.fecha_emision_nc.focus();
        return false;
    }

else if(formulario.moneda.value == 0){
        msgError  = 'Ingresar moneda';
        showError(msgError);
        flagError = false;
       formulario.moneda.focus();
        return false;
    }   


else if(formulario.iva.value == 0){
        msgError  = 'Ingresar IVA';
        showError(msgError);
        flagError = false;
       formulario.iva.focus();
        return false;
    }
else if(formulario.folio_fac_origen.value == 0){
        msgError  = 'Ingresar folio factura origen';
        showError(msgError);
        flagError = false;
       formulario.folio_fac_origen.focus();
        return false;
    }   


else if(formulario.folio_nc.value == 0){
        msgError  = 'Ingresar folio NC';
        showError(msgError);
        flagError = false;
       formulario.folio_nc.focus();
        return false;
    }   


else if(formulario.fecha_emision_nc2.value == 0){
        msgError  = 'Ingresar Fecha Emisión Fac. Origen';
        showError(msgError);
        flagError = false;
       formulario.fecha_emision_nc2.focus();
        return false;
    }   

else if(formulario.razon_social.value == 0){
        msgError  = 'Ingresar razón social';
        showError(msgError);
        flagError = false;
       formulario.razon_social.focus();
        return false;
    }   

else if(formulario.entrada.value == 0){
        msgError  = 'Ingresar entrada';
        showError(msgError);
        flagError = false;
       formulario.entrada.focus();
        return false;
    }   

else if(formulario.motivo_nc.value == 0){
        msgError  = 'Ingresar motivo NC';
        showError(msgError);
        flagError = false;
       formulario.motivo_nc.focus();
        return false;
    }   

else if(formulario.mt_fac_orig.value == 0){
        msgError  = 'Ingresar monto factura origen';
        showError(msgError);
        flagError = false;
       formulario.mt_fac_orig.focus();
        return false;
    }   

else if(formulario.monto_afectar_nc.value == 0){
        msgError  = 'Ingresar monto afectar NC';
        showError(msgError);
        flagError = false;
       formulario.monto_afectar_nc.focus();
        return false;
    }   

else if(formulario.importe_total.value == 0){
        msgError  = 'Ingresar importe total';
        showError(msgError);
        flagError = false;
       formulario.importe_total.focus();
        return false;
    }   



else if(formulario.elements[18].value == 0){
     	
        msgError  = 'Ingresar código';
        showError(msgError);
        flagError = false;
        formulario.elements[18].focus();
        return false;
    }
 

     else if(formulario.elements[19].value == 0){
        msgError  = 'Ingresar descripción';
        showError(msgError);
        flagError = false;
        formulario.elements[19].focus();
        return false;
    }
    
        else if(formulario.elements[20].value == 0){
        msgError  = 'Ingresar unidades';
        showError(msgError);
        flagError = false;
        formulario.elements[20].focus();
        return false;
    }
    
    else if(formulario.elements[21].value == 0){
        msgError  = 'Ingresar precio unitario';
        showError(msgError);
        flagError = false;
        formulario.elements[21].focus();
        return false;
    }
    else if(formulario.elements[23].value.length == 0){
        msgError  = 'Ingresar descuento';
        showError(msgError);
        flagError = false;
        formulario.elements[23].focus();
        return false;
    }

}

function validarUsuarioRefacturaSin()
{
    var formulario = document.form1;
    var msgError   = '';
    var flagError  = true;

if(formulario.motivo_sol.value == 0){
        msgError  = 'Ingresar motivo de solicitud';
        showError(msgError);
        flagError = false;
       formulario.motivo_sol.focus();
        return false;
    }
      
else if(formulario.leyenda_doc.value == 0){
        msgError  = 'Ingresar leyenda de documento';
        showError(msgError);
        flagError = false;
       formulario.leyenda_doc.focus();
        return false;
    }
   
   
else if(formulario.dias_ven.value == 0){
        msgError  = 'Ingresar días vencimiento';
        showError(msgError);
        flagError = false;
       formulario.dias_ven.focus();
        return false;
    }

else if(formulario.codigo_cliente_afectar.value == 0){
        msgError  = 'Ingresar código cliente afectar';
        showError(msgError);
        flagError = false;
       formulario.codigo_cliente_afectar.focus();
        return false;
    }


else if(formulario.fecha_emision_nc.value == 0){
        msgError  = 'Fecha emisión NC';
        showError(msgError);
        flagError = false;
       formulario.fecha_emision_nc.focus();
        return false;
    }

else if(formulario.moneda.value == 0){
        msgError  = 'Ingresar moneda';
        showError(msgError);
        flagError = false;
       formulario.moneda.focus();
        return false;
    }   


else if(formulario.iva.value == 0){
        msgError  = 'Ingresar IVA';
        showError(msgError);
        flagError = false;
       formulario.iva.focus();
        return false;
    }
else if(formulario.folio_fac_origen.value == 0){
        msgError  = 'Ingresar folio factura origen';
        showError(msgError);
        flagError = false;
       formulario.folio_fac_origen.focus();
        return false;
    }   


else if(formulario.folio_nc.value == 0){
        msgError  = 'Ingresar folio NC';
        showError(msgError);
        flagError = false;
       formulario.folio_nc.focus();
        return false;
    }   


else if(formulario.fecha_emision_nc2.value == 0){
        msgError  = 'Ingresar Fecha Emisión Fac. Origen';
        showError(msgError);
        flagError = false;
       formulario.fecha_emision_nc2.focus();
        return false;
    }   

else if(formulario.razon_social.value == 0){
        msgError  = 'Ingresar razón social';
        showError(msgError);
        flagError = false;
       formulario.razon_social.focus();
        return false;
    }   

else if(formulario.entrada.value == 0){
        msgError  = 'Ingresar entrada';
        showError(msgError);
        flagError = false;
       formulario.entrada.focus();
        return false;
    }   

else if(formulario.motivo_nc.value == 0){
        msgError  = 'Ingresar motivo NC';
        showError(msgError);
        flagError = false;
       formulario.motivo_nc.focus();
        return false;
    }   

else if(formulario.mt_fac_orig.value == 0){
        msgError  = 'Ingresar monto factura origen';
        showError(msgError);
        flagError = false;
       formulario.mt_fac_orig.focus();
        return false;
    }   

else if(formulario.monto_afectar_nc.value == 0){
        msgError  = 'Ingresar monto afectar NC';
        showError(msgError);
        flagError = false;
       formulario.monto_afectar_nc.focus();
        return false;
    }   

else if(formulario.importe_total.value == 0){
        msgError  = 'Ingresar importe total';
        showError(msgError);
        flagError = false;
       formulario.importe_total.focus();
        return false;
    }   



else if(formulario.elements[18].value == 0){
     	
        msgError  = 'Ingresar código';
        showError(msgError);
        flagError = false;
        formulario.elements[18].focus();
        return false;
    }
 

     else if(formulario.elements[19].value == 0){
        msgError  = 'Ingresar descripción';
        showError(msgError);
        flagError = false;
        formulario.elements[19].focus();
        return false;
    }
    
        else if(formulario.elements[20].value == 0){
        msgError  = 'Ingresar unidades';
        showError(msgError);
        flagError = false;
        formulario.elements[20].focus();
        return false;
    }
    
    else if(formulario.elements[21].value == 0){
        msgError  = 'Ingresar precio unitario';
        showError(msgError);
        flagError = false;
        formulario.elements[21].focus();
        return false;
    }
    else if(formulario.elements[23].value.length == 0){
        msgError  = 'Ingresar descuento';
        showError(msgError);
        flagError = false;
        formulario.elements[23].focus();
        return false;
    }

}



  
function validarUsuarioNuevaSolictud()
{
    var formulario = document.nueva_solicitud;
    var msgError   = '';
    var flagError  = true;
    if(formulario.tipo_cliente.value == 0){
        msgError  = 'Se debe seleccionar tipo de cliente';
        showError(msgError);
        flagError = false;
        formulario.tipo_cliente.focus();
        return false;
    }
   
  }  
  
  function showError(msg)
{
    $('#errorForm').text(msg);
    $('#errorForm').addClass('contentBoxError');
    $('#errorForm').css('display','inline');
    setTimeout(function() {  
        $("#errorForm").fadeOut('slow', function() {
            $('#errorForm').removeClass('contentBoxError');
            $('#errorForm').text('');
        });
    },2000);
}