@component('mail::message')
    <table width="570" cellpadding="0" cellspacing="0" role="presentation" align="center">
        <!-- Body content -->
        <tr>
            <td class="content-email" align="center">
                <h1 class="text-center">
                    Cadastro efetivado com sucesso!
                </h1>
            </td>
        </tr>
        <tr>
            <td class="content-email" align="justify">
                <label class="body-medium">
                    Caro, {{ $especialista->nome }}, seu acesso ao inclua foi ativado. Você já pode disponibilizar sua agenda, e começar seus atendimentos.
                    Clique no botão a baixo para ser redirecionado a plataforma Inclua
                </label>
            </td>
        </tr>
        @component('mail::button', ['url' => route('index')])
            Login
        @endcomponent
        @component('mail::subcopy')
            <label>
                Esta mensagem foi enviada de um endereço de e-mail que apenas envia<br>
                mensagens. Para obter mais informações sobre sua conta, envie e-mail para<br>
                o nosso suporte: <a class="active" href="mailto:{{ env('EMAIL_SUPPORT') }}">{{env('EMAIL_SUPPORT')}}</a>
            </label>
        @endcomponent
    </table>
@endcomponent