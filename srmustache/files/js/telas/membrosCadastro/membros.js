var token;

$(document).ready(function(){

    token = $('#token').val();

    $('#Erro').hide(); 
    $('#Formulario').hide();
    ValidarChave(token);

    AtivarWizard();
    MascarasDosCampos();

  
    $("#txtCEP").blur(function() {     
        CarregarCEP(this);
    });

    $('#cboUF').on('contentChanged', function() {
        $(this).material_select();
    });
    
});

function AtivarWizard(){

    //evento de quando troca
    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
       // alert("Você está no passo "+stepNumber+" agora");
        if(stepPosition === 'first'){
            $("#prev-btn").addClass('disabled');
        }else if(stepPosition === 'final'){
            $("#next-btn").addClass('disabled');
        }else{
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
        }
     });
 
     // Botoes extras
     var btnFinalizar = $('<button type="submit"></button>').text('Concluir')
     .addClass('btn btn-info')
     .on('click', function(){
            if( !$(this).hasClass('disabled')){
                var elmForm = $("#frmCadastro");
                if(elmForm){
                    Cadastrar();
                }
            }
        });
 
 
     // Ativar
     $('#smartwizard').smartWizard({
             selected: 0,
             theme: 'circles',
             transitionEffect:'fade',
             showStepURLhash: false,
             autoAdjustHeight:true,
 
             toolbarSettings: {toolbarPosition: 'bottom',
                               toolbarButtonPosition: 'right',
                               toolbarExtraButtons: [btnFinalizar]
                             },
             lang: {
                 next: "Próximo",
                 previous: "Anterior"
             }
     });


     $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        var elmForm = $("#passo-" + stepNumber);
        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if(stepDirection === 'forward' && elmForm){
            if (stepNumber === 0){
                $("#txtNome").focus();
                return ValidaCamposDadosCadastrais();           
            }else if (stepNumber === 1){
                $("#txtCartaoTitular").focus();
                return ValidaCamposDadosCartao();      
            }     
        }
        return true;
    });

    
}

function Cadastrar(){
    if(ValidaCamposDadosCadastrais() === false){
        return false;
    }
    
    if(ValidaCamposDadosCartao() === false){
        return false;
    }

    var formdata =  new FormData($("#frmCadastro")[0]); 
    $.ajax({  
        method: "POST",
        url: constAPIURL + "membros/autoCadastrar",
        data: formdata,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('sw-btn-prev').prop('disabled', true);
            $('#sw-btn-next').prop('disabled', true);
        },
        success: function(retorno){
            $('sw-btn-prev').prop('disabled', false);
            $('#sw-btn-next').prop('disabled', false);
            
            /*
            retorno=retorno.retorno;
            if(retorno === 'Ok'){
                Retorno("Parâmetros atualizado com sucesso!", true);        
                CarregarTela();
            }else{
                Retorno(retorno, false);
            }
            */
            
        }
    }); 
    return true;
}

function ValidaCamposDadosCartao(){

    if($.trim($('#txtCartaoTitular').val()) === ""){
        aviso("Informe o titular do cartao!");
        $('#txtCartaoTitular').focus();
        return false;
    }

    if($.trim($('#txtCartaoNumero').val()) === ""){
        aviso("Informe o número do cartão de crédito!");
        $('#txtCartaoNumero').focus();
        return false;
    }

    if($.trim($('#txtCartaoDataExpiracao').val()) === ""){
        aviso("Informe a data de expiração do cartão!");
        $('#txtCartaoDataExpiracao').focus();
        return false;
    }

    if($.trim($('#txtCartaoCVV').val()) === ""){
        aviso("Informe o código de segurança!");
        $('#txtCartaoCVV').focus();
        return false;
    }
    

    var dtExpiracao = $.trim($('#txtCartaoDataExpiracao').val());
    dtExpiracao = dtExpiracao.split("/");

    var mesExp = dtExpiracao[0];
    var anoExp = dtExpiracao[1];

    Iugu.setAccountID("74CACC80E1704419B03DA0A37BFD1241");
    Iugu.setTestMode(true);
    
    cc = Iugu.CreditCard($.trim($('#txtCartaoNumero').val()), 
                        mesExp, anoExp, $.trim($('#txtCartaoTitular').val()), 
                        "", $.trim($('#txtCartaoCVV').val()));
                     
   
    if(Iugu.utils.validateCreditCardNumber($.trim($('#txtCartaoNumero').val()))){
        aviso("Cartão de crédito inválido!");
        $('#txtCartaoNumero').focus();
        return false;
    }

    if(Iugu.utils.validateExpiration(mesExp, anoExp) === false){
        aviso("Data de expiração inválida!");
        $('#txtCartaoDataExpiracao').focus();
        return false;
    }
    

    return true;
}

