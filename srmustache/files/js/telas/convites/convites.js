$( document ).ready(function() {

    CarregarGrid();

    ValidaCampos();

    //CarregarPorDataTable();

});

function CarregarPorDataTable(){
    $("#grid").DataTable({
        ajax: {
            url: constAPIURL + "convites/listar",
            dataSrc: ''
        },
        columns: [
            { data: "CONVITEID" },
            { data: "NOME" },
            { data: "EMAIL" },
            { data: "MENSAGEM" },
            { data: "TOKEN" }
            
        ]
    });
}
function CarregarGrid(){
  
    
    // Carregando grid
    $("#gridConvites").jsGrid({
        width: "100%",
        height: "450px",
        autoload: true,
        heading: true,
        sorting: true, 

        paging: true,
        //pagerContainer: $(".pagination"),
        pageIndex: 1,
        pageSize: 10,
        pageButtonCount: 20,
        pagerFormat: "Páginas: {first} {prev} {pages} {next} {last}", //    {pageIndex} de {pageCount}",
        pagePrevText: "<",
        pageNextText: ">",
        pageFirstText: "<<",
        pageLastText: ">>",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",

        //filtering : true,

        noDataContent: "Nenhum convite enviado até o momento.",
        controller: {
            loadData: function (filter) {
                var data = $.Deferred();
                $.ajax({
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    url: constAPIURL + "convites/listar",
                    dataType: "json"
                }).done(function(response){
                    data.resolve(response);
                });
                return data.promise();
            }
        },
        
        rowClick: function(args) { alert(args); },
        fields: [
            { title: "Id", name: "CONVITEID", type: "text", width: 20 },
            { title: "Nome", name: "NOME", type: "text", width: "150px" },
            { title: "E-mail", name: "EMAIL", type: "text", width: 150 },
            //{ title: "Token", name: "TOKEN", type: "datetime", width: 200 },
            { title: "Mensagem", name: "MENSAGEM", type: "datetime", width: 80 },
            { title: "F", type: "control" }
        ]
    });

   
}

function ValidaCampos(){
    $("#frmNovoConvite").validate({
        rules: {
            uname: {
                required: true,
                minlength: 5
            },
            cemail: {
                required: true,
                email:true
            },
            password: {
				required: true,
				minlength: 5
			},
			cpassword: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			curl: {
                required: true,
                url:true
            },
            crole:"required",
            ccomment: {
				required: true,
				minlength: 15
            },
            cgender:"required",
			cagree:"required",
        },
        //For custom messages
        messages: {
            uname:{
                required: "Enter a username",
                minlength: "Enter at least 5 characters"
            },
            curl: "Enter your website",
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        }
     });
     
}
