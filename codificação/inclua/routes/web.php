<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
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
Route::get("/", [\App\Http\Controllers\UsuarioController::class, 'index'])->name('index');

Route::get('/checkout', [\App\Http\Controllers\CheckoutControler::class, "checkout"])->name('finalizar');

Route::post('/mail', [\App\Http\Controllers\MailController::class, "sendMail"])->name('sendmail');

#URL's AUTH GOOGLE
Route::get('/google/redirect', [\App\Http\Controllers\UsuarioController::class, 'redirectToProvider'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\UsuarioController::class, 'handleProviderCallback'])->name('google.callback');

#CADASTRO DE USUARIO
Route::get("/cadastrar/usuario/create", [\App\Http\Controllers\UsuarioController::class, 'createUser'])->name('usuario.create');
Route::post("/cadastrar/usuario/store", [\App\Http\Controllers\UsuarioController::class, 'storeUser'])->name('usuario.store');
Route::get("/cadastrar/usuario/edit/{usuario_id}", [\App\Http\Controllers\UsuarioController::class, 'editUser'])->name('usuario.edit');

#USUARIO PACIENTE
Route::get("/cadastrar/usuario/paciente/dados/create/{usuario_id}", [\App\Http\Controllers\PacienteController::class, 'createDadosUserPaciente'])->name('usuario.paciente.create.dados');
Route::post("/cadastrar/usuario/paciente/dados/store", [\App\Http\Controllers\PacienteController::class, 'storeDadosUserPaciente'])->name('usuario.paciente.store.dados');
Route::get("/cadastrar/usuario/paciente/dados/edit/{usuario_id}", [\App\Http\Controllers\PacienteController::class, 'editDadosUserPaciente'])->name('usuario.paciente.edit.dados');

#CADASTRO CARTAO
Route::get("/cadastrar/cartao/create/{usuario_id}", [\App\Http\Controllers\CartaoController::class, 'create'])->name('cartao.create');

