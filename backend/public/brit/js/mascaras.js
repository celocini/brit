// CNPJ e CPF
function formatarCampo(campoTexto) {
    if (campoTexto.value.length <= 11) {
        campoTexto.value = mascaraCpf(campoTexto.value);
    } else {
        campoTexto.value = mascaraCnpj(campoTexto.value);
    }
}
function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
}
function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
}
function mascaraCnpj(valor) {
    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
}
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
// CEP
function formatarCep(campoTexto) {
    campoTexto.value = mascaraCep(campoTexto.value);
}

function mascaraCep(valor) {
    return valor.replace(/(\d{5})(\d{3})/g,"\$1\-\$2");
}

function retirarFormatacaoCep(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\-)/g,"");
}

// Telefone e Celular
function formatarTelefone(campoTexto) {
    campoTexto.value = mascaraTelefone(campoTexto.value);
}

function mascaraTelefone(valor) {
    return valor.replace(/(\d{2})(\d{5})(\d{4})/g,"\(\$1\)\$2\-\$3");
}

function retirarFormatacaoTelefone(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\(|\)|\-)/g,"");
}