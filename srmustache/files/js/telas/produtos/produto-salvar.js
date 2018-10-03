var id = "";

$( document ).ready(function() {

    CarregaClasses();
    ValidaCampos(); // quando abro a pagina do /novo eu ativo o validadte    
    TrataRota();
});


function TrataRota(){    

    //trata o carregamento do registro
    router
    .on('/produtos/:id', function (params) {

        if (!isNaN(params.id)){
            id = params.id;
            CarregarCamposProduto();
        }
        
    })
    .resolve();

}

function CarregarCamposProduto(){


    $.ajax({  
        method: "GET",
        url: constAPIURL + "produtos/carregar_produto",
        data: { id: id},
        beforeSend: function () {
           
        },
        success: function(retorno){
        
       
            if(retorno.ok == true){
                
                $("#especificacao").val(retorno.registros[0].especificacao);
                $("#classe").val(retorno.registros[0].classeid);
                $("#base").val(retorno.registros[0].base);
                $("#tipo").val(retorno.registros[0].tipo);
                
                $("#classe").trigger('contentChanged');
                $("#tipo").trigger('contentChanged');
               
            }else{
                $('#btnEnviar').prop('disabled', true);
                $('#excluir').prop('disabled', true);
                swal({
                    text: "Produto não encontrado",
                    icon: "warning"
                  });
                
            }
        },
        error : function(){            
            swal({
                text: "Erro ao carregar os dados!",
                icon: "error"
              });
        }
    });    

  


}


function Salvar(){

    if ($("#classe").val() == "" || $("#classe").val() == null){
        swal({
            text: "Selecione uma classe",
            icon: "info"
          });
        return;
    }

    if ($("#tipo").val() == "" || $("#tipo").val() == null){
        swal({
            text: "Selecione uma tipo",
            icon: "info"
          });
        return;
    }

    //salva os dados

    var descricao = $("#especificacao").val();
    var classe = $("#classe").val();
    var base = $("#base").val();
    var tipo = $("#tipo").val();

    $.ajax({  
        method: "POST",
        url: constAPIURL + "produtos/salvar",
        data: { descricao: descricao, classe: classe, base: base, tipo: tipo},
        beforeSend: function () {
            $('#btnEnviar').prop('disabled', true);
        },
        success: function(retorno){
            $('#btnEnviar').prop('disabled', false);
            retorno=retorno.retorno; //ja vem serializado pra mim. só copiar certinho la do controller que fiz.
            if(retorno === 'Ok'){
                swal({
                    text: "Dados salvos com sucesso!",
                    icon: "success"
                  });        
            }else{
                swal({
                    text: "Erro ao salvar os dados!",
                    icon: "error"
                  });
            }
        },
        error : function(){
            $('#btnEnviar').prop('disabled', false);
            swal({
                text: "Erro ao salvar os dados!",
                icon: "error"
              });
        }
    });    

}

function CarregaClasses(){

    var $select = $('#classe');
    var $tipo = $('#tipo');

    $select.on('contentChanged', function() {
        $(this).material_select();
    });
    
    $tipo.on('contentChanged', function() {
        $(this).material_select();
    });
    
    $.getJSON(constAPIURL + "produtos/carregar_classes", function(data){
        $.each(data, function(key, val){
            $select.append('<option value="' + val.classeid + '">' + val.classeid + ' - ' + val.descricao + '</option>');            
        })
        $select.trigger('contentChanged');
    });

   
}

function ValidaCampos(){
    $("#frmNovoProduto").validate({
        rules: {
            especificacao: {
                required: true,
                maxlength: 100
            },
            classe: {
                required: true
            },
            base: {
				required: true,
                maxlength: 20
			},
            tipo: {
				required: true
			}
        },
        //For custom messages
        messages: {
            especificacao:{
                required: "Informe a especificação",
                maxlength: "Deve conter no máximo 100 caracteres"
            },
            base: {
                required: "Informe a base",
                maxlength: "Deve conter no máximo 20 caracteres"
              }
        },
        submitHandler: function(form){
            Salvar(); // depois que validar tudo ele entra aqui no salvar saqiesacou 
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

function Excluir(){
    swal({
        text: "Produto excluído com sucesso.",
        icon: "success"
      });

      $("#produtos_lista").click();

      return false;

      
}





