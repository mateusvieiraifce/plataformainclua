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

Route::get("/", [\App\Http\Controllers\UsuarioController::class, 'index'])->name('index');

Route::get('/checkout', [\App\Http\Controllers\CheckoutControler::class, "checkout"])->name('finalizar');

Route::post('/mail',[\App\Http\Controllers\MailController::class,"sendMail"])->name('sendmail');

Route::get("/cadastrar/usuario/create",[\App\Http\Controllers\UsuarioController::class,'createUser'])->name('usuario.create');
Route::post("/cadastrar/usuario/store",[\App\Http\Controllers\UsuarioController::class,'storeUser'])->name('usuario.store');
Route::get("/cadastrar/dados/create/{id_usuario}",[\App\Http\Controllers\UsuarioController::class,'createDadosPessoais'])->name('usuario.dados.create');
Route::post("/cadastrar/dados/store",[\App\Http\Controllers\UsuarioController::class,'storeDadosPessoais'])->name('usuario.dados.pessoais');
Route::get("/telefone/verificar/{id_usuario}",[\App\Http\Controllers\UsuarioController::class,'verificarTelefone'])->name('usuario.verificar_telefone');
Route::get("/telefone/reenviar-sms/",[\App\Http\Controllers\UsuarioController::class,'reenviarSMS'])->name('usuario.reenviar_sms');
Route::post("/telefone/validar",[\App\Http\Controllers\UsuarioController::class,'validarTelefone'])->name('usuario.validar_telefone');
Route::get("/cadastrar/endereço/create/{id_usuario}",[\App\Http\Controllers\EnderecoController::class,'createEndereco'])->name('endereco.create');
Route::post("/cadastrar/endereço/store",[\App\Http\Controllers\EnderecoController::class,'storeEndereco'])->name('endereco.store');
Route::get("/cadastrar/cartao/create/{id_usuario}",[\App\Http\Controllers\CartaoController::class,'create'])->name('cartao.create');
Route::post("/cadastrar/cartao/create",[\App\Http\Controllers\CartaoController::class,'store'])->name('cartao.store');

Route::post("/auth/user",[\App\Http\Controllers\UsuarioController::class,'logar'])->name('login.do');
Route::get("/logout",[\App\Http\Controllers\UsuarioController::class,'logout'])->name('logout');
Route::get("/recuperar",[\App\Http\Controllers\UsuarioController::class,'recover'])->name('recover');
Route::get("/recuperar/{id?}",[\App\Http\Controllers\UsuarioController::class,'recoverID'])->name('recover.id');
Route::post("/recuperar",[\App\Http\Controllers\UsuarioController::class,'recoverDo'])->name('recover.do');
Route::post("/updatepassword",[\App\Http\Controllers\UsuarioController::class,'recoverPassword'])->name('update.password');

#URL's AUTH GOOGLE
Route::get('/google/redirect', [\App\Http\Controllers\UsuarioController::class,'redirectToProvider'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\UsuarioController::class,'handleProviderCallback'])->name('google.callback');

