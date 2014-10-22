/*
Versión 1.0 Oct-14
Funciones JavaScript
Elaboró: Alfredo Rodríguez Carrillo
*/
// Función para Validar el Acceso al Aplicativo *
function validarInicioSesion(){
    var formulario=document.acceso;
    var arrOutput;
    $.ajax({
        type: "POST",
        url: "login.php",
        data: {txtUsuario:formulario.usuario.value,txtPassword:formulario.password.value},
        success: function(response){
            arrOutput = response.split(':');
            if(arrOutput[0] == 1){
                location.href = arrOutput[2];
            }else{
                showError(arrOutput[1]);
                if(formulario.usuario.value.length == 0){
                    formulario.usuario.focus();
                }else{
                    formulario.password.focus();
                }
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error Login 0x002: No se pudo iniciar sesión. (' + trn + ')');
            }else if(status == 'timeout'){
                showError('Error Login 0x003: No se pudo iniciar Sesión por Tiempo Excedido. (' + trn + ')');
            }
            return false;
        }
    });
}
//
// Función para validar el Perfil Seleccionado en la Ventana de Permisos Documentos. *
function validarPerfilSel(){
    var formulario=document.form1;
    if(formulario.perfilSel.value != 0){
        formulario.action = 'admin.php?opc=view';
        formulario.method = 'POST';
        formulario.submit();
        /*$.ajax({
            type: "POST",
            url: "admin/adminDocsPermisos.php",
            data: {mod : 'docs',opc : 'view'},
            success: function(response){
                if(response == 1){
                    formulario.action = 'admin.php?mod=' + mod + '&acc=con';
                    formulario.method = 'POST';
                    formulario.submit();
                }else{
                    showError(response);
                    return false;
                }
            },
            error: function(xhr,status,trn){
                if(status == 'error'){
                    showError('Error al realizar la Consulta. Error Name: ' + trn);
                }else if(status == 'timeout'){
                    showError('Error al realizar la Consulta Tiempo Excedido. Error Name: ' + trn);
                }
                return false;
            }
        });*/
    }else{
        showError('Seleccione un Perfil.');
        return false;
    }
}
//
// Función para validar el Formulario de Áreas. *
function validarAreasForm(){
    var formulario=document.form1;
    if(formulario.nombreArea.value.length == 0){
        showError('Escribir un Nombre de Área.');
        formulario.nombreArea.focus();
        return false;
    }
    if(formulario.tipoArea.value == -1){
        showError('Seleccionar el Tipo de Área.');
        formulario.tipoArea.focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: "admin/adminAreasAction.php",
        data: {idArea : $('#idArea').val(),nombreArea : $('#nombreArea').val(),tipoArea : $('#tipoArea').val(),
        acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se guardó el registro exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al guardar los cambios. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al guardar los cambios Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para seleccionar una fila para editar la Área. *
function editarArea(num)
{
    var formulario = document.form1;
    formulario.action = 'admin.php?mod=areas&acc=form&opc=edit&row=' + num;
    formulario.method = 'POST';
    formulario.submit();
}
//
// Función para realizar el cambio de estatus de una Área. *
function cambioEstatusArea(estatus,num){
    $.ajax({
        type: "POST",
        url: "admin/adminEstatusAreasAction.php",
        data: {idArea : $('#idarea_' + num).val(),estatusArea : estatus,acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se cambió el estatus exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al cambiar el estatus del Área. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al cambiar el estatus del Área Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para validar el Formulario de las Tasas. *
function validarTasasForm(){
    var formulario=document.form1;
    if(formulario.nombreTasa.value.length == 0){
        showError('Escribir un Nombre de una Tasa.');
        formulario.nombreTasa.focus();
        return false;
    }
    if(formulario.valorTasa.value <= 0){
        showError('Escribir un Valor de una Tasa.');
        formulario.valorTasa.focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: "admin/adminIvaAction.php",
        data: {idIva : $('#idIva').val(),nombreTasa : $('#nombreTasa').val(),valorTasa : $('#valorTasa').val(),
        acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se guardó el registro exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al guardar los cambios. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al guardar los cambios Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para seleccionar una fila para editar la Tasa. *
function editarTasa(num)
{
    var formulario = document.form1;
    formulario.action = 'admin.php?mod=iva&acc=form&opc=edit&row=' + num;
    formulario.method = 'POST';
    formulario.submit();
}
//
// Función para realizar el cambio de estatus de una Tasa. *
function cambioEstatusTasa(estatus,num){
    $.ajax({
        type: "POST",
        url: "admin/adminEstatusIvaAction.php",
        data: {idIva : $('#idiva_' + num).val(),estatusTasa : estatus,acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se cambió el estatus exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al cambiar el estatus de la Tasa. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al cambiar el estatus de la Tasa Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para validar el Formulario de las Monedas *
function validarMonedasForm(){
    var formulario=document.form1;
    if(formulario.nombreTasa.value.length == 0){
        showError('Escribir un Nombre de una Moneda.');
        formulario.nombreTasa.focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: "admin/adminMonedaAction.php",
        data: {idMoneda : $('#idMoneda').val(),nombreMoneda : $('#nombreMoneda').val(),acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se guardó el registro exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al guardar los cambios. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al guardar los cambios Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para seleccionar una fila para editar la Moneda. *
function editarMoneda(num)
{
    var formulario = document.form1;
    formulario.action = 'admin.php?mod=iva&acc=form&opc=edit&row=' + num;
    formulario.method = 'POST';
    formulario.submit();
}
//
// Función para realizar el cambio de estatus de una Moneda. *
function cambioEstatusMoneda(estatus,num){
    $.ajax({
        type: "POST",
        url: "admin/adminEstatusMonedaAction.php",
        data: {idMoneda : $('#idmoneda_' + num).val(),estatusMoneda : estatus,acc : 'guardar'},
        success: function(response){
            if(response == 1){
                alert('Se cambió el estatus exitosamente.');
                location.href = 'admin.php?mod=' + $('#mod').val() + '&acc=con';
            }else{
                showError(response);
                return false;
            }
        },
        error: function(xhr,status,trn){
            if(status == 'error'){
                showError('Error al cambiar el estatus de la Moneda. Error Name: ' + trn);
            }else if(status == 'timeout'){
                showError('Error al cambiar el estatus de la Moneda Tiempo Excedido. Error Name: ' + trn);
            }
            return false;
        }
    });
}
//
// Función para validar la Bandeja Seleccionada en el Formulario de la Reasignación de un Folio. *
function validaBandejaSel(){
    var formulario=document.form1;
    if(formulario.bandejaSel.value != 0){
        if(formulario.perfilSel.value != 0 || formulario.perfilSel.value == 0){
            formulario.perfilSel.value = 0;
            formulario.perfilSel.disabled = true;
        }
    }else{
        formulario.perfilSel.disabled = false;
    }
}
//
// Función para validar el Perfil Seleccionado en el Formulario de la Reasignación de un Folio. *
function validaPerfilSel(){
    var formulario=document.form1;
    if(formulario.perfilSel.value != 0){
        if(formulario.bandejaSel.value != 0 || formulario.bandejaSel.value == 0){
            formulario.bandejaSel.value = 0;
            formulario.bandejaSel.disabled = true;
        }
    }else{
        formulario.bandejaSel.disabled = false;
    }
}
//
// Función para validar el Desbloqueo de un Folio. *
function validarDesbloqueo(btn,mod,folio){
    var formulario=document.form1;
    var perfilSel  = 0;
    var bandejaSel = 0;
    if(btn == 'desbloqueo'){
        if(formulario.estatusBloqueo.value == 1){
            if(confirm('¿Está seguro de Desbloquear el Folio ABD ' + folio + '?')){
                $.ajax({
                    type: "POST",
                    url: "admin/adminDesbloqueoAction.php",
                    data: {folioAbd : folio,acc : 'guardar'},
                    success: function(response){
                        if(response == 1){
                            alert('Se desbloqueó el Folio con éxito.');
                            location.href = 'admin.php?mod=' + mod + '&acc=form';
                        }else{
                            showError(response);
                            return false;
                        }
                    },
                    error: function(xhr,status,trn){
                        if(status == 'error'){
                            showError('Error al realizar el Desbloqueó. Error Name: ' + trn);
                        }else if(status == 'timeout'){
                            showError('Error al realizar el Desbloqueó Tiempo Excedido. Error Name: ' + trn);
                        }
                        return false;
                    }
                });
            }else{
                return false;
            }
        }else{
            showError('El Folio se encuentra Disponible. No se realizó ningún Desbloqueó.');
            return false;
        }
    }else{
        location.href = 'admin.php?mod=' + mod + '&acc=form';
    }
}
//
// Función para mostrar un registro de la Bandeja de Cobranza *
function mostrarRegistro(folio,mod){
    var formulario=document.form1;
    location.href = 'bandejas.php?mod=' + mod + '&acc=view&folio=' + folio;
}
//
// Función para habilitar un campo para editar *
function editarCampos(num){
        if($('#aceptado_2_' + num).prop('checked')){
            var divHtml = $(".ticketField_" + num).html();
            var editableText = $("<input/>");
            editableText.attr("maxlength",10);
            editableText.attr("size",10);
            editableText.addClass('ticketField_' + num);
            editableText.val(divHtml);
            $(".ticketField_" + num).replaceWith(editableText);
            editableText.focus();
            var divJustifica = $(".justificacionField_" + num).html();
            var editableTextJustifica = $("<input/>");
            editableTextJustifica.attr("maxlength",300);
            editableTextJustifica.attr("size",13);
            editableTextJustifica.addClass('justificacionField_' + num);
            editableTextJustifica.val(divJustifica);
            $(".justificacionField_" + num).replaceWith(editableTextJustifica);
        }else{
            cerrarCampos(num);
        }
}
//
//
function cerrarCampos(num)
{
    var viewableText = $("<div></div>").addClass('ticketField_' + num);
    viewableText.html();
    $('.ticketField_' + num).replaceWith(viewableText);
    var viewableText = $("<div></div>").addClass('justificacionField_' + num);
    viewableText.html();
    $('.justificacionField_' + num).replaceWith(viewableText);
}
//
// Función para habilitar un campo para editar *
function editarCamposReverJustifica(num){
    if($('#decision_3_' + num).prop('checked')){
        var divHtml = $(".ticketField_" + num).html();
        var editableText = $("<input/>");
        editableText.attr("maxlength",10);
        editableText.attr("size",10);
        editableText.addClass('ticketField_' + num);
        editableText.val(divHtml);
        $(".ticketField_" + num).replaceWith(editableText);
        editableText.focus();
        var divJustifica = $(".justificacionField_" + num).html();
        var editableTextJustifica = $("<input/>");
        editableTextJustifica.attr("maxlength",300);
        editableTextJustifica.attr("size",12);
        editableTextJustifica.addClass('justificacionField_' + num);
        editableTextJustifica.val(divJustifica);
        $(".justificacionField_" + num).replaceWith(editableTextJustifica);
    }else{
        cerrarCamposReversion(num);
    }
}
//
// Función para habilitar un campo para editar *
function editarCamposRever(num){
    if($('#decision_2_' + num).prop('checked')){
        var viewableText = $("<div></div>").addClass('ticketField_' + num);
        viewableText.html();
        $('.ticketField_' + num).replaceWith(viewableText);
        var divHtml = $(".justificacionField_" + num).html();
        var editableText = $("<input/>");
        editableText.attr("maxlength",300);
        editableText.attr("size",9);
        editableText.addClass('justificacionField_' + num);
        editableText.val(divHtml);
        $(".justificacionField_" + num).replaceWith(editableText);
        editableText.focus();
    }else{
        cerrarCamposReversion(num);
    }
}
//
//
function cerrarCamposReversion(num)
{
    var viewableText = $("<div></div>").addClass('ticketField_' + num);
    viewableText.html();
    $('.ticketField_' + num).replaceWith(viewableText);
    var viewableText = $("<div></div>").addClass('justificacionField_' + num);
    viewableText.html();
    $('.justificacionField_' + num).replaceWith(viewableText);
}
//
//
function selectOne(id,element)
{
    if(document.getElementById(id).checked == true){
        for (var i = 1;i <= 2; i++){
            document.getElementById("linea_" + i + "_" + element).checked = false;
        }
        document.getElementById(id).checked = true;
    }else{
        document.getElementById(id).checked = false;
    }
}
//
//
function selectAceptado(id,element)
{
    if(document.getElementById(id).checked == true){
        for (var i = 1;i <= 2; i++){
            document.getElementById("aceptado_" + i + "_" + element).checked = false;
        }
        document.getElementById(id).checked = true;
    }else{
        document.getElementById(id).checked = false;
    }
}
//
//
function selectDecision(id,element)
{
    if(document.getElementById(id).checked == true){
        for (var i = 1;i <= 3; i++){
            document.getElementById("decision_" + i + "_" + element).checked = false;
        }
        document.getElementById(id).checked = true;
    }else{
        document.getElementById(id).checked = false;
    }
}
//
//
function selectPago(id,element)
{
    if(document.getElementById(id).checked == true){
        for (var i = 1;i <= 2; i++){
            document.getElementById("pago_" + i + "_" + element).checked = false;
        }
        document.getElementById(id).checked = true;
    }else{
        document.getElementById(id).checked = false;
    }
}
//
//
function saveReg(mod,folio,num)
{
    //Bandeja de Respuesta ABD Reversión.
    if(mod == 'respuesta'){
        var bandeja = '';
        if(!$('#aceptado_1_' + num).prop('checked') && !$('#aceptado_2_' + num).prop('checked')){
            showError('Seleccione SI o NO en ¿Aceptado por ABD? del Folio ABD ' + folio);
            return false;
        }
        if($('#campoFecha_' + num).val() == '' && $('#aceptado_1_' + num).prop('checked')){
            showError('Seleccione la Fecha de FVC del Folio ABD ' + folio);
            $('#campoFecha_' + num).focus();
            return false;
        }
        if($('#aceptado_1_' + num).prop('checked')){
            decision = 1;
            fechaFvc = $('#campoFecha_' + num).val();
        }else if($('#aceptado_2_' + num).prop('checked')){
            decision = 2;
            fechaFvc = '00000000';
        }
        if(confirm('¿Está seguro de guardar los cambios para el Folio ABD ' + folio + '?')){
            $.ajax({
                type: "POST",
                url: "bandeja/bandejaRespuestaAction.php",
                data: {folioAbd : folio,decisionFolio : decision,fechaFvcVal : fechaFvc,acc : 'guardar'},
                success: function(response){
                    if(response == 1){
                        alert('Se guardó el registro con éxito.');
                        location.href = 'bandejas.php?mod=resprever&acc=con';
                    }else{
                        showError(response);
                        return false;
                    }
                },
                error: function(){
                    showError('Error al guardar registro del Folio ABD ' + folio);
                    return false;
                }
            });
        }else{
            return false;
        }
    }
    //
    // Bandeja de Incidencias.
    if(mod == 'incidencias'){
        if($('#perfilAnterior_' + num).html() == 'Reversiones'){
            if(confirm('¿Está seguro de Resolver el Folio ABD ' + folio + '?')){
                $.ajax({
                    type: "POST",
                    url: "bandeja/bandejaIncidenciasAction.php",
                    data: {folioAbd : folio,bandeja : 6,estatus : 1,acc : 'guardar'},
                    success: function(response){
                        if(response == 1){
                            alert('Se guardó el registro con éxito.');
                            location.href = 'bandejas.php?mod=' + mod + '&acc=con';
                        }else{
                            showError(response);
                            return false;
                        }
                    },
                    error: function(){
                        showError('Error al guardar registro del Folio ABD ' + folio);
                        return false;
                    }
                });
            }else{
                return false;
            }
        }
        if($('#perfilAnterior_' + num).html() == 'Respuesta ABD Reversión'){
            if(confirm('¿Está seguro de Resolver el Folio ABD ' + folio + '?')){
                $.ajax({
                    type: "POST",
                    url: "bandeja/bandejaIncidenciasAction.php",
                    data: {folioAbd : folio,bandeja : 5,estatus : 5,acc : 'guardar'},
                    success: function(response){
                        if(response == 1){
                            alert('Se guardó el registro con éxito.');
                            location.href = 'bandejas.php?mod=' + mod + '&acc=con';
                        }else{
                            showError(response);
                            return false;
                        }
                    },
                    error: function(){
                        showError('Error al guardar registro del Folio ABD ' + folio);
                        return false;
                    }
                });
            }else{
                return false;
            }
        }
    }
    //
    // Bandeja de Reversiones.
    if(mod == 'reversiones'){
        var decision = 0;
        if(!$('#decision_1_' + num).prop('checked') && !$('#decision_2_' + num).prop('checked') && 
        !$('#decision_3_' + num).prop('checked')){
            showError('Seleccione SI o NO en ¿Se Reversa? o Marque Incidencia para el Folio ABD ' + folio);
            return false;
        }
        if($('#decision_1_' + num).prop('checked')){
            
        }else if($('#decision_2_' + num).prop('checked') && $('#decision_2_' + num).is(":disabled") == false){
            if($('.justificacionField_' + num).val() == ''){
                showError('Debe escribir la Justificación para el Folio ABD ' + folio);
                $('.justificacionField_' + num).focus();
                return false;
            }
        }else if($('#decision_3_' + num).prop('checked')){
            if($('.ticketField_' + num).val() == ''){
                showError('Debe escribir el Ticket para el Folio ABD ' + folio);
                $('.ticketField_' + num).focus();
                return false;
            }
            if($('.justificacionField_' + num).val() == ''){
                showError('Debe escribir la Justificación para el Folio ABD ' + folio);
                $('.justificacionField_' + num).focus();
                return false;
            }
        }
        if($('#decision_1_' + num).prop('checked')){
            decision = 1;
        }else if($('#decision_2_' + num).prop('checked')){
            decision = 2;
        }else if($('#decision_3_' + num).prop('checked')){
            decision = 3;
        }
        if(confirm('¿Está seguro de guardar los cambios para el Folio ABD ' + folio + '?')){
            $.ajax({
                type: "POST",
                url: "bandeja/bandejaReversionesAction.php",
                data: {folioAbd : folio,ticket : $('.ticketField_' + num).val(), justificacion : 
                $('.justificacionField_' + num).val(),decisionFolio : decision,acc : 'guardar'},
                success: function(response){
                    if(response == 1){
                        alert('Se guardó el registro con éxito.');
                        location.href = 'bandejas.php?mod=reversiones&acc=con';
                    }else{
                        showError(response);
                        return false;
                    }
                },
                error: function(){
                    showError('Error al guardar registro del Folio ABD ' + folio);
                    return false;
                }
            });
        }else{
            return false;
        }
    }
    //
    // Bandeja de Líneas Activas. *
    if(mod == 'lineas'){
        var decision = 0;
        if(!$('#aceptado_1_' + num).prop('checked') && !$('#aceptado_2_' + num).prop('checked')){
            showError('Seleccione SI o NO en Línea AAA del Folio ABD ' + folio);
            return false;
        }
        if($('#aceptado_2_' + num).prop('checked')){
            if($('.ticketField_' + num).val() == ''){
                showError('Debe de escribir el Ticket para el Folio ABD ' + folio);
                $('.ticketField_' + num).focus();
                return false;
            }
            if($('.justificacionField_' + num).val() == ''){
                showError('Debe de escribir una Justificación para el Folio ABD ' + folio);
                $('.justificacionField_' + num).focus();
                return false;
            }
        }
        if($('#aceptado_1_' + num).prop('checked')){
            decision = 1;
        }else if($('#aceptado_2_' + num).prop('checked')){
            decision = 2;
        }
        if(confirm('¿Está seguro de guardar los cambios para el Folio ABD ' + folio + '?')){
            $.ajax({
                type: "POST",
                url: "bandeja/bandejaLineasActivasAction.php",
                data: {folioAbd : folio,decisionFolio : decision,ticket : $('.ticketField_' + num).val(), justificacion : 
                $('.justificacionField_' + num).val(),decision : $('#decision_3_' + num).val(),acc : 'guardar'},
                success: function(response){
                    if(response == 1){
                        alert('Se guardó el registro con éxito.');
                        location.href = 'bandejas.php?mod=linactivas&acc=con';
                    }else{
                        showError(response);
                        return false;
                    }
                },
                error: function(){
                    showError('Error al guardar registro del Folio ABD ' + folio);
                    return false;
                }
            });
        }else{
            return false;
        }
    }
    //
    // Bandeja de Cobranza. *
    if(mod == 'cobranza'){
        var decision = 0;
        var flagDecision = 1;
        var folioAbd = '';
        var arrPost  = new Array();
        for(var indice = 1; indice <= $('#totalRegs').val(); indice++){
            if($('#registrarPago_' + indice).val() == 1){
                if(!$('#pago_1_' + indice).prop('checked') && !$('#pago_2_' + indice).prop('checked')){
                    showError('Debe registrar el Pago del Folio ABD ' + $('#folioAbd_' + indice).val());
                    return false;
                }
            }
            if($('#pago_1_' + indice).prop('checked')){
                decision = 1;
            }
            if($('#pago_2_' + indice).prop('checked')){
                decision = 2;
            }
            if(decision != 0){
                arrPost[indice - 1] = "folio:" + $('#folioAbd_' + indice).val() + ",pago:" + decision;
                decision = 0;
            }else{
                flagDecision = 0;
            }
        }
        if($('#totalRegs').val() == 0){
            flagDecision = 0;
        }
        if(flagDecision != 0){
            if(confirm('¿Está seguro de guardar los registros?')){
                $.ajax({
                    type: "POST",
                    url: "bandeja/bandejaCobranzaAction.php",
                    data: {datos : arrPost,acc : 'guardar'},
                    success: function(response){
                        if(response == 1){
                            alert('Se guardaron los registros con éxito.');
                            location.href = 'bandejas.php?mod=cobranza&acc=con';
                        }else{
                            showError(response);
                            return false;
                        }
                    },
                    error: function(){
                        showError('Error al guardar los registros.');
                        return false;
                    }
                });
            }else{
                return false;
            }
        }else{
            showError('No se ha seleccionado nada para guardar.');
        }
    }
    //
}
//
// Función para modificar dinámicamente las opciones del Formulario al seleccionar una Evaluación. *
function validarEvaluacion(element)
{
    $("#" + element).each(function(){
        if(this.value == 1 && this.checked){
            for(var i = 1; i <= 7; i++){
                $('#justifica_' + i).attr('disabled',true);
                $('#justifica_' + i).attr('checked',false);
            }
            $('#decision_2').attr('checked',false);
            $('#decision_3').attr('checked',false);
        }else if(this.value == 1 && !this.checked){
            for(var i = 1; i <= 7; i++){
                $('#justifica_' + i).attr('disabled',false);
            }
        }
        if(this.value == 2 && this.checked){
            for(var i = 1; i <= 7; i++){
                $('#justifica_' + i).attr('disabled',false);
            }
            $('#decision_1').attr('checked',false);
            $('#decision_3').attr('checked',false);
        }
        if(this.value == 3 && this.checked){
            for(var i = 1; i <= 7; i++){
                $('#justifica_' + i).attr('disabled',false);
            }
            $('#decision_1').attr('checked',false);
            $('#decision_2').attr('checked',false);
        }
    });
}
//
// Funcón para enviar la respuesta seleccionada por el Usuario a la BD *
function validarTomaFolio(mod,folio)
{
    var flagOpcion = false;
    // Se Cancela la Toma de Folio. *
    if(mod == 'cancelar'){
        window.open('bandejas.php?mod=solicitudes&acc=con','_parent');
    }
    // Se guarda la solicitud de Folio y se Toma el Folio. *
    if(mod == 'guardar'){
        var decision = 0;
        var arrJustifica = '';
        if(!$('#decision_1').prop('checked') && !$('#decision_2').prop('checked') && 
        !$('#decision_3').prop('checked')){
            showError('Seleccione un estatus de Evaluación.');
            return false;
        }
        if($('#decision_2').prop('checked') || $('#decision_3').prop('checked')){
            for(var i = 1; i <= 7; i++){
                if($('#justifica_' + i).prop('checked')){
                    flagOpcion = true;
                }
            }
            if(!flagOpcion){
                showError('Seleccione por lo menos una justificación.');
                return false;
            }
        }
        if($('#decision_1').prop('checked')){
            decision = 1;
        }else{
            if($('#decision_2').prop('checked')){
                decision = 2;
            }else if($('#decision_3').prop('checked')){
                decision = 3;
            }
            for(var i = 1; i <= 7; i++){
                if($('#justifica_' + i).prop('checked')){
                    arrJustifica = arrJustifica + $('#justifica_' + i).val() + ',';
                }
            }
        }
        if(confirm('¿Está seguro de guardar los cambios?')){
            $.ajax({
                type: "POST",
                url: "admin/registroFolioAction.php",
                data: {folioAbd : folio,estatusEval : decision,justificaciones : arrJustifica,acc : 'guardar'},
                success: function(response){
                    if(response == 1){
                        alert('Se guardó el registro con éxito.');
                        window.open('bandejas.php?mod=solicitudes&acc=con','_parent');
                    }else{
                        showError(response);
                        return false;
                    }
                },
                error: function(){
                    showError('Error al guardar registro.');
                    return false;
                }
            });
        }else{
            return false;
        }
    }
}
//
// Función para preguntar si desea tomar el Folio un Usuario de un Folio No Disponible *
function validarVolverTomaFolio(folio)
{
    if(confirm('¿Deseas tomar el Folio ABD ' + folio + '?')){
        $.ajax({
            type: "POST",
            url: "admin/volverTomarFolioAction.php",
            data: {folioAbd : folio,acc : 'guardar'},
            success: function(response){
                if(response == 1){
                    alert('Ha tomado el Folio ABD con éxito.');
                    window.open('bandejas.php?mod=penres&acc=con','_parent');
                }else{
                    showError(response);
                    return false;
                }
            },
            error: function(){
                showError('Error al registrar el cambio.');
                return false;
            }
        });
    }else{
        return false;
    }
}
//
// Función que realiza la validación del Formulario de la solicitud en la Bandeja Pendiente Respuesta ABD. *
function validarRespuestaFolio(element,folio)
{
    if(element == 'guardar'){
        if($('#estatusEval').val() == 1 || $('#estatusEval').val() == 2){
            var decision = 0;
            var fechaFvc = '';
            if(!$('#decision_s').prop('checked') && !$('#decision_n').prop('checked')){
                showError('Seleccione si se va a exportar.');
                return false;
            }
            if($('#decision_s').prop('checked')){
                if($('#fechaFvc').val().length == 0){
                    showError('Seleccione la Fecha FVC.');
                    $('#fechaFvc').focus();
                    return false;
                }
            }
            if($('#decision_s').prop('checked')){
                decision = 1;
                fechaFvc = $('#fechaFvc').val();
                /*var hoy = new Date();
                if(fechaFvc < hoy){
                    showError('Seleccione una fecha válida.');
                    return false;
                }*/
            }else if($('#decision_n').prop('checked')){
                decision = 2;
                fechaFvc = '00000000';
            }
            if(confirm('¿Está seguro de guardar los cambios?')){
                $.ajax({
                    type: "POST",
                    url: "admin/registroExportAction.php",
                    data: {folioAbd : folio,decisionFolio : decision,fechaFvcVal : fechaFvc,acc : 'guardar'},
                    success: function(response){
                        if(response == 1){
                            alert('Se guardó el registro con éxito.');
                            window.open('bandejas.php?mod=penres&acc=con','_parent');
                        }else{
                            showError(response);
                            return false;
                        }
                    },
                    error: function(){
                        showError('Error al guardar registro.');
                        return false;
                    }
                });
            }else{
                return false;
            }
        }else{
            showError('No es posible Exportar. Evaluado cómo Pendiente.');
            return false;
        }
    }else if(element == 'cancelar'){
        window.open('bandejas.php?mod=penres&acc=con','_parent');
    }
}
//
// Función para validar el Formulario de un Usuario Nuevo. *
function validarUsuarioForm()
{
    var formulario = document.form1;
    var msgError   = '';
    var flagError  = true;
    if(formulario.perfilSel.value == 0){
        msgError  = 'Se debe seleccionar un Perfil.';
        showError(msgError);
        flagError = false;
        formulario.perfilSel.focus();
        return false;
    }else if(formulario.nombre.value.length == 0){
        msgError  = 'Se debe escribir un Nombre.';
        showError(msgError);
        flagError = false;
        formulario.nombre.focus();
        return false;
    }else if(formulario.usuario.value.length == 0){
        msgError  = 'Se debe escribir un Usuario.';
        showError(msgError);
        flagError = false;
        formulario.usuario.focus();
        return false;
    }
    if(formulario.acc.value == 'form'){
        if(formulario.pass.value.length == 0){
            msgError = 'Debe escribir una Contraseña.';
            showError(msgError);
            flagError = false;
            formulario.pass.focus();
            return false;
        }
        if(formulario.pass.value.length == 10){
            if(formulario.passVol.value.length == 0){
                msgError = 'Debe volver a escribir la Contraseña.';
                showError(msgError);
                flagError = false;
                formulario.passVol.focus();
                return false;
            }else if(formulario.pass.value != formulario.passVol.value){
                msgError = 'Las contraseñas no coinciden, Verificar.';
                flagError = false;
                showError(msgError);
                return false;
            }
        }else{
            msgError = 'La contraseña debe ser de una longitud de 10 carácteres.';
            showError(msgError);
            flagError = false;
            return false;
        }
    }else{
        if(formulario.pass.value.length > 0){
            if(formulario.pass.value.length == 10){
                if(formulario.passVol.value.length == 0){
                    msgError = 'Debe volver a escribir la Contraseña para confirmarla.';
                    showError(msgError);
                    flagError = false;
                    return false;
                }else if(formulario.pass.value != formulario.passVol.value){
                    msgError = 'Las contraseñas no coinciden, Verificar.';
                    showError(msgError);
                    flagError = false;
                    return false;
                }
            }else{
                msgError = 'La contraseña debe ser de una longitud de 10 carácteres.';
                showError(msgError);
                flagError = false;
                return false;
            }
        }
    }
    if(flagError){
        if(confirm('¿Está seguro de guardar la Información?')){
            $.ajax({
                type: "POST",
                url: "admin/adminUserAction.php",
                data: {perfilSel : formulario.perfilSel.value,nombre : formulario.nombre.value,usuario : 
                formulario.usuario.value,passVol : formulario.passVol.value,acc : 'guardar',idUs : 
                formulario.idUser.value},
                success: function(response){
                    if(response == 1){
                        alert('Se guardó correctamente la Información del Usuario');
                        location.href = 'admin.php?mod=users&acc=con';
                    }else{
                        showError(response);
                        return false;
                    }
                },
                error: function(xhr,status,trn){
                        if(status == 'error'){
                            showError('Error al guardar la Información. Error Name: ' + trn);
                        }else if(status == 'timeout'){
                            showError('Error al guardar la Información Tiempo Excedido. Error Name: ' + trn);
                        }
                        return false;
                    }
            });
        }
    }
}
//
//
function showError(msg)
{
    $('#msg-notif-form').text(msg);
    $('#msg-notif-form').css('display','block');
    setTimeout(function() {  
        $('#msg-notif-form').fadeOut('slow', function() {
            $('#msg-notif-form').css('display','none');
            $('#msg-notif-form').text('');
        });
    },4000);
}
//
// Función para editar un Usuario. *
function editarUsuario(num)
{
    var formulario = document.form1;
    formulario.action = 'admin.php?mod=users&acc=edit&row=' + num;
    formulario.method = 'POST';
    formulario.submit();
}
//
// Función para cambiar el Estatus de un Usuario. *
function cambioEstatusUsuario(estatusVal,num)
{
    var idUser = $('#iduser_' + num).val();
    if(confirm('¿Está seguro de cambiar el estatus al Usuario?')){
        $.ajax({
            type: "POST",
            url: "admin/adminCambioEstatusAction.php",
            data: {estatus : estatusVal,acc : 'guardar',idUs : idUser},
            success: function(response){
                alert(response);
                location.href = 'admin.php?mod=users&acc=con';
            },
            error: function(){
                showError('Error al cambiar el Estatus del Usuario.');
                return false;
            }
        });
    }
}
//
// Función para guardar los cambios de la plantilla de Correo. *
function guardaPlantilla(opc)
{
    var nombrePlantilla;
    switch(opc){
        case 'evalaceptada':
            nombrePlantilla = 'evaluacionAceptada.inc';
            break;
        case 'evalrechazada':
            nombrePlantilla = 'evaluacionRechazada.inc';
            break;
        case 'evalpendiente':
            nombrePlantilla = 'evaluacionPendiente.inc';
            break;
        case 'penresacept':
            nombrePlantilla = 'pendienteRespuestaAceptado.inc';
            break;
        case 'penresrech':
            nombrePlantilla = 'pendienteRespuestaRechazado.inc';
            break;
        case 'cobranzatiempo':
            nombrePlantilla = 'cobranzaEnTiempo.inc';
            break;
        case 'cobranzademora':
            nombrePlantilla = 'cobranzaDemora.inc';
            break; 
    }
    if(confirm('¿Está seguro de guardar la Plantilla?')){
        $.ajax({
            type: "POST",
            url: "admin/guardaPlantillaAction.php",
            data: {plantilla : nombrePlantilla,cuerpo : $('#text-area').val(),acc : 'guardar'},
            success: function(response){
                if(response == 1){
                    alert('Se guardó la plantilla con éxito.');
                    window.open('admin.php?mod=tplcorreo&acc=con','_parent');
                }else{
                    showError(response);
                    return false;
                }
            },
            error: function(){
                showError('Error al guardar la Plantilla.');
                return false;
            }
        });
    }
}
//