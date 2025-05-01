@component('mail::message')
    <table width="570" cellpadding="0" cellspacing="0" role="presentation" align="center">
        <!-- Body content -->
        <tr>
            <td class="content-email" align="center">
                <h1 class="text-center">
                    Um novo especialista foi cadastrado!
                </h1>
            </td>
        </tr>
        <tr>
            <td class="content-email" align="justify">
                <label class="body-medium">
                    Caro admin, por gentileza clique no botão abaixo e verifique a documentação do novo especialista para efetivar seu cadastro.
                </label>
            </td>
        </tr>
        @component('mail::button', ['url' => route('aprovar.especialista.create', ['especialista_id' => $especialistaId, 'idCode' => $codigo])])
            Visualizar documentação
        @endcomponent
        @component('mail::subcopy')
            <label>
                Esta mensagem foi enviada de um endereço de e-mail que apenas envia<br>
                mensagens. Para obter mais informações sobre sua conta, envie e-mail para<br>
                o nosso suporte: 88 997141874 </a>
            </label>
        @endcomponent
    </table>
@endcomponent
