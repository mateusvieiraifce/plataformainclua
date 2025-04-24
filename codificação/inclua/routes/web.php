<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------                                CNPJ <span class="required">*</span>
----------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sobre', function () {
    return view('frente/about');
})->name('home.sobre');

Route::get('/contato', function () {
    return view('frente/contato');
})->name('contato');

Route::get("/teste", function () {
    return view('teste');
});

Route::get("/", [\App\Http\Controllers\LandingPageController::class, 'index'])->name('landing.page');
Route::get("/login", [\App\Http\Controllers\UsuarioController::class, 'index'])->name('index');
Route::any("/sendmailback", [\App\Http\Controllers\MailController::class, 'sendEmailBack'])->name('sendMailBack');

Route::post('/mail', [\App\Http\Controllers\MailController::class, "sendMail"])->name('sendmail');

#URL's AUTH GOOGLE
Route::get('/google/redirect', [\App\Http\Controllers\UsuarioController::class, 'redirectToProvider'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\UsuarioController::class, 'handleProviderCallback'])->name('google.callback');

#CADASTRO DE USUARIO
Route::get("/cadastrar/usuario/create", [\App\Http\Controllers\UsuarioController::class, 'createUser'])->name('usuario.create');
Route::post("/cadastrar/usuario/store", [\App\Http\Controllers\UsuarioController::class, 'storeUser'])->name('usuario.store');
Route::get("/cadastrar/usuario/edit/{usuario_id}", [\App\Http\Controllers\UsuarioController::class, 'editUser'])->name('usuario.edit');

#USUARIO PACIENTE
Route::get("/cadastrar/usuario/paciente/dados/create/{usuario_id}", [\App\Http\Controllers\PacienteController::class, 'createDadosUserPaciente'])->name('usuario.paciente.dados.create');
Route::post("/cadastrar/usuario/paciente/dados/store", [\App\Http\Controllers\PacienteController::class, 'storeDadosUserPaciente'])->name('usuario.paciente.dados.store');
Route::get("/cadastrar/usuario/paciente/dados/edit/{usuario_id}", [\App\Http\Controllers\PacienteController::class, 'editDadosUserPaciente'])->name('usuario.paciente.dados.edit');
Route::get("/paciente/endereco/create/{usuario_id}", [\App\Http\Controllers\PacienteController::class, 'createEnderecoPaciente'])->name('paciente.endereco.create');
Route::post("/paciente/endereco/store", [\App\Http\Controllers\PacienteController::class, 'storeEnderecoPaciente'])->name('paciente.endereco.store');

#CADASTRO CARTAO
Route::get("/cadastrar/cartao/create/{usuario_id}", [\App\Http\Controllers\CartaoController::class, 'create'])->name('cartao.create');

