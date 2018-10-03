$( document ).ready(function() {
    

    ValidaCampos();
    CarregarTela();

    $('#cboTIPOSEGURANCA').on('contentChanged', function() {
        $(this).material_select();
    });
});

function CarregarTela(){
    $.getJSON(constAPIURL + 'parametros/email/listar', function (dados){

        if(dados.length > 0){

            dados = dados[0];

            $('#txtSMTP').val(dados.SMTP);
            $('#txtPORTA').val(dados.PORTA);
            $('#txtEMAIL').val(dados.EMAIL);
            $('#txtSENHA').val(dados.SENHA);
           
            $('#txtNOMEEXIBICAO').val(dados.NOMEEXIBICAO);
            $('#txtEMAILEXIBICAO').val(dados.EMAILEXIBICAO);
            $('#chkREQUER_AUTENTICACAO').attr('checked', (dados.REQUER_AUTENTICACAO == 1 ? true : false));
            $('#chkENVIAHTML').attr('checked', (dados.ENVIAHTML == 1 ? true : false))
            
            $('#cboTIPOSEGURANCA').val(dados.TIPOSEGURANCA);
            
            $('#cboTIPOSEGURANCA').trigger('contentChanged');
        
        }
       

     });


}
function Salvar(form){

       var formdata =  new FormData($("#frmParamEmail")[0]); 
        $.ajax({  
			method: "POST",
            url: constAPIURL + "parametros/email/salvar",
            data: formdata,
            processData: false,
            contentType: false,
			beforeSend: function () {
                $('#btnSalvar').prop('disabled', true);
            },
            success: function(retorno){
                $('#btnSalvar').prop('disabled', false);
                retorno=retorno.retorno;
                if(retorno === 'Ok'){
                    Retorno("Parâmetros atualizado com sucesso!", true);        
                    CarregarTela();
                }else{
                    Retorno(retorno, false);
                }
                
            }
        }); 

}

function Retorno(texto, sucesso){

    if (sucesso === true){
        divMensagem = $('#card-alert');
        divMensagem.removeAttr('class');
        divMensagem.addClass('card green lighten-5');
        
        $("#texto p").removeAttr('class');
        $("#texto p").addClass('green-text');
        $("#texto p").html(texto);   
        
        
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
    $("#frmParamEmail").validate({
        rules: {
            txtSMTP: {
                required: true
            },
            txtPORTA: {
                required: true,
                number: true
            },
            txtEMAIL: {
                required: true,
                email:true
            },
            txtSENHA: {
                required: true
            },
            cboTIPOSEGURANCA: {
                required: true
            },
            txtNOMEEXIBICAO: {
                required: true
            },
            txtEMAILEXIBICAO: {
                required: true,
                email:true
            }
        },
        //For custom messages
        messages: {
            txtSMTP: {
                required: "Informe o servidor SMTP"
            },
            txtPORTA: {
                required: "Informe a porta do servidor SMTP",
                number: "Porta inválida"
            },
            txtEMAIL: {
                required: "Informe o e-mail de autenticação",
                email: "O e-mail deve ter o seguinte formato nome@dominio.com.br"
            },
            txtSENHA: {
                required: "Informe a senha"
            },
            cboTIPOSEGURANCA: {
                required: "Informe o tipo de segurança"
            },
            txtNOMEEXIBICAO: {
                required: "Informe o nome de exibição"
            },
            txtEMAILEXIBICAO: {
                required: "Informe o e-mail de exibicação",
                email: "O e-mail deve ter o seguinte formato nome@dominio.com.br"
            }
            /*
            nome:{
                required: "Informe o nome",
                minlength: "Deve conter no mínimo 5 caracteres"
            },
            email: {
                required: "Informe o e-mail",
                email: "O e-mail deve ter o seguinte formato nome@dominio.com.br"
              }
            */
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

