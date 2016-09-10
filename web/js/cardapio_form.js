/**
 * Created by aryan on 08/09/16.
 */

console.log('teste');
$('#tableresult-produto').hide();

$("#btAddItem").on("click", function () {

    $("#item").clone().appendTo('#more');
    // $("#item").append("<div class=\"form-group\"> <label class=\"control-label\"></label><input  type=\"hidden\"  class=\"form-control\" name=\"Itemcardapio[idProduto][]\">    </div>").appendTo('#more');
    // $("#item").append("");
});

$('#btPesquisarPorProduto').click(function () {
    var
        produto = $('#busca-produto').val();

    if (produto.length > 0) {


        $.get('../produto/get-produtos', {busca: produto}, function (data) {

            var
                data = $.parseJSON(data);
            if (data != null) {
                console.log(data);

                $('#tableresult-produto').show();
                $('#tbody-result-produto').html('');


                data.forEach(function (item, index) {
                    console.log('item ' + item);
                    $('#tbody-result-produto').append(
                        '<tr><td>' + item.nome + '</td>' +

                        '<td><a href=\'#\'  ' +
                        'class=\'btn btn-success\'  onclick="selecionarProduto(\''+item.nome+'\',\''+item.idProduto+'\')" > <span class=\'glyphicon glyphicon-ok\'>' +
                        '</span></a ></td></tr>');

                });

            } else {
                data = null;
                $('#tableresult-produto').hide();
                $('#tbody-result-produto').html('');
                /* $('#result-messagem-busca-emprestimo-produto').attr('class', 'alert alert-danger');
                 $('#result-messagem-busca-emprestimo-produto').
                 html('Nenhum empréstimo encontrado');*/
            }
        });
    }
});

function selecionarProduto(nome,idProduto) {
    console.log('nome.: '+nome);
    console.log('idProduto.: '+idProduto);
    $("input[name='Itemcardapio[idProduto]']:text:last").val(nome);
    $("input[name='Itemcardapio[idProduto][]']:hidden:last").val(idProduto);
}

function remover(id) {
    console.log('id.: '+id);
    $('#itemcardapio'+id).empty();
}


function removerItemCardapio(element) {

    $(element).parent().empty();

}



