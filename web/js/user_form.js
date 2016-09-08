/**
 * Created by aryan on 01/09/16.
 */

var selecionados = $('select').val();

if (selecionados == null) {
    selecionados = [];
}


var permissoes = [];


console.log('selecionados: ' + selecionados);

//Selecionando as permissões
$('select').on('select2:select', function (evt) {
    var selecionado = evt.params.data.id;





    if (selecionado.indexOf("-") <= -1) {
        permissoes = nomeiaPermissoes(selecionado);

        permissoes.forEach(function (item) {
            selecionados.push(item);
        });

        atualizaSelect(selecionados);


    }     else {
        console.log('selecionado: ' + selecionado);
        selecionados.push(selecionado);
        atualizaSelect(selecionados);
    }

    console.log('selecionados: ' + selecionados);
    console.log('$(this).val(): ' + $(this).val());
});


//Deselecionando as permissões
$('select').on('select2:unselect', function (evt) {
    var deselecionado = evt.params.data.id;
    var deselecionados = [];

    console.log('deselecionado: ' + deselecionado);

    /*if (deselecionado == "caixa") {

        permissoes = nomeiaPermissoes("caixa");

        permissoes.forEach(function (item) {
            deselecionados.push(item);
        });

        deselecionados.forEach(function (item) {
            selecionados.splice(selecionados.indexOf(item), 1);
        });


        atualizaSelect(selecionados);
    }*/
    if (deselecionado.indexOf("-") <= -1) {
        permissoes = nomeiaPermissoes(deselecionado);

        permissoes.forEach(function (item) {
            deselecionados.push(item);
        });

        deselecionados.forEach(function (item) {
            selecionados.splice(selecionados.indexOf(item), 1);
        });

        atualizaSelect(selecionados);


    }     else {

            selecionados.splice(selecionados.indexOf(deselecionado), 1);


        atualizaSelect(selecionados);
    }

    console.log('selecionados: ' + selecionados);
});

function nomeiaPermissoes(permissaoMacro) {
    var prefixos = ['index-', 'view-'
        , 'update-', 'create-', 'delete-'];

    var resultados = [];

    resultados.push(permissaoMacro);

    prefixos.forEach(function (item) {
        resultados.push(item + permissaoMacro);
    });

    return resultados;

}

function atualizaSelect(selecionadosSelect) {
    $('select').val(selecionadosSelect);
    $('select').trigger('change');
    // selecionados =  $('select').val();
}

$('select').click(function (e) {
    var selected = $(e.target).val();
    if (selected == 'all') {
        console.log('selected: ' + selected);
    }
});

$('.s2-select-label').click(function () {

    console.log('s2-select-label');


    $("#permissoes option").each(function () {
        selecionados.push($(this).val());
    });
    $('select').val(selecionados);
    console.log('selecionados: ' + selecionados);
});

$('.s2-unselect-label').click(function () {

    console.log('s2-unselect-label');

    selecionados = [];

    $('select').val(selecionados);
    console.log('selecionados: ' + selecionados);
});

/*
$('select').change(function() {
    var selected = $(':selected', this);
    alert(selected.parent().attr('label'));
    alert(selected.closest('optgroup').attr('label'));
});*/
