/**
 * Created by aryan on 01/09/16.
 */

var selecionados = [];

$('select').on('select2:select', function (evt) {
    var selecionado = evt.params.data.id;

    if (selecionado == "caixa") {
        selecionados.push('caixa', 'index-caixa', 'view-caixa', 'update-caixa', 'create-caixa', 'delete-caixa');
    }

    if (selecionado == "relatorio") {
        selecionados.push('relatorio', 'index-relatorio', 'view-relatorio'
            , 'update-relatorio', 'create-relatorio', 'delete-relatorio');
    }

    $(this).val(selecionados);

});



