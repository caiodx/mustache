$( document ).ready(function() {

    CarregarGrid();    

});

function CarregarGrid(){


    var grid = $('#gridProdutos').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": constAPIURL + "produtos/listar",
            "type": "GET"
        },
        "columns": [
            { "data": "id" },
            { "data": "base" },
            { "data": "especificacao" },
            { "data": "classe" }          
        ]
    } );

    grid.on('user-select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            var data = table.rows( indexes ).data().pluck( 'id' );
            alert("id")
     
            // do something with the ID of the selected items
        }
    } );
  
    // so copiar o metodo carregar grid e mudar o id da grid, e o caminho do post
    // Carregando grid
    // $("#gridProdutos").jsGrid({
    //     width: "100%",
    //     height: "100%",
    //     autoload: true,
    //     //heading: true,
    //     //sorting: true,
    //     paging: true,
    //     pageLoading: true,
    //     //pagerContainer: $(".pagination"),
    //     pageIndex: 1,
    //     pageSize: 15,
    //     pageButtonCount: 2000,
    //     pagerFormat: "Páginas: {first} {prev} {pages} {next} {last}", //    {pageIndex} de {pageCount}",
    //     pagePrevText: "<",
    //     pageNextText: ">",
    //     pageFirstText: "<<",
    //     pageLastText: ">>",
    //     pageNavigatorNextText: "...",
    //     pageNavigatorPrevText: "...",
        

    //     noDataContent: "Sem produtos cadastrados até o momento.",
    //     controller: {
    //         loadData: function (filter) {
    //             var data = $.Deferred();
    //             $.ajax({
    //                 type: "GET",
    //                 contentType: "application/json; charset=utf-8",
    //                 url: constAPIURL + "produtos/listar",
    //                 dataType: "json"
    //             }).done(function(response){

    //                 var retorno =  {
    //                     data          : response,
    //                     itemsCount    : response.lenght
    //                 }

    //                 data.resolve(retorno);
    //             });

    //             return data.promise();

    //             // var startIndex = (filter.pageIndex - 1) * filter.pageSize;
    //             // return {
    //             //     data: response.slice(startIndex, startIndex + filter.pageSize),
    //             //     itemsCount: response.length
    //             // };
    //         }
    //     },
        
    //     rowClick: function(args) {
    //          window.location.href += "/" + args.item.id
    //         }, 
    //     fields: [ /// campos da tabela.. name é campo na tabela. e title é o headertext
    //         { title: "Id", name: "id", type: "int", width: 20 },
    //         { title: "Base", name: "base", type: "text", width: 50 },
    //         { title: "Nome", name: "especificacao", type: "text", width: "150px" },            
    //         { title: "Classe", name: "classe", type: "text", width: 150 },
    //         { title: "F", type: "control" } //tenho que estudar isso q é o editar e excluir
    //     ]
    // });

   
}

