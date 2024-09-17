@component('mail::message')
    <table width="570" cellpadding="0" cellspacing="0" role="presentation" align="center">
        <!-- Body content -->
        <tr>
            <td class="content-email" align="center">
                <label class="body-medium">
                    Bem vindo a plataforma Inclua, vocês está sendo convidado para asdfasdfa: <br>                  

                    **aqui texto completo para Convite
                    ** com link da plataforma
                </label>
            </td>
        </tr>
        @component('mail::subcopy')
            <label>
                Esta mensagem foi enviada de um endereço de e-mail que apenas envia<br>
                mensagens. Para obter mais informações sobre sua conta, envie e-mail para o<br>
                nosso suporte: <a class="active" href="mailto:{{env('EMAIL_SUPPORT')}}">{{env('EMAIL_SUPPORT')}}</a>
        
            </label>
        @endcomponent
    </table>
@endcomponent