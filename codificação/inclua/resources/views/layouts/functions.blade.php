<script>
//FUNÇÃO PARA ADICINAR MARCARA DO CELULAR
function mascaraCelular(campo) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    campo.value = campo.value.replace(/\D/g, '')
    //APLICA A MASCARA
    campo.value = campo.value.replace(/(\d{2})(\d{5})(\d{4})/g,"(\$1) \$2-\$3");
}

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
//FUNÇÃO PARA VALIDAÇÃO DO DOCUMENTO
function validarDocumento(campo, tipoDocumento) {
    $.ajax({
        url: "https://api.invertexto.com/v1/validator?token={{env('TOKEN_API_VALIDATOR_DOCUMENTO')}}&value="+campo.value+"&type="+tipoDocumento+"",
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.valid === false) {
                nowuiDashboard.showNotification('top', 'right', 'CPF inválido! Verifique se o seu CPF foi digitado corretamente.', 'danger');
                document.getElementById(campo.id).value = ''
                document.getElementById(campo.id).focus()
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
function validarCep(campo) {
    $.ajax({
        url: "https://viacep.com.br/ws/"+campo.value+"/json/",
        type: "GET",
        dataType: "json", 
        success: function(response) {
            if (response.erro) {
                nowuiDashboard.showNotification('top', 'right', 'CEP inválido! Verifique se o seu CEP foi digitado corretamente.', 'danger');
                document.getElementById(campo.id).focus()
            } else {
                document.getElementById('cidade').value = response.localidade
                document.getElementById('estado').value = response.uf
                document.getElementById('endereco').value = response.logradouro
                document.getElementById('bairro').value = response.bairro
            }
        },
        error: function(error) {
            nowuiDashboard.showNotification('top', 'right', 'CEP inválido! Verifique se o seu CEP foi digitado corretamente.', 'danger');
            document.getElementById(campo.id).focus()
        }
    });
}

function marcaraNumeroCartao(campo) {
    //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
    campo.value = campo.value.replace(/\D/g, '')
    //APLICA A MASCARA
    campo.value = campo.value.replace(/(\d{4})(\d{4})(\d{4})(\d{4})/g,"\$1 \$2 \$3 \$4");
}

function validarCartao(campo) {
    let numero_cartao = campo.value.replace(/\D/g, '')
    $.ajax({
        crossDomain: true,
        url: 'https://bin-ip-checker.p.rapidapi.com/?bin='+numero_cartao,
        method: 'POST',
        headers: {
            'content-type': 'application/json',
            'X-RapidAPI-Key': '{{env("X_RAPIDAPI_KEY")}}',
            'X-RapidAPI-Host': 'bin-ip-checker.p.rapidapi.com'
        },
        processData: false,
        success: function(response) {
            if (response.BIN.type != 'CREDIT') {
                nowuiDashboard.showNotification('top','right','Informe um cartão de crédito!','danger');
                document.getElementById(campo.id).value = ''
                document.getElementById(campo.id).focus();
            } else if (response.code != 200) {
                nowuiDashboard.showNotification('top','right','Cartão inválido! Verifique se o número do cartão foi digitado corretamente.','danger');
                document.getElementById(campo.id).value = ''
                document.getElementById(campo.id).focus();
            }
        },
        error: function(error) {
            nowuiDashboard.showNotification('top','right','Cartão inválido! Verifique se o número do cartão foi digitado corretamente.','danger');
            document.getElementById(campo.id).value = ''
            document.getElementById(campo.id).focus();
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