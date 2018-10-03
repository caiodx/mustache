var constAPIURL = "/mustache_novo/mustache_api/";
var constAPIURL_APP = window.location.origin + "/mustache_novo/srmustache"

//Rota
var root = constAPIURL_APP;
var useHash = true; // Defaults to: false
var hash = '#!'; // Defaults to: '#'
var router = new Navigo(root, useHash, hash);


function aviso(texto){
    alert(texto);
}

function validaEmail(email){
    var sEmail	= email;
    // filtros
    var emailFilter=/^.+@.+\..{2,}$/;
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
    // condição
    if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)){
        return false;
    }else{
        return true;
    }    
}

function validarCPF(cpf) {
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;

    add = 0;

    for (i = 0; i = 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    add = 0;
            for (i = 0; i = 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10))){
        return false;
    }
    return true;


}
