$( document ).ready(function() {
   
    ValidaCampos();

});

function Salvar(){
    var usuario = "";
    var senha = "";

    usuario = $('#txtLogin').val();
    senha = $('#txtPass').val();

    
    $.ajax({
        method: "POST",
        url: constAPIURL + "login",
        data: { usuario: usuario, senha: senha }
      })
        .done(function( msg ) {
          var retorno = jQuery.parseJSON(JSON.stringify(msg));
          
          if (!retorno.auth){
              alert("Usuário ou senha incorretos");
              $('#txtLogin').focus();
          }else{
            window.location.href = "home"
          }
          

        });

}
function ValidaCampos(){
    $("#frmLogin").validate({
        rules: {
            txtLogin: {
                required: true
            },
            txtPass:{
                required: true
            }
        },
        //For custom messages
        messages: {
            txtLogin: {
                required: "Informe o login."
            },
            txtPass:{
                required: "Informe a senha."
            }
        },
        submitHandler: function(form){
            Salvar(form);
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
