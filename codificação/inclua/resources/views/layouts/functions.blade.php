<script>
//FUNÇÃO ORQUESTRADORA DAS MASCARA DE DOCUMENTO
function formatarDocumento(campoTexto) {
    if (campoTexto.value.length <= 11) {
        campoTexto.value = mascaraCpf(campoTexto.value);
        return campoTexto.value;
    } else {
        campoTexto.value = mascaraCnpj(campoTexto.value);
    }
}

//FUNÇÃO PARA RERTIRAR MARCARA DO DOCUMENTO
function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
}

//FUNÇÃO PARA ADICINAR MARCARA DO CPF
function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
}

//FUNÇÃO PARA ADICINAR MARCARA DO CNPJ
function mascaraCnpj(valor) {
    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
}

//FUNÇÃO PARA ADICINAR MARCARA DO TELEFONE
function mascaraTelefone(campo) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    campo.value = campo.value.replace(/\D/g, '')
    //APLICA A MASCARA
    campo.value = campo.value.replace(/(\d{2})(\d{5})(\d{4})/g,"(\$1) \$2-\$3");
}

//FUNÇÃO PARA VALIDAÇÃO DO DOCUMENTO
function validarDocumento(documento, tipoDocumento) {
    $.ajax({
        url: "https://api.invertexto.com/v1/validator?token={{env('TOKEN_API_VALIDATOR_DOCUMENTO')}}&value="+documento+"&type="+tipoDocumento+"",
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.valid === false) {
                $("#modal-aviso-title").text("CPF inválido")
                $("#modal-aviso-message").text("Verifique se o seu CPF foi digitado corretamente.")
                $("#modal-aviso").modal()
            }
        }
    });
}

//FUNÇÃO PARA ADICINAR MARCARA DO CEP
function mascaraCep(cep) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    cep.value = cep.value.replace(/\D/g, '')
    //APLICA A MASCARA
    cep.value = cep.value.replace(/(\d{5})(\d{3})/g,"\$1-\$2");
}

//FUNÇÃO DE VALIDAÇÃO DE CEP
function validarCep(cep) {
    $.ajax({
        url: "https://viacep.com.br/ws/"+cep+"/json/",
        type: "GET",
        dataType: "json", 
        success: function(response) {
            if (response.erro) {
                $("#modal-aviso-title").text("CEP inválido")
                $("#modal-aviso-message").text("Verifique se o seu CEP foi digitado corretamente.")
                $("#modal-aviso").modal()
            } else {
                document.getElementById('cidade').value = response.localidade
                document.getElementById('estado').value = response.uf
                document.getElementById('endereco').value = response.logradouro
                document.getElementById('bairro').value = response.bairro
            }
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