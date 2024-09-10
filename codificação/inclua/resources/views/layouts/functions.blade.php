<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
    //FUNÇÃO PARA ADICINAR MARCARA DO TELEFONE
    function mascaraTelefone(campo) {
        //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
        campo.value = campo.value.replace(/\D/g, '')
        //APLICA A MASCARA
        campo.value = campo.value.replace(/(\d{2})(\d{4})(\d{4})/g,"(\$1) \$2-\$3");
    }

    //FUNÇÃO PARA ADICINAR MARCARA DO CELULAR
    function mascaraCelular(campo) {
        //REMOVE A EXISTENCIA DE ALGUM CARACTERE ESPECIAL
        campo.value = campo.value.replace(/\D/g, '')
        //APLICA A MASCARA
        campo.value = campo.value.replace(/(\d{2})(\d{5})(\d{4})/g,"(\$1) \$2-\$3");
    }

    //FUNÇÃO PARA RERTIRAR MARCARA DO DOCUMENTO
    function retirarFormatacao(campo) {
        return campo.value.replace(/(\.|\/|\-)/g,"");
    }

    function mascaraCpf(campo) {
        $("#"+campo.id).mask("000.000.000-00");
    }

    function mascaraCnpj(campo) {
        $("#"+campo.id).mask("00.000.000/0000-00");
    }

    //FUNÇÃO PARA VALIDAÇÃO DO DOCUMENTO
    function validarCPF(campo) {
        $.ajax({
            url: "https://api.invertexto.com/v1/validator?token={{env('TOKEN_API_VALIDATOR_DOCUMENTO')}}&value="+campo.value+"&type=cpf",
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

    //FUNÇÃO PARA CONSULTAR CNPJ
    function consultarCNPJ(campo) {
        let cnpj = retirarFormatacao(campo)
        $.ajax({
            url: "https://api.invertexto.com/v1/cnpj/"+cnpj+"?token={{env('TOKEN_API_VALIDATOR_DOCUMENTO')}}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#nome_fantasia').val(response.nome_fantasia)
                $('#razao_social').val(response.razao_social)
            },
            error: function(error) {
                nowuiDashboard.showNotification('top', 'right', 'CNPJ inválido! Verifique se o seu CNPJ foi digitado corretamente.', 'danger');
                document.getElementById(campo.id).value = ''
                document.getElementById(campo.id).focus()
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
                
                if(document.getElementById('instituicao')) {
                    document.getElementById('instituicao').value = response.BIN.issuer.name
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
    var input = document.getElementsByClassName('only-numbers');
    if (input.length) {
        for (let i = 0; i < input.length; i++) {
            input[i].addEventListener('input', (event) => {
                // Remove todos os caracteres que não são um dígito de 0-9
                event.target.value = event.target.value.replace(/\D/g, '');
            });
        }
    }
</script>