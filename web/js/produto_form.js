/**
 * Created by aryan on 22/11/16.
 */


function verificaCompraProduto(element) {
    var idProduto = (element.value);

    if(idProduto != 0 && idProduto != ''){
        $.get('../produto/get-compra-produto', {
            idProduto: idProduto
        }, function (data) {

            // var data = $.parseJSON(data);
            console.log(data);
            if (data == 'false') {

                alert('O insumo escolhido não possui compra registrada, logo não se poderá fazer o cálculo de custo do Produto Venda.' +
                    'Para resolver isso, faça o registro da compra do insumo escolhido');


            }


        });
    }

}