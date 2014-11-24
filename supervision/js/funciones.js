/*
Versión 1.0 Nov-14
Funciones JavaScript - Perfil Supervisores
Elaboró: Alfredo Rodríguez Carrillo
*/
// Función para validar el Formulario de la Bandeja de las solicitudes por Área. *
function validarBandejaFiltro(){
    var formulario = document.formBandeja;
    if(formulario.fechaInicio.value.length == 0){
        showError('Seleccione una Fecha de Inicio.');
        return false;
    }else if(formulario.fechaFin.value.length == 0){
        showError('Seleccione una Fecha de Fin.');
        return false;
    }
    formulario.action = 'menu.php?mod=filtro';
    formulario.method = 'POST';
    formulario.acc.value = 'con';
    formulario.submit();
}
//
// Función para validar el Formulario de la Consulta de Reportes. *
function validarReporteForm(){
    if(document.formRep.fechaInicio.value.length == 0){
        showError('Seleccione una Fecha de Inicio.');
        return false;
    }else if(document.formRep.fechaFin.value.length == 0){
        showError('Seleccione una Fecha de Fin.');
        return false;
    }else if(document.formRep.areasSel.value == 0){
        showError('Seleccione una Área.');
        return false;
    }else if(document.formRep.slaSel.value == 0){
        showError('Seleccione una Área.');
        return false;
    }
    document.formRep.action = 'reportes.php?mod=reportes';
    document.formRep.method = 'POST';
    document.formRep.acc.value = 'con';
    document.formRep.submit();
}
//
//
function validarReporte(){

}
//