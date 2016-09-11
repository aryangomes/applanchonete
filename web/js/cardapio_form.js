/**
 * Created by aryan on 08/09/16.
 */


$("#btAddItem").on("click", function () {

    $("#item").clone().appendTo('#more');


});


function remover(id) {

    $('#itemcardapio'+id).empty();
}


function removerItemCardapio(element) {

    $(element).parent().empty();

}

function funcao1(element) {
    var idProduto = +element.value;
// console.log('element.: '+valorElemento);
//     console.log('element.: '+$(element).parent().css());
    var elemento = $(element).parent().parent().parent();
    // console.log('bro.:'+elemento.text("changed"));
    console.log('elemento.:'+elemento.toString());
  // $("div:last img",elemento).attr("src","http://www.monolitonimbus.com.br/wp-content/uploads/2016/01/banana-dancando.gif");
    // $(element).parent().parent().parent().empty();
    // $(elemento+ ' div:last').text("changed");

    $.get('get-foto-produto', {idProduto: idProduto
    }, function (data) {

           var data = $.parseJSON(data);
//         console.log(data);
        if (data != 'false') {
            if(data != null){
                $("div:last img",elemento).attr("src",
                'data:image/jpeg;base64,'+data);
            }


        } else {


        }

    });
}



