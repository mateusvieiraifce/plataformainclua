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

    </table>
@endcomponent