function ValidaCamposDadosCadastrais(){
    
    if($.trim($('#txtNome').val()) === ""){
        aviso("Informe o seu nome completo!");
        $('#txtNome').focus();
        return false;
    }
    
    if($.trim($('#txtApelido').val()) === ""){
        aviso("Informe o apelido!");
        $('#txtApelido').focus();
        return false;
    }

    if($.trim($('#txtEmail').val()) === ""){
        aviso("Informe o e-mail!");
        $('#txtEmail').focus();
        return false;
    }

    if(validaEmail($.trim($('#txtEmail').val())) === false){
        aviso("Informe um e-mail válido!");
        $('#txtEmail').focus();
        return false;
    }
    

    if($.trim($('#txtDataNascimento').val()) === ""){
        aviso("Informe o data de nascimento!");
        $('#txtDataNascimento').focus();
        return false;
    }

    if($.trim($('#txtCPF').val()) === ""){
        aviso("Informe o CPF!");
        $('#txtCPF').focus();
        return false;
    }

    if($.trim($('#txtSenha').val()) === ""){
        aviso("Informe a senha!");
        $('#txtSenha').focus();
        return false;
    }

    return true;
}

function MascarasDosCampos(){
    //Dados cadastrais
    $('#txtCPF').formatter({
        'pattern': '{{999}}.{{999}}.{{999}}-{{99}}'
    });

    $('#txtCelular').formatter({
        'pattern': '({{99}}) {{99999}}-{{9999}}'
    });

    $('#txtCEP').formatter({
        'pattern': '{{99}}.{{999}}-{{999}}'
    });

    $('#txtDataNascimento').formatter({
        'pattern': '{{99}}/{{99}}/{{9999}}'
    });

    //Dados financeiros
    $('#txtCartaoNumero').formatter({
        'pattern': '{{9999}}-{{9999}}-{{9999}}-{{9999}}'
    });

    $('#txtCartaoDataExpiracao').formatter({
        'pattern': '{{99}}/{{9999}}'
    });
    
}

function ValidarChave(chave){
    try {


        $.getJSON(constAPIURL + 'convites/validarchave/' + chave, function (dados){
            //alert(dados.retorno);
            if(dados.retorno == "ok"){
                $('#Erro').hide(); 
                $('#Formulario').show();
                $("#txtNome").focus();

            }else{
                $('#Erro').show();
                $('#Formulario').hide();
            }
        });

    }catch(err) {
        return false;
    }
}

function LimpaCamposEndereco(){
    $("#txtBairro").val("");
    $("#txtCidade").val("");
    $("#txtComplemento").val("");
    $("#txtNumero").val("");
    $("#txtLogradouro").val("");
}

function CarregarCEP(cep){
    var cep = cep.value.replace(/\D/g, '');
    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if(validacep.test(cep)) {
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {                     
                    $("#txtBairro").val(dados.bairro);
                    $("#txtCidade").val(dados.localidade);
                    $("#txtLogradouro").val(dados.logradouro);
                    $("#txtComplemento").val(dados.complemento);
                    $('#cboUF').val(dados.uf);
            
                    $('#cboUF').trigger('contentChanged');
                    $("#txtNumero").focus();
                } 
                else {
                    LimpaCamposEndereco();
                }
            });
        }
        else {
            LimpaCamposEndereco();
        }
    } 
    else {
        LimpaCamposEndereco();
    }
}