$( document ).ready(function() {

    ValidaCampos();
    LimpaCampos();

    //$("#frmNovoConvite").submit(function(event) {
        //event.preventDefault();
        //Salvar();
    //});

});

function Salvar(){
    //if(ValidaCampos()){
       //constAPIURL
    

        var nome = '';
        var mensagem = '';
        var email = '';

        nome = $('#nome').val();
        mensagem = $('#mensagem').val();
        email = $('#email').val();
        
        $.ajax({  
			method: "POST",
            url: constAPIURL + "convites/salvar",
            data: { nome: nome, email: email, mensagem: mensagem },
			beforeSend: function () {
                $('#btnEnviar').prop('disabled', true);
            },
            success: function(retorno){
                $('#btnEnviar').prop('disabled', false);
                retorno=retorno.retorno;
                if(retorno === 'Ok'){
                    Retorno("Sucesso!!! Convite enviado com sucesso para o e-mail "+email+".", true);        
                }else{
                    Retorno(retorno, false);
                }
            }
        }); 
	//}
}

function Retorno(texto, sucesso){

    if (sucesso === true){
        divMensagem = $('#card-alert');
        divMensagem.removeAttr('class');
        divMensagem.addClass('card green lighten-5');
        
        $("#texto p").removeAttr('class');
        $("#texto p").addClass('green-text');
        $("#texto p").html(texto);   
        
        LimpaCampos();
    }else{
        divMensagem = $('#card-alert');
        divMensagem.removeAttr('class');
        divMensagem.addClass('card red lighten-5');
        
        $("#texto p").removeAttr('class');
        $("#texto p").addClass('red-text');
        $("#texto p").html(texto);   
    }

}

function ValidaCampos(){
    $("#frmNovoConvite").validate({
        rules: {
            nome: {
                required: true
            },
            email: {
                required: true,
                email:true
            },
            mensagem: {
				required: false
			}
        },
        //For custom messages
        messages: {
            nome:{
                required: "Informe o nome",
                minlength: "Deve conter no mínimo 5 caracteres"
            },
            email: {
                required: "Informe o e-mail",
                email: "O e-mail deve ter o seguinte formato nome@dominio.com.br"
              }
        },
        submitHandler: function(form){
            Salvar();
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

function LimpaCampos(){
    $('#nome').val('');
    $('#mensagem').val('');
    $('#email').val('');
    $('#nome').focus();
}