Route::middleware('auth')->group(function() {
    #DASHBORD
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'home'])->name('home');

    Route::get("/turnvendedor",[\App\Http\Controllers\UsuarioController::class,'turnVendedor'])->name('user.turnvendedor');
    
    #USERS
    Route::get("/user/comentarios",[\App\Http\Controllers\UsuarioController::class,'comentariosComprador'])->name('user.comentarios');
    Route::get("/user/compras",[\App\Http\Controllers\UsuarioController::class,'compras'])->name('user.compras');
    Route::get("/user/favoritos",[\App\Http\Controllers\UsuarioController::class,'listFavoritos'])->name('user.favoritos');
    Route::get("/user/notificacoes",[\App\Http\Controllers\UsuarioController::class,'listNotificacoes'])->name('user.notificacoes');
    Route::get("/user/notificacao/{id}",[\App\Http\Controllers\UsuarioController::class,'lerNotificacoes'])->name('user.notificacoes.ler');

    #PROFILE
    Route::get("/profile/{id?}",[\App\Http\Controllers\UsuarioController::class,'preEdit'])->name('user.preedit');
    Route::post("/profile/update",[\App\Http\Controllers\UsuarioController::class,'update'])->name('user.update');
    Route::put("/profile/update",[\App\Http\Controllers\UsuarioController::class,'updateCompletar'])->name('user.update.comp');
    Route::post("/profile/delete",[\App\Http\Controllers\UsuarioController::class,'delete'])->name('user.delete');
    Route::get("/profile/update/add",[\App\Http\Controllers\UsuarioController::class,'addEndereco'])->name('user.update.add');
    Route::post("/profile/update/add",[\App\Http\Controllers\UsuarioController::class,'addEnderecoDo'])->name('user.update.add.do');
    Route::get("/profile/endereco/del/{id}",[\App\Http\Controllers\UsuarioController::class,'delEndereco'])->name('user.update.del.do');
    Route::get("/profile/endereco/principal/{id}",[\App\Http\Controllers\UsuarioController::class,'setPrincialEndereco'])->name('user.update.end.pri');
    Route::get("/profile/update/add/{id}",[\App\Http\Controllers\UsuarioController::class,'addEndereco'])->name('user.add.update');

    #ADVERTISEMENT
    Route::get("/advertisement",[\App\Http\Controllers\AnuncioController::class,'list'])->name('advertisement.list');;
    Route::get("/advertisement/add",[\App\Http\Controllers\AnuncioController::class,'add'])->name('advertisement.add');;
    Route::post("/advertisement/save",[\App\Http\Controllers\AnuncioController::class,'save'])->name('advertisement.save');;
    Route::post("/advertisement/preco",[\App\Http\Controllers\AnuncioController::class,'passo2'])->name('advertisement.preco');;
    Route::get("/advertisement/preco/{id}",[\App\Http\Controllers\AnuncioController::class,'passo1'])->name('advertisement.back');;
    Route::get("/advertisement/precoback/{id}",[\App\Http\Controllers\AnuncioController::class,'passo2back'])->name('advertisement.back.fotos');;
    Route::any("/advertisement/fotos",[\App\Http\Controllers\AnuncioController::class,'passo3'])->name('advertisement.fotos');;
    Route::any("/advertisement/fotos/{id}",[\App\Http\Controllers\AnuncioController::class,'passoFotos'])->name('advertisement.passo.fotos');;
    Route::any("/advertisement/finalizar/",[\App\Http\Controllers\AnuncioController::class,'addFotos'])->name('advertisement.finalizar');;
    Route::get("/advertisement/destacar/{id}",[\App\Http\Controllers\AnuncioController::class,'destacar'])->name('advertisement.destacar');;
    Route::post("/advertisement/destacar/{id}",[\App\Http\Controllers\AnuncioController::class,'destacarDo'])->name('advertisement.destacar.do');;
    Route::get("/advertisement/tamanho/{id}",[\App\Http\Controllers\AnuncioController::class,'tamanho'])->name('advertisement.tamanho');;
    Route::post("/advertisement/tamanho/add/{id}",[\App\Http\Controllers\AnuncioController::class,'tamanhoAdd'])->name('advertisement.tamanho.add');;
    Route::get("/advertisement/tamanho/del/{id}",[\App\Http\Controllers\AnuncioController::class,'deleteTamanho'])->name('advertisement.tamanho.del');;
    Route::get("/advertisement/tamanho/edit/{id}",[\App\Http\Controllers\AnuncioController::class,'editTamanho'])->name('advertisement.tamanho.edit');;
    Route::get("/advertisement/fim/{id}",[\App\Http\Controllers\AnuncioController::class,'finalizar'])->name('advertisement.tamanho.finalizar');;
    Route::get("/advertisement/delete/{id}",[\App\Http\Controllers\AnuncioController::class,'delete'])->name('advertisement.delete');;
    Route::get("/advertisement/edit/{id}",[\App\Http\Controllers\AnuncioController::class,'edit'])->name('advertisement.edit');;

    #FAVORITE
    Route::get("/favorite/add/{id}",[\App\Http\Controllers\AnuncioController::class,'addFavorite'])->name('advertisement.addfavorito');
    Route::get("/favorite/list",[\App\Http\Controllers\AnuncioController::class,'listFavorite'])->name('advertisement.listfavorito');
    Route::get("/favorite/remove/{id}",[\App\Http\Controllers\AnuncioController::class,'remFavorite'])->name('advertisement.remfavorito');

    /*TODO REFACTORY TO FRONT */
    Route::get("/detail/{id}",[\App\Http\Controllers\AnuncioController::class,'produtctDetail'])->name('advertisement.detail');
    Route::post("/comentario/add/",[\App\Http\Controllers\AnuncioController::class,'addComentario'])->name('advertisement.comentario.add');

    #CART
    Route::get("/cart/add/",[\App\Http\Controllers\AnuncioController::class,'addSession'])->name('advertisement.addsession');
    Route::get("/cart/view/",[\App\Http\Controllers\AnuncioController::class,'viewSession'])->name('advertisement.viewssesion');
    Route::any("/cart/clear/",[\App\Http\Controllers\AnuncioController::class,'clearCarr'])->name('cart.clear');
    Route::get("/cart/remqnt/{id}",[\App\Http\Controllers\CheckoutControler::class,'removerQntCarrinho'])->name('cart.remqtd');
    Route::get("/cart/addqnt/{id}",[\App\Http\Controllers\CheckoutControler::class,'addQntCarrinho'])->name('cart.addqtd');

    #CHECK OUT
    Route::post("/checkout/create",[\App\Http\Controllers\CheckoutControler::class,'create'])->name('vendas.create');;
    Route::get("/checkout/address",[\App\Http\Controllers\CheckoutControler::class,'addEndereco'])->name('vendas.adr.create');;
    Route::post("/checkout/address/save",[\App\Http\Controllers\CheckoutControler::class,'saveEndereco'])->name('vendas.adr.save');;
    Route::get("/checkout/confirmpay/{id}",[\App\Http\Controllers\CheckoutControler::class,'posProcessPagamento'])->name('vendas.payment');
    Route::get("/checkout/useraddress/{id?}",[\App\Http\Controllers\UsuarioController::class,'findAdress'])->name('vendas.endereco');;
    Route::any("/checkout/confirmpay",[\App\Http\Controllers\CheckoutControler::class,'returnPagSeguro'])->name('vendas.payment.return');

    #SALES
    Route::get("/sales/list", [\App\Http\Controllers\VendasController::class,'list'])->name('sales.list');;
    Route::get("/sales/send/{id}",[\App\Http\Controllers\VendasController::class,'send'])->name('sales.send');;
    Route::post("/sales/send/do/{id}",[\App\Http\Controllers\VendasController::class,'sendDo'])->name('sales.send.do');;
    Route::get("/send/mail",[\App\Http\Controllers\MailController::class,'sendMenssagem'])->name('sales.send.do.email');

    #ESPECIALIDADES
    Route::get("/especialidade/list",[\App\Http\Controllers\EspecialidadeController::class,'list'])->name('especialidade.list');
    Route::get("/especialidade/new",[\App\Http\Controllers\EspecialidadeController::class,'new'])->name('especialidade.new');
    Route::post("/especialidade/search",[\App\Http\Controllers\EspecialidadeController::class,'search'])->name('especialidade.search');
    Route::post("/especialidade/save",[\App\Http\Controllers\EspecialidadeController::class,'save'])->name('especialidade.save');
    Route::get("/especialidade/delete/{id}",[\App\Http\Controllers\EspecialidadeController::class,'delete'])->name('especialidade.delete');
    Route::get("/especialidade/edit/{id}",[\App\Http\Controllers\EspecialidadeController::class,'edit'])->name('especialidade.edit');

    #FORMA DE PAGAMENTO
    Route::get("/formapagamento/list",[\App\Http\Controllers\FormapagamentoController::class,'list'])->name('formapagamento.list');
    Route::get("/formapagamento/new",[\App\Http\Controllers\FormapagamentoController::class,'new'])->name('formapagamento.new');
    Route::post("/formapagamento/search",[\App\Http\Controllers\FormapagamentoController::class,'search'])->name('formapagamento.search');
    Route::post("/formapagamento/save",[\App\Http\Controllers\FormapagamentoController::class,'save'])->name('formapagamento.save');
    Route::get("/formapagamento/delete/{id}",[\App\Http\Controllers\FormapagamentoController::class,'delete'])->name('formapagamento.delete');
    Route::get("/formapagamento/edit/{id}",[\App\Http\Controllers\FormapagamentoController::class,'edit'])->name('formapagamento.edit');

    #CLINICA
    Route::get("/clinica/list",[\App\Http\Controllers\ClinicaController::class,'list'])->name('clinica.list');
    Route::get("/clinica/new",[\App\Http\Controllers\ClinicaController::class,'new'])->name('clinica.new');
    Route::post("/clinica/search",[\App\Http\Controllers\ClinicaController::class,'search'])->name('clinica.search');
    Route::post("/clinica/save",[\App\Http\Controllers\ClinicaController::class,'save'])->name('clinica.save');
    Route::get("/clinica/delete/{id}",[\App\Http\Controllers\ClinicaController::class,'delete'])->name('clinica.delete');
    Route::get("/clinica/edit/{id}",[\App\Http\Controllers\ClinicaController::class,'edit'])->name('clinica.edit');

    #ESPECIALIDADE_CLINICA
    Route::get("/especialidadeclinica/list/{clinica_id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'list'])->name('especialidadeclinica.list')->middleware('auth');
    Route::get("/especialidadeclinica/new/{clinica_id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'new'])->name('especialidadeclinica.new')->middleware('auth');
    Route::get("/especialidadeclinica/search/{clinica_id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'search'])->name('especialidadeclinica.search')->middleware('auth');
    Route::post("/especialidadeclinica/save/{clinica_id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'save'])->name('especialidadeclinica.save')->middleware('auth');
    Route::get("/especialidadeclinica/delete/{id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'delete'])->name('especialidadeclinica.delete')->middleware('auth');
    Route::get("/especialidadeclinica/edit/{id}",[\App\Http\Controllers\EspecialidadeclinicaController::class,'edit'])->name('especialidadeclinica.edit')->middleware('auth');
    
});

/* ROTAS PARA SEREM ANALISADAS */
Route::get('/compras', function () {
    $usuario = Auth::user();
    $compras = \App\Models\Vendas::where('comprador_id','=',$usuario->id)->orderBy('created_at','desc')->get();
    return view('dashboard',['compras'=>$compras]);
})->name('compras.list')->middleware('auth');

Route::get('/users', function () {
    return view('users/index');
})->name('profile.edit')->middleware('auth');

Route::get('/users/index', function () {
    return view('users/index');
})->name('user.index');