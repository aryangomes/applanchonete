/**
 * Created by aryan on 08/09/16.
 */


$("#btAddItem").on("click", function () {

    $("#item").clone().appendTo('#more');


});


function remover(id) {

    $('#itemcardapio'+id).removeClass('divborda').empty();
}


function removerItemCardapio(element) {

    $(element).parent().removeClass('divborda').empty();

}

function mudarFoto(element) {

    var idProduto = +element.value;

    var elementoImg = $(element).parent().parent().parent();
    // var elementoImg = $(element).parent().parent();
    console.log(elementoImg);
    $.get('get-foto-produto', {idProduto: idProduto
    }, function (data) {

           var data = $.parseJSON(data);

        if (data != 'false') {
            if(data[1] != ""){
                console.log(data);
                $("div:last img",elementoImg).attr("src",
                'data:image/jpeg;base64,'+data[1]);
                $("div:last img",elementoImg).attr("alt",
                    data[0]);
            }else{
                $("div:last img",elementoImg).attr("src",
                  "/applanchonete/web/imgs/semfoto.jpg");
                $("div:last img",elementoImg).attr("alt","Sem foto cadastrada");
            }


        } else {


        }

    });
}