#USUARIO ESPECIALISTA
Route::get("/cadastrar/usuario/especialista/dados/create/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'createDadosUserEspecialista'])->name('usuario.especialista.create.dados');
Route::post("/cadastrar/usuario/especialista/store", [\App\Http\Controllers\EspecialistaController::class, 'storeDadosUserEspecialista'])->name('usuario.especialista.store.dados');
Route::get("/cadastrar/usuario/especialista/dados/edit/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'editDadosUserEspecialista'])->name('usuario.especialista.edit.dados');

#USUARIO CLINICA
Route::get("/cadastrar/usuario/clinica/dados/create/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'createDadosUserClinica'])->name('usuario.clinica.create.dados');
Route::post("/cadastrar/usuario/clinica/store", [\App\Http\Controllers\ClinicaController::class, 'storeDadosUserClinica'])->name('usuario.clinica.store.dados');
Route::get("/cadastrar/usuario/clinica/dados/edit/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'editDadosUserClinica'])->name('usuario.clinica.edit.dados');
Route::get("/clinica/endereco/create/{usuario_id}", [\App\Http\Controllers\ClinicaController::class, 'createEnderecoClinica'])->name('clinica.create.endereco');
Route::post("/clinica/endereco/store", [\App\Http\Controllers\ClinicaController::class, 'storeEnderecoClinica'])->name('clinica.store.endereco');

#DADOS BANCARIOS
Route::get("/cadastrar/dados-bancários/create/{usuario_id}", [\App\Http\Controllers\EspecialistaController::class, 'createDadosBancarios'])->name('dados-bancarios.create');
Route::post("/cadastrar/dados-bancários/store", [\App\Http\Controllers\EspecialistaController::class, 'storeDadosBancarios'])->name('dados-bancarios.store');

#CADASTRO ENDERECO
Route::get("/cadastrar/endereço/create/{usuario_id}", [\App\Http\Controllers\EnderecoController::class, 'createEndereco'])->name('endereco.create');
Route::post("/cadastrar/endereço/store", [\App\Http\Controllers\EnderecoController::class, 'storeEndereco'])->name('endereco.store');

#ASSINATURA
Route::get("/checkout", [\App\Http\Controllers\CartaoController::class, 'create_checkout']);
Route::post("/pagamento/assinatura", [\App\Http\Controllers\AssinaturaController::class, 'lancarAssinatura'])->name('pagamento.assinatura');
Route::get("/callback-payment/assinatura", [\App\Http\Controllers\AssinaturaController::class, 'callbackPaymentAssinatura'])->name('callback.payment.assinatura');
Route::get("/pagamento/assinatura/renovar", [\App\Http\Controllers\AssinaturaController::class, 'renovacaoAutomatica'])->name('assinatura.renovar');
Route::get("/callback-payment/assinatura/renovar", [\App\Http\Controllers\AssinaturaController::class, 'callbackPaymentRenovarAssinatura'])->name('callback.payment.assinatura.renovar');

#VALIDAÇÕES
Route::get("/email/verificar/{usuario_id}", [\App\Http\Controllers\ValidacoesController::class, 'verificarEmail'])->name('view.verificar_email');
Route::get("/email/reenviar-sms/", [\App\Http\Controllers\ValidacoesController::class, 'reenviarEmail'])->name('validar.reenviar_email');
Route::post("/email/validar", [\App\Http\Controllers\ValidacoesController::class, 'validarEmail'])->name('validar.email');
Route::get("/celular/verificar/{usuario_id}", [\App\Http\Controllers\ValidacoesController::class, 'verificarCelular'])->name('view.verificar_celular');
Route::get("/celular/reenviar-sms/", [\App\Http\Controllers\ValidacoesController::class, 'reenviarSMS'])->name('validar.reenviar_sms');
Route::post("/celular/validar", [\App\Http\Controllers\ValidacoesController::class, 'validarCelular'])->name('validar.celular');

Route::post("/auth/user", [\App\Http\Controllers\UsuarioController::class, 'logar'])->name('login.do')->middleware('payment.signature');
Route::get("/logout", [\App\Http\Controllers\UsuarioController::class, 'logout'])->name('logout');
Route::get("/recuperar", [\App\Http\Controllers\UsuarioController::class, 'recover'])->name('recover');
Route::get("/recuperar/{id?}", [\App\Http\Controllers\UsuarioController::class, 'recoverID'])->name('recover.id');
Route::post("/recuperar", [\App\Http\Controllers\UsuarioController::class, 'recoverDo'])->name('recover.do');
Route::post("/updatepassword", [\App\Http\Controllers\UsuarioController::class, 'recoverPassword'])->name('update.password');

Route::middleware('auth')->group(function () {
    #DASHBORD
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'home'])->name('home');

    Route::get("/turnvendedor", [\App\Http\Controllers\UsuarioController::class, 'turnVendedor'])->name('user.turnvendedor');

    #USERS
    Route::get("/user/comentarios", [\App\Http\Controllers\UsuarioController::class, 'comentariosComprador'])->name('user.comentarios');
    Route::get("/user/compras", [\App\Http\Controllers\UsuarioController::class, 'compras'])->name('user.compras');
    Route::get("/user/favoritos", [\App\Http\Controllers\UsuarioController::class, 'listFavoritos'])->name('user.favoritos');
    Route::get("/user/notificacoes", [\App\Http\Controllers\UsuarioController::class, 'listNotificacoes'])->name('user.notificacoes');
    Route::get("/user/notificacao/{id}", [\App\Http\Controllers\UsuarioController::class, 'lerNotificacoes'])->name('user.notificacoes.ler');

    #PROFILE
    Route::get("/profile/{id?}", [\App\Http\Controllers\UsuarioController::class, 'preEdit'])->name('user.preedit');
    Route::post("/profile/update", [\App\Http\Controllers\UsuarioController::class, 'update'])->name('user.update');
    Route::put("/profile/update", [\App\Http\Controllers\UsuarioController::class, 'updateCompletar'])->name('user.update.comp');
    Route::post("/profile/delete", [\App\Http\Controllers\UsuarioController::class, 'delete'])->name('user.delete');
    Route::get("/profile/update/add", [\App\Http\Controllers\UsuarioController::class, 'addEndereco'])->name('user.update.add');
    Route::post("/profile/update/add", [\App\Http\Controllers\UsuarioController::class, 'addEnderecoDo'])->name('user.update.add.do');
    Route::get("/profile/endereco/del/{id}", [\App\Http\Controllers\UsuarioController::class, 'delEndereco'])->name('user.update.del.do');
    Route::get("/profile/endereco/principal/{id}", [\App\Http\Controllers\UsuarioController::class, 'setPrincialEndereco'])->name('user.update.end.pri');
    Route::get("/profile/update/add/{id}", [\App\Http\Controllers\UsuarioController::class, 'addEndereco'])->name('user.add.update');

    #ADVERTISEMENT
    Route::get("/advertisement", [\App\Http\Controllers\AnuncioController::class, 'list'])->name('advertisement.list');
    ;
    Route::get("/advertisement/add", [\App\Http\Controllers\AnuncioController::class, 'add'])->name('advertisement.add');
    ;
    Route::post("/advertisement/save", [\App\Http\Controllers\AnuncioController::class, 'save'])->name('advertisement.save');
    ;
    Route::post("/advertisement/preco", [\App\Http\Controllers\AnuncioController::class, 'passo2'])->name('advertisement.preco');
    ;
    Route::get("/advertisement/preco/{id}", [\App\Http\Controllers\AnuncioController::class, 'passo1'])->name('advertisement.back');
    ;
    Route::get("/advertisement/precoback/{id}", [\App\Http\Controllers\AnuncioController::class, 'passo2back'])->name('advertisement.back.fotos');
    ;
    Route::any("/advertisement/fotos", [\App\Http\Controllers\AnuncioController::class, 'passo3'])->name('advertisement.fotos');
    ;
    Route::any("/advertisement/fotos/{id}", [\App\Http\Controllers\AnuncioController::class, 'passoFotos'])->name('advertisement.passo.fotos');
    ;
    Route::any("/advertisement/finalizar/", [\App\Http\Controllers\AnuncioController::class, 'addFotos'])->name('advertisement.finalizar');
    ;
    Route::get("/advertisement/destacar/{id}", [\App\Http\Controllers\AnuncioController::class, 'destacar'])->name('advertisement.destacar');
    ;
    Route::post("/advertisement/destacar/{id}", [\App\Http\Controllers\AnuncioController::class, 'destacarDo'])->name('advertisement.destacar.do');
    ;
    Route::get("/advertisement/tamanho/{id}", [\App\Http\Controllers\AnuncioController::class, 'tamanho'])->name('advertisement.tamanho');
    ;
    Route::post("/advertisement/tamanho/add/{id}", [\App\Http\Controllers\AnuncioController::class, 'tamanhoAdd'])->name('advertisement.tamanho.add');
    ;
    Route::get("/advertisement/tamanho/del/{id}", [\App\Http\Controllers\AnuncioController::class, 'deleteTamanho'])->name('advertisement.tamanho.del');
    ;
    Route::get("/advertisement/tamanho/edit/{id}", [\App\Http\Controllers\AnuncioController::class, 'editTamanho'])->name('advertisement.tamanho.edit');
    ;
    Route::get("/advertisement/fim/{id}", [\App\Http\Controllers\AnuncioController::class, 'finalizar'])->name('advertisement.tamanho.finalizar');
    ;
    Route::get("/advertisement/delete/{id}", [\App\Http\Controllers\AnuncioController::class, 'delete'])->name('advertisement.delete');
    ;
    Route::get("/advertisement/edit/{id}", [\App\Http\Controllers\AnuncioController::class, 'edit'])->name('advertisement.edit');
    ;

    #FAVORITE
    Route::get("/favorite/add/{id}", [\App\Http\Controllers\AnuncioController::class, 'addFavorite'])->name('advertisement.addfavorito');
    Route::get("/favorite/list", [\App\Http\Controllers\AnuncioController::class, 'listFavorite'])->name('advertisement.listfavorito');
    Route::get("/favorite/remove/{id}", [\App\Http\Controllers\AnuncioController::class, 'remFavorite'])->name('advertisement.remfavorito');

    /*TODO REFACTORY TO FRONT */
    Route::get("/detail/{id}", [\App\Http\Controllers\AnuncioController::class, 'produtctDetail'])->name('advertisement.detail');
    Route::post("/comentario/add/", [\App\Http\Controllers\AnuncioController::class, 'addComentario'])->name('advertisement.comentario.add');

    #CART
    Route::get("/cart/add/", [\App\Http\Controllers\AnuncioController::class, 'addSession'])->name('advertisement.addsession');
    Route::get("/cart/view/", [\App\Http\Controllers\AnuncioController::class, 'viewSession'])->name('advertisement.viewssesion');
    Route::any("/cart/clear/", [\App\Http\Controllers\AnuncioController::class, 'clearCarr'])->name('cart.clear');
    Route::get("/cart/remqnt/{id}", [\App\Http\Controllers\CheckoutControler::class, 'removerQntCarrinho'])->name('cart.remqtd');
    Route::get("/cart/addqnt/{id}", [\App\Http\Controllers\CheckoutControler::class, 'addQntCarrinho'])->name('cart.addqtd');

    #CHECK OUT
    Route::post("/checkout/create", [\App\Http\Controllers\CheckoutControler::class, 'create'])->name('vendas.create');
    ;
    Route::get("/checkout/address", [\App\Http\Controllers\CheckoutControler::class, 'addEndereco'])->name('vendas.adr.create');
    ;
    Route::post("/checkout/address/save", [\App\Http\Controllers\CheckoutControler::class, 'saveEndereco'])->name('vendas.adr.save');
    ;
    Route::get("/checkout/confirmpay/{id}", [\App\Http\Controllers\CheckoutControler::class, 'posProcessPagamento'])->name('vendas.payment');
    Route::get("/checkout/useraddress/{id?}", [\App\Http\Controllers\UsuarioController::class, 'findAdress'])->name('vendas.endereco');
    ;
    Route::any("/checkout/confirmpay", [\App\Http\Controllers\CheckoutControler::class, 'returnPagSeguro'])->name('vendas.payment.return');

    #SALES
    Route::get("/sales/list", [\App\Http\Controllers\VendasController::class, 'list'])->name('sales.list');
    ;
    Route::get("/sales/send/{id}", [\App\Http\Controllers\VendasController::class, 'send'])->name('sales.send');
    ;
    Route::post("/sales/send/do/{id}", [\App\Http\Controllers\VendasController::class, 'sendDo'])->name('sales.send.do');
    ;
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
    Route::get("/especialidadeclinica/listclinica", [\App\Http\Controllers\EspecialidadeclinicaController::class, 'listclinica'])->name('especialidadeclinica.listclinica');

    #ESPECIALISTA
    Route::get("/especialista/list", [\App\Http\Controllers\EspecialistaController::class, 'list'])->name('especialista.list');
    Route::get("/especialista/new", [\App\Http\Controllers\EspecialistaController::class, 'new'])->name('especialista.new');
    Route::post("/especialista/search", [\App\Http\Controllers\EspecialistaController::class, 'search'])->name('especialista.search');
    Route::post("/especialista/save", [\App\Http\Controllers\EspecialistaController::class, 'save'])->name('especialista.save');
    Route::get("/especialista/delete/{id}", [\App\Http\Controllers\EspecialistaController::class, 'delete'])->name('especialista.delete');
    Route::get("/especialista/edit/{id}", [\App\Http\Controllers\EspecialistaController::class, 'edit'])->name('especialista.edit');

    #ESPECIALISTA_POR_CLINICA
    Route::get("/especialistaclinica/list/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'list'])->name('especialistaclinica.list');
    Route::get("/especialistaclinica/new/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'new'])->name('especialistaclinica.new');
    Route::get("/especialistaclinica/search/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'search'])->name('especialistaclinica.search');
    Route::post("/especialistaclinica/save/{clinica_id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'save'])->name('especialistaclinica.save');
    Route::get("/especialistaclinica/delete/{id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'delete'])->name('especialistaclinica.delete');
    Route::get("/especialistaclinica/edit/{id}", [\App\Http\Controllers\EspecialistaclinicaController::class, 'edit'])->name('especialistaclinica.edit');

    #CONSULTAS_DISPONIBILIZADAS_POR_ESPECIALISTA
    Route::get("/consulta/list/", [\App\Http\Controllers\ConsultaController::class, 'list'])->name('consulta.list');
    Route::get("/consulta/new/{especialista_id}", [\App\Http\Controllers\ConsultaController::class, 'new'])->name('consulta.new');
    Route::get("/consulta/search/{especialista_id}", [\App\Http\Controllers\ConsultaController::class, 'search'])->name('consulta.search');
    Route::post("/consulta/save/{especialista_id}", [\App\Http\Controllers\ConsultaController::class, 'save'])->name('consulta.save');
    Route::get("/consulta/delete/{id}", [\App\Http\Controllers\ConsultaController::class, 'delete'])->name('consulta.delete');
    Route::get("/consulta/edit/{id}", [\App\Http\Controllers\ConsultaController::class, 'edit'])->name('consulta.edit');
    Route::get("/consulta/agenda/", [\App\Http\Controllers\ConsultaController::class, 'agenda'])->name('consulta.agenda');
    Route::post("/consulta/saveagenda/", [\App\Http\Controllers\ConsultaController::class, 'saveVariasConsultas'])->name('consulta.saveagenda');

    #CLINICAS_POR_ESPECIALISTA
    Route::get("/clinica/vinculo/", [\App\Http\Controllers\EspecialistaclinicaController::class, 'clinicasdoespecilista'])->name('especialistaclinica.clinicas');

    #CONSULTAS_POR_ESPECIALISTA
    Route::get("/consulta/listconsultas/", [\App\Http\Controllers\ConsultaController::class, 'listconsultaporespecialista'])->name('consulta.listconsultaporespecialista')->middleware('auth');
    Route::get("/consulta/listconsultas/search", [\App\Http\Controllers\ConsultaController::class, 'listConsultaPorEspecialistaPesquisar'])->name('consulta.listConsultaPorEspecialistaPesquisar')->middleware('auth');

    #ROTAS_USER_PACIENTE +++++++++++++++++++++++++++++
    Route::get("/paciente/home/", [\App\Http\Controllers\PacienteController::class, 'home'])->name('paciente.home')->middleware('auth');

    #MARCAR_CONSULTA_USUARIO_PACIENTE
    Route::get("/paciente/marcarconsulta/", [\App\Http\Controllers\PacienteController::class, 'marcarconsulta'])->name('paciente.marcarconsulta');

    #VIA_CLINICA
    Route::get("/paciente/marcarconsulta/viaclinica/etapa2", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso1'])->name('paciente.marcarConsultaViaClinicaPasso1');
    Route::get("/paciente/marcarconsulta/viaclinica/etapa3/{id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso2'])->name('paciente.marcarConsultaViaClinicaPasso2');
    Route::get("/paciente/marcarconsulta/viaclinica/etapa4/{clinica_id}/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso3'])->name('paciente.marcarConsultaViaClinicaPasso3');
    Route::get("/paciente/marcarconsulta/viaclinica/etapa5/{clinica_id}/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaPasso4'])->name('paciente.marcarConsultaViaClinicaPasso4');
    Route::post("/paciente/marcarconsulta/viaclinica/finalizar/", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaClinicaFinalizar'])->name('paciente.marcarConsultaViaClinicaFinalizar');
    Route::get("/paciente/viaclinica/search/", [\App\Http\Controllers\PacienteController::class, 'pesquisarclinicamarcarconsulta'])->name('paciente.pesquisarclinicamarcarconsulta');

    #VIA_ESPECIALIDADE
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa2", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso1'])->name('paciente.marcarConsultaViaEspecialidadePasso1');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa3/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso2'])->name('paciente.marcarConsultaViaEspecialidadePasso2');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa3/{especialidade_id}/{clinica_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso3'])->name('paciente.marcarConsultaViaEspecialidadePasso3');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa4/{clinica_id}/{especialista_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso4'])->name('paciente.marcarConsultaViaEspecialidadePasso4');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa2", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso1'])->name('paciente.marcarConsultaViaEspecialidadePasso1')->middleware('auth');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa3/{especialidade_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso2'])->name('paciente.marcarConsultaViaEspecialidadePasso2')->middleware('auth');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa3/{especialidade_id}/{clinica_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso3'])->name('paciente.marcarConsultaViaEspecialidadePasso3')->middleware('auth');
    Route::get("/paciente/marcarconsulta/viaespecialidade/etapa4/{clinica_id}/{especialista_id}", [\App\Http\Controllers\PacienteController::class, 'marcarConsultaViaEspecialidadePasso4'])->name('paciente.marcarConsultaViaEspecialidadePasso4')->middleware('auth');

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


    #CONSULTAS_USER_PACIENTE
    Route::get("/paciente/minhasconsultas/", [\App\Http\Controllers\PacienteController::class, 'minhasconsultas'])->name('paciente.minhasconsultas');
    Route::get("/paciente/historicoconsultas/", [\App\Http\Controllers\PacienteController::class, 'historicoconsultas'])->name('paciente.historicoconsultas');
    Route::post("/paciente/cancelar/", [\App\Http\Controllers\PacienteController::class, 'canelarconsulta'])->name('consulta.cancelarviapaciente');


    #ESPECIALISTA
    Route::get("/especialista/atendimento/{consulta_id}/{aba}", [\App\Http\Controllers\EspecialistaController::class, 'inicarAtendimento'])->name('especialista.iniciarAtendimento')->middleware('auth');
    Route::get("/especialista/atendimento/finalizar/{consulta_id}", [\App\Http\Controllers\EspecialistaController::class, 'finalizarAtendimento'])->name('especialista.finalizarAtendimento')->middleware('auth');
    Route::get("/especialista/pacientes/", [\App\Http\Controllers\EspecialistaController::class, 'listaPacientes'])->name('especialista.listaPacientes')->middleware('auth');
    Route::get("/especialista/pedidoexame/list", [\App\Http\Controllers\PedidoExameController::class, 'list'])->name('pedido_exame.list')->middleware('auth');
    Route::post("/especialista/pedidoexame/save", [\App\Http\Controllers\PedidoExameController::class, 'salveVarios'])->name('pedido_exame.salveVarios')->middleware('auth');
    Route::get("/especialista/pedidoexame/delete/{id}/{consulta_id}", [\App\Http\Controllers\PedidoExameController::class, 'delete'])->name('pedido_exame.delete')->middleware('auth');

    #FINANCEIRO PACIENTE
    Route::get("/paciente/financeiro/", [\App\Http\Controllers\PagamentoController::class, 'historicoPagamentoPaciente'])->name('paciente.financeiro');
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