#USUARIO ESPECIALISTA
Route::get("/cadastrar/usuario/especialista/dados/create/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'createDadosUserEspecialista'])->name('usuario.especialista.dados.create');
Route::post("/cadastrar/usuario/especialista/store", [\App\Http\Controllers\EspecialistaController::class, 'storeDadosUserEspecialista'])->name('usuario.especialista.dados.store');
Route::get("/cadastrar/usuario/especialista/dados/edit/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'editDadosUserEspecialista'])->name('usuario.especialista.dados.edit');
Route::get("/especialista/local-atendimento/create/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'createLocalAtendimento'])->name('especialista.local-atendimento.create');
Route::post("/especialista/local-atendimento/store", [\App\Http\Controllers\EspecialistaController::class, 'storeLocalAtendimento'])->name('especialista.local-atendimento.store');

#USUARIO CLINICA
Route::get("/cadastrar/usuario/clinica/dados/create/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'createDadosUserClinica'])->name('usuario.clinica.dados.create');
Route::post("/cadastrar/usuario/clinica/store", [\App\Http\Controllers\ClinicaController::class, 'storeDadosUserClinica'])->name('usuario.clinica.dados.store');
Route::get("/cadastrar/usuario/clinica/dados/edit/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'editDadosUserClinica'])->name('usuario.clinica.dados.edit');
Route::get("/clinica/endereco/create/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'createEnderecoClinica'])->name('clinica.endereco.create');
Route::post("/clinica/endereco/store", [\App\Http\Controllers\ClinicaController::class, 'storeEnderecoClinica'])->name('clinica.endereco.store');

#DADOS BANCARIOS
Route::get("/cadastrar/dados-bancarios/create/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'createDadosBancarios'])->name('dados-bancarios.create');
Route::post("/cadastrar/dados-bancarios/store", [\App\Http\Controllers\EspecialistaController::class, 'storeDadosBancarios'])->name('dados-bancarios.store');

#ASSINATURA
Route::post("/pagamento/assinatura", [\App\Http\Controllers\AssinaturaController::class, 'lancarAssinatura'])->name('pagamento.assinatura');
Route::get("/callback-payment/assinatura", [\App\Http\Controllers\AssinaturaController::class, 'callbackPaymentAssinatura'])->name('callback.payment.assinatura');
Route::get("/pagamento/assinatura/renovar", [\App\Http\Controllers\AssinaturaController::class, 'renovacaoAutomatica'])->name('assinatura.renocacao.automatica');
Route::get("/callback-payment/assinatura/renovar", [\App\Http\Controllers\AssinaturaController::class, 'callbackPaymentRenovarAssinatura'])->name('callback.payment.assinatura.renovar');

#VALIDAÇÕES
Route::get("/email/verificar/{usuario_id}", [\App\Http\Controllers\ValidacoesController::class, 'verificarEmail'])->name('view.verificar_email');
Route::get("/email/reenviar-sms/", [\App\Http\Controllers\ValidacoesController::class, 'reenviarEmail'])->name('validar.reenviar_email');
Route::post("/email/validar", [\App\Http\Controllers\ValidacoesController::class, 'validarEmail'])->name('validar.email');
Route::get("/celular/verificar/{usuario_id}", [\App\Http\Controllers\ValidacoesController::class, 'verificarCelular'])->name('view.verificar_celular');
Route::get("/celular/reenviar-sms/", [\App\Http\Controllers\ValidacoesController::class, 'reenviarSMS'])->name('validar.reenviar_sms');
Route::post("/celular/validar", [\App\Http\Controllers\ValidacoesController::class, 'validarCelular'])->name('validar.celular');
Route::get("/aprovar/especialista/create/{especialista_id}", [\App\Http\Controllers\ValidacoesController::class, 'visualizarDocumentacaoEspecialista'])->name('aprovar.especialista.create');
Route::post("/aprovar/especialista/store", [\App\Http\Controllers\ValidacoesController::class, 'aprovarEspecialista'])->name('aprovar.especialista.store');

Route::post("/auth/user", [\App\Http\Controllers\UsuarioController::class, 'logar'])->name('login.do');
Route::get("/logout", [\App\Http\Controllers\UsuarioController::class, 'logout'])->name('logout');
Route::get("/recuperar", [\App\Http\Controllers\UsuarioController::class, 'recover'])->name('recover');
Route::get("/recuperar/{id?}", [\App\Http\Controllers\UsuarioController::class, 'recoverID'])->name('recover.id');
Route::post("/recuperar", [\App\Http\Controllers\UsuarioController::class, 'recoverDo'])->name('recover.do');
Route::post("/updatepassword", [\App\Http\Controllers\UsuarioController::class, 'recoverPassword'])->name('update.password');

Route::post("/clinicas/get", [\App\Http\Controllers\ClinicaController::class, 'getClinicas'])->name('clinicas.get-all');

Route::middleware('auth')->group(function () {
    #DASHBORD
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'home'])->name('home')->middleware('verify.signature');
    Route::get('/dashboard/clinica', [\App\Http\Controllers\DashboardController::class, 'dashboardClinica'])->name('dashboard.dashboardClinica');

    #PROFILE
    Route::get("/profile/{id?}", [\App\Http\Controllers\UsuarioController::class, 'perfil'])->name('user.perfil');
    Route::post("/profile/update", [\App\Http\Controllers\UsuarioController::class, 'updateUser'])->name('user.update');
    Route::post("/profile/update/dados", [\App\Http\Controllers\UsuarioController::class, 'updateDadosUser'])->name('user.update.dados');
    Route::post("/profile/delete", [\App\Http\Controllers\UsuarioController::class, 'delete'])->name('user.delete');
    Route::post("/profile/update/avatar", [\App\Http\Controllers\UsuarioController::class, 'updateAvatar'])->name('user.update.avatar');
    
    #ENDEREÇO
    Route::get("/profile/endereco/create/{usuario_id?}", [\App\Http\Controllers\EnderecoController::class, 'create'])->name('user.endereco.create');
    Route::post("/profile/endereco/store", [\App\Http\Controllers\EnderecoController::class, 'store'])->name('user.endereco.store');
    Route::get("/profile/endereco/delete/{id}", [\App\Http\Controllers\EnderecoController::class, 'delete'])->name('user.endereco.delete');
    Route::get("/profile/endereco/edit/{id}", [\App\Http\Controllers\EnderecoController::class, 'edit'])->name('user.endereco.edit');
    Route::get("/profile/endereco/principal/{id}", [\App\Http\Controllers\EnderecoController::class, 'setEnderecoPrincipal'])->name('user.endereco.principal');

    Route::get("/send/mail", [\App\Http\Controllers\MailController::class, 'sendMenssagem'])->name('sales.send.do.email');

    #ESPECIALIDADES
    Route::get("/especialidade/list", [\App\Http\Controllers\EspecialidadeController::class, 'list'])->name('especialidade.list');
    Route::get("/especialidade/new", [\App\Http\Controllers\EspecialidadeController::class, 'new'])->name('especialidade.new');
    Route::post("/especialidade/search", [\App\Http\Controllers\EspecialidadeController::class, 'search'])->name('especialidade.search');
    Route::post("/especialidade/save", [\App\Http\Controllers\EspecialidadeController::class, 'save'])->name('especialidade.save');
    Route::get("/especialidade/delete/{id}", [\App\Http\Controllers\EspecialidadeController::class, 'delete'])->name('especialidade.delete');
    Route::get("/especialidade/edit/{id}", [\App\Http\Controllers\EspecialidadeController::class, 'edit'])->name('especialidade.edit');

    #FORMA DE PAGAMENTO
    Route::get("/formapagamento/list", [\App\Http\Controllers\FormapagamentoController::class, 'list'])->name('formapagamento.list');
    Route::get("/formapagamento/new", [\App\Http\Controllers\FormapagamentoController::class, 'new'])->name('formapagamento.new');
    Route::post("/formapagamento/search", [\App\Http\Controllers\FormapagamentoController::class, 'search'])->name('formapagamento.search');
    Route::post("/formapagamento/save", [\App\Http\Controllers\FormapagamentoController::class, 'save'])->name('formapagamento.save');
    Route::get("/formapagamento/delete/{id}", [\App\Http\Controllers\FormapagamentoController::class, 'delete'])->name('formapagamento.delete');
    Route::get("/formapagamento/edit/{id}", [\App\Http\Controllers\FormapagamentoController::class, 'edit'])->name('formapagamento.edit');

    #CLINICA
    Route::get("/clinica/list", [\App\Http\Controllers\ClinicaController::class, 'list'])->name('clinica.list');
    Route::get("/clinica/new", [\App\Http\Controllers\ClinicaController::class, 'new'])->name('clinica.new');
    Route::post("/clinica/search", [\App\Http\Controllers\ClinicaController::class, 'search'])->name('clinica.search');
    Route::post("/clinica/save", [\App\Http\Controllers\ClinicaController::class, 'save'])->name('clinica.save');
    Route::get("/clinica/delete/{id}", [\App\Http\Controllers\ClinicaController::class, 'delete'])->name('clinica.delete');
    Route::get("/clinica/edit/{id}", [\App\Http\Controllers\ClinicaController::class, 'edit'])->name('clinica.edit');

    #ESPECIALIDADE_CLINICA
    Route::get("/especialidadeclinica/list/{clinica_id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'list'])->name('especialidadeclinica.list');
    Route::get("/especialidadeclinica/new/{clinica_id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'new'])->name('especialidadeclinica.new');
    Route::get("/especialidadeclinica/search/{clinica_id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'search'])->name('especialidadeclinica.search');
    Route::post("/especialidadeclinica/save/{clinica_id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'save'])->name('especialidadeclinica.save');
    Route::get("/especialidadeclinica/delete/{id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'delete'])->name('especialidadeclinica.delete');
    Route::get("/especialidadeclinica/edit/{id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'edit'])->name('especialidadeclinica.edit');
    
    #ESPECIALISTA
    Route::get("/especialista/list", [\App\Http\Controllers\EspecialistaController::class, 'list'])->name('especialista.list');
    Route::get("/especialista/new", [\App\Http\Controllers\EspecialistaController::class, 'new'])->name('especialista.new');
    Route::post("/especialista/search", [\App\Http\Controllers\EspecialistaController::class, 'search'])->name('especialista.search');
    Route::post("/especialista/save", [\App\Http\Controllers\EspecialistaController::class, 'save'])->name('especialista.save');
    Route::get("/especialista/delete/{id}", [\App\Http\Controllers\EspecialistaController::class, 'delete'])->name('especialista.delete');
    Route::get("/especialista/edit/{id}", [\App\Http\Controllers\EspecialistaController::class, 'edit'])->name('especialista.edit');

    #ESPECIALISTA_POR_CLINICA
    Route::get("/especialistaclinica/list/{clinica_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'list'])->name( 'especialistaclinica.list');
    Route::get("/especialistaclinica/new/{clinica_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'new'])->name('especialistaclinica.new');
    Route::get("/especialistaclinica/search/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'search'])->name('especialistaclinica.search');
    Route::post("/especialistaclinica/save/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'save'])->name('especialistaclinica.save');
    Route::get("/especialistaclinica/delete/{id}/{clinica_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'delete'])->name('especialistaclinica.delete');
    Route::get("/especialistaclinica/edit/{id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'edit'])->name('especialistaclinica.edit');
    Route::get("/especialistaclinica/vinculo/{clinica_id}/{especialista_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'cancelarVinculo'])->name('especialistaclinica.cancelarVinculo');

    Route::get("/consulta/selecionar-especialista/{rota?}", [\App\Http\Controllers\ConsultaController::class, 'selectEspecialista'])->name('selecionar.especialista');
    Route::get("/consulta/selecionar-especialista/search/result", [\App\Http\Controllers\ConsultaController::class, 'selectEspecialistaSearch'])->name('selecionar.especialista.search');

    #CONSULTAS_DISPONIBILIZADAS_POR_ESPECIALISTA
    Route::get("/consulta/list/{especialista_id?}", [\App\Http\Controllers\ConsultaController::class, 'list'])->name('consulta.list');
    Route::get("/consulta/new/{especialista_id}", [\App\Http\Controllers\ConsultaController::class, 'new'])->name('consulta.new');
    Route::get("/consulta/search/", [\App\Http\Controllers\ConsultaController::class, 'search'])->name('consulta.search');

    #CLINICAS_POR_ESPECIALISTA
    Route::get("/clinica/vinculo/{especialista_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'clinicasdoespecilista'])->name('especialistaclinica.clinicas');

    #CONSULTAS_POR_ESPECIALISTA
    Route::get("/consulta/listconsultas/", [\App\Http\Controllers\ConsultaController::class, 'listconsultaporespecialista'])->name('consulta.listconsultaporespecialista')->middleware('auth');
    Route::get("/consulta/listconsultas/search", [\App\Http\Controllers\ConsultaController::class, 'listConsultaPorEspecialistaPesquisar'])->name('consulta.listConsultaPorEspecialistaPesquisar')->middleware('auth');

    #ROTAS_USER_PACIENTE
    Route::get("/paciente/home/", [\App\Http\Controllers\PacienteController::class, 'home'])->name('paciente.home')->middleware('auth');

    #CONSULTAS_USER_PACIENTE
    Route::get("/paciente/minhas-consultas", [\App\Http\Controllers\PacienteController::class, 'minhasconsultas'])->name('paciente.minhasconsultas');
    Route::get("/paciente/historico-consultas", [\App\Http\Controllers\PacienteController::class, 'historicoConsultas'])->name('paciente.historicoconsultas');
    
    #FINANCEIRO PACIENTE
    Route::get("/paciente/financeiro", [\App\Http\Controllers\PagamentoController::class, 'historicoPagamentosPaciente'])->name('paciente.financeiro');
    Route::get("/paciente/assinatura/cartoes", [\App\Http\Controllers\AssinaturaController::class, 'selecionarCartao'])->name('pagamento.assinatura.cartoes');
    Route::get("/paciente/assinatura/renovar/{cartao}", [\App\Http\Controllers\AssinaturaController::class, 'renovarAssinaturaCartao'])->name('pagamento.assinatura.renovar');
    
    #FINANCEIRO CONTA A PAGAR CLINICA
    Route::get("/clinica/financeiro", [\App\Http\Controllers\PagamentoContaController::class, 'list'])->name('clinica.financeiro');
    Route::get("/clinica/financeiro/create", [\App\Http\Controllers\PagamentoContaController::class, 'create'])->name('clinica.financeiro.create');
    Route::post("/clinica/financeiro", [\App\Http\Controllers\PagamentoContaController::class, 'store'])->name('clinica.financeiro.store');
    Route::get("/clinica/financeiro/{conta}/edit", [\App\Http\Controllers\PagamentoContaController::class, 'edit'])->name('clinica.financeiro.edit');
    Route::put("/clinica/financeiro/{conta}", [\App\Http\Controllers\PagamentoContaController::class, 'update'])->name('clinica.financeiro.update');
    Route::get("/clinica/financeiro/{conta}/delete", [\App\Http\Controllers\PagamentoContaController::class, 'destroy'])->name('clinica.financeiro.destroy');

    #LISTA PACIENTES E CADASTRO
    Route::get("/paciente/editar/{id}", [\App\Http\Controllers\PacienteController::class, 'edit'])->name('paciente.edit');
    Route::post("/paciente/update/", [\App\Http\Controllers\PacienteController::class, 'update'])->name('paciente.update');
    Route::get("/paciente/lista", [\App\Http\Controllers\PacienteController::class, 'index'])->name('paciente.index');
    
    #LISTA DE PEDIDOS DE EXAMES DO PACIENTE
    Route::get("/paciente/exames", [\App\Http\Controllers\PedidoExameController::class, 'pedidoExamesPaciente'])->name('paciente.pedido_exames.lista');
    
    #AVALIACAO PACIENTE
    Route::get("/paciente/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoPaciente'])->name('paciente.avaliacao.lista');
    
    #AVALIACAO PACIENTE - USUÁRIO ROOT
    Route::get("/pacientes/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoPacientes'])->name('pacientes.avaliacao.lista');
    #HISTORICO PAGAMENTOS PACIENTES - USUÁRIO ROOT
    Route::get("/pacientes/financeiro", [\App\Http\Controllers\PagamentoController::class, 'historicoPagamentosPacientes'])->name('pacientes.financeiro');

    /* GRUPO DE ROTAS QUE SERÃO RESTRITAS A PACIENTES COM ASSINATURA ATIVA */
    Route::middleware('verify.signature')->group(function() {
        #MARCAR_CONSULTA_USUARIO_PACIENTE
        Route::get("/paciente/marcar-consulta/{paciente_id?}", [\App\Http\Controllers\PacienteController::class, 'marcarconsulta'])->name('paciente.marcarconsulta');
        Route::get("/paciente/marcar-consultas/pacientes", [\App\Http\Controllers\PacienteController::class, 'marcarconsultaSelecionarPaciente'])->name('paciente.marcarconsultaSelecionarPaciente');

        #VIA_CLINICA
        Route::get("/paciente/marcar-consulta/via-clinica/etapa2", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso1'])->name('paciente.marcarConsultaViaClinicaPasso1');
        Route::get("/paciente/marcar-consulta/via-clinica/etapa3/{id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso2'])->name('paciente.marcarConsultaViaClinicaPasso2');
        Route::get("/paciente/marcar-consulta/via-clinica/etapa4/{clinica_id}/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso3'])->name('paciente.marcarConsultaViaClinicaPasso3');
        Route::get("/paciente/marcar-consulta/via-clinica/etapa5/{clinica_id}/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso4'])->name('paciente.marcarConsultaViaClinicaPasso4');
        Route::post("/paciente/marcar-consulta/via-clinica/finalizar/", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaFinalizar'])->name('paciente.marcarConsultaViaClinicaFinalizar');
        Route::post("/paciente/via-clinica/search/", [\App\Http\Controllers\PacienteController::class, 'pesquisarclinicamarcarconsulta'])->name('paciente.pesquisarclinicamarcarconsulta');

        #VIA_ESPECIALIDADE
        Route::get("/paciente/marcar-consulta/via-especialidade/etapa2", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso1'])->name('paciente.marcarConsultaViaEspecialidadePasso1')->middleware('auth');
        Route::get("/paciente/marcar-consulta/via-especialidade/etapa3/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso2'])->name('paciente.marcarConsultaViaEspecialidadePasso2')->middleware('auth');
        Route::get("/paciente/marcar-consulta/via-especialidade/etapa3/{especialidade_id}/{clinica_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso3'])->name('paciente.marcarConsultaViaEspecialidadePasso3')->middleware('auth');
        Route::get("/paciente/marcar-consulta/via-especialidade/etapa4/{clinica_id}/{especialista_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso4'])->name('paciente.marcarConsultaViaEspecialidadePasso4')->middleware('auth');

        #ANAMNESE
        Route::get("/paciente/anamnese/{paciente_id}", [\App\Http\Controllers\AnamneseController::class, 'create'])->name('anamnese.create');
        Route::post("/paciente/anamnese/store", [\App\Http\Controllers\AnamneseController::class, 'store'])->name('anamnese.store');
        
        #CANCELAR CONSULTA
        Route::post("/paciente/consulta/cancelar", [\App\Http\Controllers\PacienteController::class, 'cancelarConsulta'])->name('paciente.consulta.cancelar');
        Route::get("/paciente/consulta/cancelar/callback", [\App\Http\Controllers\ConsultaController::class, 'callbackCancelarConsultaComTaxa'])->name('callback.cancelamento.consulta');

        #LISTA CADASTRO DE PACIENTES
        Route::get("/paciente/create", [\App\Http\Controllers\PacienteController::class, 'create'])->name('paciente.create');
        Route::post("/paciente/store", [\App\Http\Controllers\PacienteController::class, 'store'])->name('paciente.store');
        
        #LISTA DE PEDIDOS DE EXAMES DO PACIENTE
        Route::post("/paciente/exames/arquivo/store", [\App\Http\Controllers\PedidoExameController::class, 'storeArquivoExame'])->name('paciente.pedido_exames.file_store');
        Route::get("/paciente/exames/check", [\App\Http\Controllers\PedidoExameController::class, 'checkExame'])->name('paciente.pedido_exames.check');

        #AVALIACAO PACIENTE
        Route::get("/paciente/avaliacao/store", [\App\Http\Controllers\AvaliacaoController::class, 'store'])->name('paciente.avaliacao.store');
    });

    /* GRUPO DE ROTAS RESTRITAS A ESPECIALISTAS COM O CADASTRO APROVADO */
    Route::middleware('verify.especialista.active')->group(function() {
        #CONSULTAS
        Route::post("/consulta/save/{especialista_id}", [\App\Http\Controllers\ConsultaController::class, 'save'])->name('consulta.save');
        Route::get("/consulta/delete/{id}", [\App\Http\Controllers\ConsultaController::class, 'delete'])->name('consulta.delete');
        Route::get("/consulta/edit/{id}", [\App\Http\Controllers\ConsultaController::class, 'edit'])->name('consulta.edit');
        Route::get("/consulta/agenda/", [\App\Http\Controllers\ConsultaController::class, 'agenda'])->name('consulta.agenda');
        Route::post("/consulta/saveagenda/", [\App\Http\Controllers\ConsultaController::class, 'saveVariasConsultas'])->name('consulta.saveagenda');

        #ATENDIMENTO
        Route::get("/especialista/atendimento/{consulta_id}/{aba}", [\App\Http\Controllers\EspecialistaController::class, 'inicarAtendimento'])->name('especialista.iniciarAtendimento');
    });

    #CAD_TIPO_EXAMES_USER_ROOT
    Route::get("/tipoexame/list", [\App\Http\Controllers\TipoexameController::class, 'list'])->name('tipoexame.list')->middleware('auth');
    Route::get("/tipoexame/new", [\App\Http\Controllers\TipoexameController::class, 'new'])->name('tipoexame.new')->middleware('auth');
    Route::post("/tipoexame/search", [\App\Http\Controllers\TipoexameController::class, 'search'])->name('tipoexame.search')->middleware('auth');
    Route::post("/tipoexame/save", [\App\Http\Controllers\TipoexameController::class, 'save'])->name('tipoexame.save')->middleware('auth');
    Route::get("/tipoexame/delete/{id}", [\App\Http\Controllers\TipoexameController::class, 'delete'])->name('tipoexame.delete')->middleware('auth');
    Route::get("/tipoexame/edit/{id}", [\App\Http\Controllers\TipoexameController::class, 'edit'])->name('tipoexame.edit')->middleware('auth');

    #CAD_EXAMES_USER_ROOT
    Route::get("/exame/list", [\App\Http\Controllers\ExameController::class, 'list'])->name('exame.list')->middleware('auth');
    Route::get("/exame/new", [\App\Http\Controllers\ExameController::class, 'new'])->name('exame.new')->middleware('auth');
    Route::post("/exame/search", [\App\Http\Controllers\ExameController::class, 'search'])->name('exame.search')->middleware('auth');
    Route::post("/exame/save", [\App\Http\Controllers\ExameController::class, 'save'])->name('exame.save')->middleware('auth');
    Route::get("/exame/delete/{id}", [\App\Http\Controllers\ExameController::class, 'delete'])->name('exame.delete')->middleware('auth');
    Route::get("/exame/edit/{id}", [\App\Http\Controllers\ExameController::class, 'edit'])->name('exame.edit')->middleware('auth');

    #CAD_TIPO_MEDICAMENTOS_USER_ROOT
    Route::get("/tipomedicamento/list", [\App\Http\Controllers\TipomedicamentoController::class, 'list'])->name('tipomedicamento.list')->middleware('auth');
    Route::get("/tipomedicamento/new", [\App\Http\Controllers\TipomedicamentoController::class, 'create'])->name('tipomedicamento.new')->middleware('auth');
    Route::post("/tipomedicamento/search", [\App\Http\Controllers\TipomedicamentoController::class, 'search'])->name('tipomedicamento.search')->middleware('auth');
    Route::post("/tipomedicamento/save", [\App\Http\Controllers\TipomedicamentoController::class, 'store'])->name('tipomedicamento.save')->middleware('auth');
    Route::get("/tipomedicamento/delete/{id}", [\App\Http\Controllers\TipomedicamentoController::class, 'delete'])->name('tipomedicamento.delete')->middleware('auth');
    Route::get("/tipomedicamento/edit/{id}", [\App\Http\Controllers\TipomedicamentoController::class, 'edit'])->name('tipomedicamento.edit')->middleware('auth');

    #CAD_MEDICAMENTOS_USER_ROOT
    Route::get("/medicamento/list", [\App\Http\Controllers\MedicamentoController::class, 'list'])->name('medicamento.list')->middleware('auth');
    Route::get("/medicamento/new", [\App\Http\Controllers\MedicamentoController::class, 'create'])->name('medicamento.new')->middleware('auth');
    Route::post("/medicamento/search", [\App\Http\Controllers\MedicamentoController::class, 'search'])->name('medicamento.search')->middleware('auth');
    Route::post("/medicamento/save", [\App\Http\Controllers\MedicamentoController::class, 'store'])->name('medicamento.save')->middleware('auth');
    Route::get("/medicamento/delete/{id}", [\App\Http\Controllers\MedicamentoController::class, 'delete'])->name('medicamento.delete')->middleware('auth');
    Route::get("/medicamento/edit/{id}", [\App\Http\Controllers\MedicamentoController::class, 'edit'])->name('medicamento.edit')->middleware('auth');


    #ESPECIALISTA
    Route::get("/especialista/atendimentos/finalizar/{consulta_id}", [\App\Http\Controllers\EspecialistaController::class, 'finalizarAtendimento'])->name('especialista.finalizarAtendimento')->middleware('auth');
    Route::get("/especialista/pacientes/", [\App\Http\Controllers\EspecialistaController::class, 'listaPacientes'])->name('especialista.listaPacientes')->middleware('auth');
    Route::get("/especialista/pacientes/search", [\App\Http\Controllers\EspecialistaController::class, 'listaPacientesPesquisar'])->name('especialista.listaPacientesPesquisar');
    Route::get("/especialista/pedidoexame/list", [\App\Http\Controllers\PedidoExameController::class, 'list'])->name('pedido_exame.list')->middleware('auth');
    Route::post("/especialista/pedidoexame/save", [\App\Http\Controllers\PedidoExameController::class, 'salveVarios'])->name('pedido_exame.salveVarios');
    Route::get("/especialista/pedidoexame/delete/{id}/{consulta_id}", [\App\Http\Controllers\PedidoExameController::class, 'delete'])->name('pedido_exame.delete');
    Route::post("/especialista/pedidomedicamento/save", [\App\Http\Controllers\PedidoMedicamentoController::class, 'salveVarios'])->name('pedido_medicamento.salveVarios');
    Route::get("/especialista/pedidomedicamento/delete/{id}/{consulta_id}", [\App\Http\Controllers\PedidoMedicamentoController::class, 'delete'])->name('pedido_medicamento.delete');
    Route::post("/especialista/novoexame/", [\App\Http\Controllers\EspecialistaController::class, 'salvaNovoExame'])->name('especialista.salvaNovoExame');
    Route::post("/especialista/novomedicamento/", [\App\Http\Controllers\EspecialistaController::class, 'salvaNovoMedicamento'])->name('especialista.salvaNovoMedicamento');
    
    #ATESTADO
    Route::post("/especialista/atestado/store", [\App\Http\Controllers\AtestadoController::class, 'store'])->name('atestado.store');
    Route::get("/especialista/atestado/download/{id}", [\App\Http\Controllers\AtestadoController::class, 'downloadAtestado'])->name('atestado.download');

    Route::get("/consulta/selecionar-clinica/{rota?}", [\App\Http\Controllers\ConsultaController::class, 'selectClinica'])->name('selecionar.clinica');
    Route::get("/consulta/selecionar-clinica/search/result", [\App\Http\Controllers\ConsultaController::class, 'selectClinicaSearch'])->name('selecionar.clinica.search');
    
    Route::post("/especialista/selecionar-especialista/search/result", [\App\Http\Controllers\ClinicaController::class, 'selectEspecialistaSearch'])->name('selecionar.especialista.search');
    Route::get("/clinica/selecionar-clinica/", [\App\Http\Controllers\ClinicaController::class, 'listarClinicaRelatorio'])->name('selecionar.clinica.relatorio');
    Route::get('/remover-filtro/{tipo}', [\App\Http\Controllers\ClinicaController::class, 'removerFiltro'])->name('remover.filtro');
    Route::get("/clinica/meu-relatorio/", [\App\Http\Controllers\ClinicaController::class, 'relatorioClinicaView'])->name('relatorio.clinica.view');
    Route::post('/limpar-sessao', [\App\Http\Controllers\ClinicaController::class, 'limparSessao'])->name('user.relatorio.limpar');




    #CLINICA ++++++++++++++
    Route::get("/clinica/consultas/", [\App\Http\Controllers\ConsultaController::class, 'listConsultaporClinica'])->name('consulta.listConsultaporClinica');
    Route::get("/clinica/agenda/{clinica_id?}", [\App\Http\Controllers\ConsultaController::class, 'listConsultaAgendadaUserClinica'])->name('consulta.agendaConsultas');
    Route::post("/clinica/agenda/search/", [\App\Http\Controllers\ConsultaController::class, 'listConsultaAgendadaUserClinicaPesquisar'])->name('consulta.agendaConsultasPesquisar');
    Route::get("/clinica/pacientes/", [\App\Http\Controllers\ClinicaController::class, 'listaPacientes'])->name('clinica.listaPacientes');
    Route::get("/clinica/pacientes/search/", [\App\Http\Controllers\ClinicaController::class, 'listaPacientesPesquisar'])->name('clinica.listaPacientesPesquisar');
    Route::post("/clinica/agenda/encaminhar", [\App\Http\Controllers\ConsultaController::class, 'encaminharPaciente'])->name('consulta.encaminharPaciente');
    Route::post("/clinica/agenda/efetuarpagamento", [\App\Http\Controllers\ConsultaController::class, 'efetuarPagamentoUserClinica'])->name('consulta.efetuarPagamentoUserClinica');
    Route::post("/clinica/agenda/consulta/cancelar/", [\App\Http\Controllers\ClinicaController::class, 'canelarconsultaViaClinica'])->name('clinica.canelarconsultaViaClinica');
    Route::get("/clinica/relatorio/especialista", [\App\Http\Controllers\ClinicaController::class, 'formRelatorioEspecialista'])->name('clinica.formRelatorioEspecialista');
    Route::get("clinica/relatorio/caixa", [\App\Http\Controllers\ClinicaController::class, 'relatorioView'])->name('user.relatorio');
    Route::post("clinica/relatorio/caixa/gerar", [\App\Http\Controllers\ClinicaController::class, 'relatorioCaixa'])->name('user.relatorio.gerar');
    Route::get("clinica/relatorio/caixa/selecionar-especialista", [\App\Http\Controllers\ClinicaController::class, 'listarEspecialistaRelatorio'])->name('user.relatorio.especialista');


   #CLINICA_VINCULO_COM_ESPECIALISTA
    Route::get("/clinica/especialista/novasconsultas/{especialista_id}/{clinica_id?}", [\App\Http\Controllers\ConsultaController::class, 'novaConsultasUserClinica'])->name('consulta.novaConsultasUserClinica');
    Route::post("/clinica/especialista/novasconsultas/saveagenda/", [\App\Http\Controllers\ConsultaController::class, 'saveVariasConsultasUserClinica'])->name('consulta.saveVariasConsultasUserClinica');
    Route::any('/clinica/especialista/convidar', [\App\Http\Controllers\MailController::class, 'enviarConviteEspecialista'])->name('clinica.enviarConviteEspecialista');

    #CAD_ESPECIALIDADE_USER_CLINICA
    Route::get("/clinica/especialidade/list/{clinica_id?}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'listUserClinica'])->name('especialidadeclinica.listclinicas');
    Route::get("/clinica/especialidade/new", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'newUserClinica'])->name('especialidadeclinica.newUserClinica');
    Route::get("/clinica/especialidade/edit/{id}/{clinica_id?}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'editUserClinica'])->name('especialidadeclinica.editUserClinica');
    Route::get("/clinica/especialidade/alterarvinculo/{especialidadeclinica_id}", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'alterarvinculo'])->name('especialidadeclinica.alterarvinculo');
    Route::post("/clinica/especialidade/save", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'saveUserClinica'])->name('especialidadeclinica.saveUserClinica');
    
   #CAD_FILA_USER_CLINICA
    Route::any("/clinica/fila/especialista", [\App\Http\Controllers\FilaController::class, 'listEspecialistaDaClinica'])->name('fila.listEspecialistaDaClinica');
    Route::any("/clinica/fila/list", [\App\Http\Controllers\FilaController::class, 'list'])->name('fila.list');
    Route::post("/clinica/fila/novaordem", [\App\Http\Controllers\FilaController::class, 'salvarOrdemFilas'])->name('fila.salvarOrdemFilas');

    #CAD_FILA_USER_ESPECIALISTA
    Route::any("/especialista/fila/clinicas", [\App\Http\Controllers\FilaController::class, 'listClinicaDoEspecialista'])->name('fila.listClinicaDoEspecialista');
    Route::any("/especialista/fila/list", [\App\Http\Controllers\FilaController::class, 'listUserEspecialista'])->name('fila.listUserEspecialista');
    Route::post("/especialista/fila/novaordem", [\App\Http\Controllers\FilaController::class, 'salvarOrdemFilasUserEspecialista'])->name('fila.salvarOrdemFilasUserEspecialista');
    
    Route::get("/especialistas/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoEspecialistas'])->name('especialistas.avaliacao.lista');

    Route::get("/especialista/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoEspecialista'])->name('avaliacao.reputacaoEspecialista');
    Route::post("/especialista/reputacao/denunciar", [\App\Http\Controllers\AvaliacaoController::class, 'denuciarUserEspecialista'])->name('avaliacao.denuciarUserEspecialista');
    Route::get("/especialista/prontuario/{id_paciente}", [\App\Http\Controllers\PacienteController::class, 'prontuario'])->name('paciente.prontuario');

    #CONSULTAS_POR_CLINICA
    Route::post("/clinica/consultas/search", [\App\Http\Controllers\ConsultaController::class, 'listConsultaporClinicaPesquisar'])->name('consulta.listConsultaporClinicaPesquisar');
    #MARCAR_CONSULTA_USER_CLINICA
    Route::get("/clinica/marcarconsulta/paciente/etapa2/{clinica_id?}", [\App\Http\Controllers\ClinicaController::class, 'marcarConsultaSelecionarPaciente'])->name('clinica.marcarConsultaSelecionarPaciente');
    Route::get("/clinica/marcarconsulta/paciente/search/", [\App\Http\Controllers\ClinicaController::class, 'pesquisarPacienteMarcarconsulta'])->name('clinica.pesquisarPacienteMarcarconsulta');
    Route::get("/clinica/marcarconsulta/especialidade/etapa3/{paciente_id}/{clinica_id?}", [\App\Http\Controllers\ClinicaController::class, 'marcarConsultaSelecionarEspecialidade'])->name('clinica.marcarConsultaSelecionarEspecialidade');
    Route::get("/clinica/marcarconsulta/especialidade/etapa4/{paciente_id}/{especialidade_id}/{clinica_id?}", [\App\Http\Controllers\ClinicaController::class, 'marcarConsultaSelecionarEspecialista'])->name('clinica.marcarConsultaSelecionarEspecialista');
    Route::get("/clinica/marcarconsulta/especialidade/etapa5/{paciente_id}/{especialista_id}/{clinica_id?}", [\App\Http\Controllers\ClinicaController::class, 'marcarConsultaSelecionarHoraConsulta'])->name('clinica.marcarConsultaSelecionarHoraConsulta');
    Route::post("/clinica/marcarconsulta/finalizar/", [\App\Http\Controllers\ClinicaController::class, 'marcarConsultaFinalizar'])->name('clinica.marcarConsultaFinalizar');
    #AGENDA_DO_ESPECIALISTA_USER_CLINICA
    Route::get("/clinica/especialista/vinculo/agenda/{especialista_id}/{clinica_id?}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'agendaEspecialista'])->name('especialistaclinica.agendaEspecialista');

    Route::get("/clinicas/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoClinicas'])->name('clinicas.avaliacao.lista');

    Route::get("/clinica/reputacao", [\App\Http\Controllers\AvaliacaoController::class, 'reputacaoClinica'])->name('avaliacao.reputacaoClinica');
    Route::post("/clinica/reputacao/denunciar", [\App\Http\Controllers\AvaliacaoController::class, 'denuciarUserClinica'])->name('avaliacao.denuciarUserClinica');
    
    Route::get("/configuracao/layout", [\App\Http\Controllers\ConfiguracaoController::class, 'index'])->name('configuracao.layout');    
    Route::post("/configuracao/layout/store", [\App\Http\Controllers\ConfiguracaoController::class, 'store'])->name('configuracao.layout.store');

    Route::post("/consulta/pagar", [\App\Http\Controllers\PagamentoController::class, 'pagarConsulta'])->name('consulta.pagamento');
    Route::get("/consulta/pagamento/callback", [\App\Http\Controllers\PagamentoController::class, 'callbackPagamentoConsulta'])->name('callback.pagamento.consulta');
});

/* ROTAS PARA SEREM ANALISADAS */
Route::get('/compras', function () {
    $usuario = Auth::user();
    $compras = \App\Models\Vendas::where('comprador_id', '=', $usuario->id)->orderBy('created_at', 'desc')->get();
    return view('dashboard', ['compras' => $compras]);
})->name('compras.list')->middleware('auth');

Route::get('/users', function () {
    return view('users/index');
})->name('profile.edit')->middleware('auth');

Route::get('/users/index', function () {
    return view('users/index');
})->name('user.index');
