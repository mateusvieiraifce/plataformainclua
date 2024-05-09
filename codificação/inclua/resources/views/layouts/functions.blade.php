<script>
function formatarDocumento(campoTexto) {
    if (campoTexto.value.length <= 11) {
        campoTexto.value = mascaraCpf(campoTexto.value);
        return campoTexto.value;
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

function mascaraTelefone(campo) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    campo.value = campo.value.replace(/\D/g, '')
    //APLICA A MASCARA
    campo.value = campo.value.replace(/(\d{2})(\d{5})(\d{4})/g,"(\$1) \$2-\$3");
}

function validarDocumento(documento, tipoDocumento) {
    $.ajax({
        url: "https://api.invertexto.com/v1/validator?token=7689|ZyaIH60DAuou71VwqAriB0uovgXRHAKv&value="+documento+"&type="+tipoDocumento+"",
        method: 'GET',
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
    }).done(function(result) {
        console.log(result)
    });
}

function mascaraCep(cep) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    cep.value = cep.value.replace(/\D/g, '')
    //APLICA A MASCARA
    cep.value = cep.value.replace(/(\d{5})(\d{3})/g,"\$1-\$2");
}

function validarCep(cep) {
    $.ajax({
        url: "https://viacep.com.br/ws/"+cep+"/json/",
        type: "GET",
        dataType: "json", 
        success: function(response) {
            console.log(response)
            document.getElementById('cidade').value = response.localidade
            document.getElementById('bairro').value = response.bairro
        },
        error: function(jqXHR, textStatus, errorThrown) {
            return false;
        }
    });
}

//FUNÇÃO PARA ACEITAR APENAS NUMEROS NO INPUT
const input = document.querySelector('.only-numbers');
input.addEventListener('input', (event) => {
    // Remove todos os caracteres que não são um dígito de 0-9
    event.target.value = event.target.value.replace(/\D/g, '');
});
</script>