/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



var tipo = $("#conta-tipoconta").val();
console.log(tipo.length);
if (tipo.length == 0) {
    $("[class=\'form-group field-contasapagar-datavencimento\']").hide();
    $("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
    $("[class=\'form-group field-contasareceber-datahora\']").hide();
    $("[class=\'form-group field-custofixo-consumo\']").hide();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").hide();
}

if (tipo == 'contasapagar') {
    $("[class=\'form-group field-contasapagar-datavencimento\']").show();
    $("[class=\'form-group field-contasapagar-situacaopagamento required\']").show();
    $("[class=\'form-group field-contasapagar-datavencimento\']").prop('disabled', false);
    $("#contasapagar-situacaopagamento").prop('disabled', false);
    $("[class=\'form-group field-contasareceber-datahora\']").hide();
    $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', true);
    $("[class=\'form-group field-custofixo-consumo\']").hide();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").hide();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', true);
    $("[class=\'form-group field-custofixo-consumo\']").prop('disabled', true);

} else if (tipo == 'contasareceber') {
    $("[class=\'form-group field-contasapagar-datavencimento\']").hide();
    $("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
    $("[class=\'form-group field-contasapagar-datavencimento\']").prop('disabled', true);
    $("#contasapagar-situacaopagamento").prop('disabled', true);
    $("[class=\'form-group field-contasareceber-datahora\']").show();
    $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', false);
    $("[class=\'form-group field-custofixo-consumo\']").hide();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").hide();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', true);
    $("[class=\'form-group field-custofixo-consumo\']").prop('disabled', true);

} else if (tipo == 'custofixo') {

    $("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
    $("#contasapagar-situacaopagamento").prop('disabled', true);
    $("[class=\'form-group field-contasareceber-datahora\']").hide();
    $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', true);
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', false);
    $("[class=\'form-group field-custofixo-consumo\']").prop('disabled', false);
    $("[class=\'form-group field-custofixo-consumo\']").show();
    $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").show();
    $("[class=\'form-group field-contasapagar-datavencimento\']").show();
}

$("#conta-tipoconta").change(function () {
    tipo = $("#conta-tipoconta").val();
    console.log(tipo);
    if (tipo == 'contasapagar') {
        $("[class=\'form-group field-contasapagar-datavencimento\']").show();
        $("[class=\'form-group field-contasapagar-situacaopagamento required\']").show();
        $("[class=\'form-group field-contasapagar-datavencimento\']").prop('disabled', false);
        $("#contasapagar-situacaopagamento").prop('disabled', false);
        $("[class=\'form-group field-contasareceber-datahora\']").hide();
        $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', true);
        $("[class=\'form-group field-custofixo-consumo\']").hide();
        $("[class=\'form-group field-custofixo-consumo\']").prop('disabled', true);
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").hide();
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', true);
        $("[class=\'form-group field-custofixo-consumo required\']").prop('disabled', true);

    } else if (tipo == 'contasareceber') {
        $("[class=\'form-group field-contasapagar-datavencimento\']").hide();
        $("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
        $("[class=\'form-group field-contasapagar-datavencimento\']").prop('disabled', true);
        $("#contasapagar-situacaopagamento").prop('disabled', true);
        $("[class=\'form-group field-contasareceber-datahora\']").show();
        $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', false);
        $("[class=\'form-group field-custofixo-consumo\']").hide();
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', true);
        
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").hide();
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', true);
        $("[class=\'form-group field-custofixo-consumo required\']").prop('disabled', true);

    } else if (tipo == 'custofixo') {

        $("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
        $("#contasapagar-situacaopagamento").prop('disabled', true);
        $("[class=\'form-group field-contasareceber-datahora\']").hide();
        $("[class=\'form-group field-contasareceber-datahora\']").prop('disabled', true);
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").prop('disabled', false);
        $("[class=\'form-group field-custofixo-consumo\']").prop('disabled', false);
        $("[class=\'form-group field-custofixo-consumo\']").show();
        $("[class=\'form-group field-custofixo-tipocustofixo_idtipocustofixo\']").show();
        $("[class=\'form-group field-contasapagar-datavencimento\']").show();
    }
});