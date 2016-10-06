/**
 * Created by aryan on 14/09/16.
 */

$('#btCadastrarNovoProduto').click(function () {

    var nomeProduto = $('#produto-nome').val();
    var qtdMinimaProduto = $('#produto-quantidademinima').val();
    var categoriaProduto = $('#produto-idcategoria').val();
    var validacao = true;

    if(nomeProduto.length <= 0){
        alert('Digite o nome do produto');
        validacao = false;
    }

    if(qtdMinimaProduto.length <= 0){
        alert('Digite o estoque mínimo do produto');
        validacao = false;
    }

    if(categoriaProduto.length <= 0){
        alert('Escolha a categoria do  produto');
        validacao = false;
    }

    if(validacao){



    $.get('../produto/cadastrar-novo-produto', {nome:nomeProduto,
        categoria:categoriaProduto,
        estoqueMinimo:qtdMinimaProduto
    }, function (data) {

        // var data = $.parseJSON(data);
        console.log(data);
        if (data != 'false') {
            $.get('../produto/get-produto' , function (data) {
                console.log(data);
                var data = $.parseJSON(data);
                var $el = $(".compra-form select");
                $el.empty(); // remove old options
                $.each(data, function(key,value) {
                    $el.append($("<option></option>")
                        .attr("value", value).text(key));
                });

            });
            alert('Novo produto cadastrado com sucesso. Agora você pode fechar essa janela.');
        } else {

          alert('Não foi possível cadastrar o novo produto');
        }



    });
    } else {

        alert('Não foi possível cadastrar o novo produto. Verifique os dados.');
    }


});

$('#btnadprodutocompra').click(function () {
    $.get('../produto/get-produto' , function (data) {
        console.log(data);
        var data = $.parseJSON(data);
        var $el = $(".compra-form select");
        $el.empty(); // remove old options
        $.each(data, function(key,value) {
            $el.append($("<option></option>")
                .attr("value", value).text(key));
        });

    });
});


