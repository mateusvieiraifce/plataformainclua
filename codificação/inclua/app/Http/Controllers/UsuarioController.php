<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Mail\verificarEmail;
use App\Models\Anuncio;
use App\Models\Comentarios;
use App\Models\Endereco;
use App\Models\Favoritos;
use App\Models\Language;
use App\Models\Notificacoes;
use App\Models\PasswordResets;
use App\Models\User;
use App\Models\Vendas;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UsuarioController extends Controller
{
    function  findAdress($id=0){
        return Endereco::find($id);
    }

    public function index()
    {
        return view('auth.login', ['pageSlug' => '']);
    }

    function recover($id=null){
        return view('auth/passwords/email',['pageSlug'=>'']);
    }

    function recoverDo(Request $request){
        $existe = User::where('email','=',$request->email)->first();
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        $token = "";
        if ($existe){
            $utimoreset = PasswordResets::where('email','=',$request->email)->orderBy('created_at')->first();
            $today = \DateTime::createFromFormat('d/m/y',date('d/m/y'));
            if ($utimoreset){
                $datacreat = \DateTime::createFromFormat('Y-m-d H:i:s', $utimoreset->created_at);
                $datacreat = $datacreat->add(new \DateInterval('P2D')); // 2 dias
                if ($datacreat<$today){
                    $utimoreset->delete();
                    $token =  $this->createToken($request,$today);
                }else{
                    $token = $utimoreset->token;
                }
            }else{
                $token =  $this->createToken($request,$today);
            }
            $msgemail = " <br>Para recuperar sua conta, acesse o link, ".
                ", acessse  ".env('URL_RECOVER').$token.
                " Atenciosamente, Ecomoda. ";
            Helper::sendEmail("Recuperação de senha da  Plataforma Ecomoda",$msgemail,$request->email);

        }else{
            //$msg = ['valor'=>trans('messport.pass_conf'),'tipo'=>'primary'];
            $msgret = ['valor'=>"Usuário não existe",'tipo'=>'danger'];
        }

       return view('auth/passwords/email',['pageSlug'=>'','token'=>$token,'msg'=>$msgret]);
    }

    function recoverID($id=null){
        $voucher = PasswordResets::where('token','=',$id)->first();
        $msgret =null;
        $user = null;
        if ($voucher){
            $user = User::where('email','=',$voucher->email)->first();

        }else{
            $msgret = ['valor'=>"Usuário não existe",'tipo'=>'danger'];
        }

        return view('auth/passwords/reset',['pageSlug'=>'','token'=>'$token','msg'=>$msgret,'usuario'=>$user]);
    }

    function recoverPassword(Request $request){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        $usuario = User::where("id","=",$request->id)->first();
        try{
            $variable=$request->password;
            $input = $request->validate([
                'password' => 'required|between :5,15',
                'password_confirmation' => 'required|between :5,15|in:'.$variable,
             ]);


            $usuario->password = bcrypt($request->password);
            $usuario->save();
            $user = $usuario;
            return view('auth/login',['msg'=>$msgret] );
        }catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }
        return view('auth/passwords/reset',['pageSlug'=>'','token'=>'$token','msg'=>$msgret,'usuario'=>$usuario]);
    }

    private function  createToken(Request $request,$today){
        $token = Str::random(60);
        $re = new PasswordResets();
        $re->email= $request->email;
        $re->token = $token;
        $re->created_at = $today;
        $re->save();
        return $re->token;
    }

    function logar(Request  $request){


        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);


        $dados =['email' => $request->email,'password' => $request->password];
        if (Auth::attempt($dados, false)) {
            $request->session()->regenerate();

            if (session()->has('nextview')) {
                //dd(session('nextview'));
                return redirect(session('nextview'));
            }
            $usuario = Auth::user();
            return view('dashboard',[] );
            #return redirect()->intended('dashboard',['compras'=>[]]);
        } else{

            $msg = ['valor'=>'Usuário/Senha inválido','tipo'=>'danger'];
            return view('auth/login',['msg'=>$msg] );
        }

        //return view('auth/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    public function createUser()
    {
        return view('cadastro.form_usuario');
    }

    public function storeUser(Request $request)
    {
        $rules = [
            "email" => "required|unique:users,email",
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        ];
        $feedbacks = [
            "email.required" => "O campo Email é obrigatório.",
            "email.unique" => "O email utilizado já foi cadastrado.",
            "password.required" => "O campo Senha é obrigatório.",
            "password.confirmed" => "As senhas não são correspondentes.",
            "password.min" => "O campo senha deve ter no mínimo 5 caracteres.",
            "password_confirmation.required" => "O campo Confirmar a senha é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->codigo_validacao = Helper::generateRandomNumberString(5);
            $user->tipo_pessoa = $request->tipo_pessoa;
            $user->tipo_user = $request->tipo_user;
            Helper::sendEmail("Validação de Código", "Seu Código de Verificação é:".$user->codigo_validacao, $user->email);
            $user->save();
            //ENVIAR O EMAIL COM CÓDIGO DE CONFIRMAÇÃO

            //Mail::to($user->email)->send(new verificarEmail($user->codigo_validacao));

            $msg = ['valor' => trans("Cadastro do usuário realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('usuario.verificar_email', ['id_usuario' => $user->id]);
    }

    public function editUser($id_usuario)
    {
        $user = User::find($id_usuario);
        return view('cadastro.form_usuario', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {
        $rules = [
            "email" => "required|unique:users,email,{$request->id_usuario}",
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        ];
        $feedbacks = [
            "email.required" => "O campo Email é obrigatório.",
            "email.unique" => "O email utilizado já foi cadastrado.",
            "password.required" => "O campo Senha é obrigatório.",
            "password.confirmed" => "As senhas não são correspondentes.",
            "password.min" => "O campo senha deve ter no mínimo 5 caracteres.",
            "password_confirmation.required" => "O campo Confirmar a senha é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        $user = User::find($request->id_usuario);
        try {
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->codigo_validacao = Helper::generateRandomNumberString(5);

            //ENVIAR O EMAIL COM CÓDIGO DE CONFIRMAÇÃO
            //Mail::to($user->email)->send(new verificarEmail($user->codigo_validacao));

            Helper::sendEmail("Validação de Código","Seu código de validação é:".$user->codigo_validacao, $user->email);
            $user->save();

            $msg = ['valor' => trans("Edição do cadastro do usuário realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('usuario.verificar_email', ['id_usuario' => $user->id]);
    }

    public function verificarEmail($id_usuario)
    {
        $user = User::find($id_usuario);
        return view('cadastro.verificar_email', ['id_usuario' => $id_usuario, 'email' => $user->email]);
    }

    public function reenviarEmail(Request $request)
    {
        $user = User::find($request->usuario);
        $user->codigo_validacao = Helper::generateRandomNumberString(5);


        Helper::sendEmail("Re-Envio de Código de validação","o seu codigo de validação é:".$user->codigo_validacao,$user->email);
        $user->save();
        //ENVIAR O EMAIL COM CÓDIGO DE CONFIRMAÇÃO
        //Mail::to($user->email)->send(new verificarEmail($user->codigo_validacao));
        $response = true;

        return response()->json($response);
    }

    public function validarEmail(Request $request)
    {
        $rules = [
            "codigo" => "required",
        ];
        $feedbacks = [
            "codigo.required" => "O campo Código é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            $user = User::find($request->id_usuario);
            if ($request->codigo == $user->codigo_validacao) {
                // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
                date_default_timezone_set('America/Sao_Paulo');
                $dataLocal = date('Y-m-d H:i:s', time());

                $user->email_verified_at = $dataLocal;
                $user->save();

                $msg = ['valor' => trans("Seu email foi verificado com sucesso!"), 'tipo' => 'success'];
                session()->flash('msg', $msg);
            } else {
                $msg = ['valor' => trans("O código informado esta incorreto!"), 'tipo' => 'danger'];
                session()->flash('msg', $msg);

                return back();
            }
        } catch(QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('usuario.dados.create', ['id_usuario' => $user->id]);
    }

    public function createDadosPessoais($id_usuario)
    {
        return view('cadastro.form_dados_pessoais', ['id_usuario' => $id_usuario]);
    }

    public function storeDadosPessoais(Request $request)
    {
        //REMOÇÃO DA MASCARA DO CELULAR PARA COMPARAR COM O BD
        $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
        $rules = [
            "image" => "required",
            "cpf" => "required",
            "nome" => "required|min:5",
            "celular" => "required|unique:users,celular,{$request->id_usuario}",
            "data_nascimento" => "required",
            "estado_civil" => "required",
            "sexo" => "required",
            'consentimento'=>'required',
        ];
        $feedbacks = [
            "image.required" => "O campo Imagem é obrigatório.",
            "cpf.required" => "O campo CPF é obrigatório.",
            "nome.required" => "O campo nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
            "celular.required" => "O campo Celular é obrigatório.",
            "celular.unique" => "Este número de celular já foi utilizado.",
            "data_nascimento.required" => "O campo Data de Nascimento é obrigatório.",
            "estado_civil.required" => "O campo Estado Civil é obrigatório.",
            "sexo.required" => "O campo Gênero é obrigatório.",
            "consentimento.required" => "O campo Termos e Condições de Uso é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            //salvando a avatar do usuario
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUM AVATAR JA CADASTRADO PARA DELETAR
                $avatarSimbolico = User::find($request->id_usuario)->avatar;
                if(!empty($avatarSimbolico)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $avatarSimbolico);
                    $linkStorage = "$linkStorage[1]/$linkStorage[2]";
                    Storage::delete([$linkStorage]);
                }

                // Nome do Arquivo
                $requestImage = $request->image;
                // Recupera a extensão do arquivo
                $extension = $requestImage->extension();
                // Define o nome
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                // Faz o upload:
                $pathAvatar = $request->file('image')->storeAs('avatar-user', $imageName);
            }

            $user = User::find($request->id_usuario);
            $user->avatar = "storage/$pathAvatar";
            $user->documento = Helper::removerCaractereEspecial($request->cpf);
            $user->nome_completo = $request->nome;
            $user->celular = Helper::removerCaractereEspecial($request->celular);
            $user->rg = $request->rg;
            $user->data_nascimento = $request->data_nascimento;
            $user->estado_civil = $request->estado_civil;
            $user->sexo = $request->sexo;
            $user->consentimento = $request->consentimento;
            $user->tipo_pessoa = $request->tipo_pessoa;
            $user->tipo_user = $request->tipo_user;
            $user->codigo_validacao = Helper::generateRandomNumberString(5);
            $user->save();
            Helper::sendSms($user->celular, "Bem vindo a plataforma Inclua, o seu código de verificação é: $user->codigo_validacao");

            $msg = ['valor' => trans("Cadastro de dados pessoais realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            dd($e);
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('usuario.verificar_celular', ['id_usuario' => $user->id]);
    }

    public function editDadosPessoais($id_usuario)
    {
        $user = User::find($id_usuario);
        $user->celular = Helper::mascaraCelular($user->celular);
        $user->documento = Helper::mascaraCPF($user->documento);

        return view('cadastro.form_dados_pessoais', ['user' => $user]);
    }

    public function verificarCelular($id_usuario)
    {
        $user = User::find($id_usuario);

        return view('cadastro.verificar_celular', ['id_usuario' => $id_usuario, 'celular' => Helper::mascaraCelular($user->celular)]);
    }

    public function reenviarSMS(Request $request)
    {
        $user = User::find($request->usuario);
        $user->codigo_validacao = Helper::generateRandomNumberString(5);
        $user->save();

        Helper::sendSms($user->celular, "Bem vindo a plataforma Inclua, o seu código de verificação é: $user->codigo_validacao");
        $response = true;

        return response()->json($response);
    }

    public function validarCelular(Request $request)
    {
        $rules = [
            "codigo" => "required",
        ];
        $feedbacks = [
            "codigo.required" => "O campo Código é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            $user = User::find($request->id_usuario);
            if ($request->codigo == $user->codigo_validacao) {
                $user->celular_validado = "S";
                $user->save();

                $msg = ['valor' => trans("Seu celular foi verificado com sucesso!"), 'tipo' => 'success'];
                session()->flash('msg', $msg);
            } else {
                $msg = ['valor' => trans("O código informado esta incorreto!"), 'tipo' => 'danger'];
                session()->flash('msg', $msg);

                return back();
            }
        } catch(QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('endereco.create', ['id_usuario' => $user->id]);
    }

    public function handleProviderCallback()
    {
        //TENTATIVA DE REALIZAÇÃO DE AUTENTICAÇÃO COM O GOOGLE
        try {
            $providerUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route("index");
        }

        $user = User::updateOrCreate([
            'email' => $providerUser->getEmail()
        ], [
            'name' => $providerUser->getName(),
            'google_id' => $providerUser->getId(),
            'avatar' => $providerUser->getAvatar(),
            'type' => 2,
        ]);

        if ($user && $user->docucumento != null) {
            return redirect()->route('home');
        } else {
            auth()->login($user, true);
            return redirect()->route('home');
            dd('direcionar para continuação do cadastro');
        }

        //ANALIZAR A NECESSIDADE DE MANTER ESTE TRECHO DE CODIGO
        /* if (session()->has('nextview')) {
            return redirect()->to(session('nextview'));
        } else{
            return redirect()->route('home');
        } */
    }

    private function sendEmailCreate($user){
        $msgemail = "Seja Bem Vindo a plataforma Ecomoda, ".$user->name.
            ", esperamos contruibuir com sua jornada positivamente!<br>  acessse:  ". env('URL').
            " <br/>Atenciosamente, Ecomoda. ";
        Helper::sendEmail("Bem vindo a Plataforma Ecomoda",$msgemail,$user->email, $user->name);
    }

    public function redirectToProvider()
    {
        //REDIREDIONANDO PARA O TRATAMENTO DE AUTENTICAÇÃO DO GOOGLE
        return Socialite::driver('google')->redirect();
    }

    public function preEdit($id=null){
        return view('profile/edit');
    }

    public function  update(Request $request){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];

        try{
            $input = $request->validate([
                'name' => 'required|between :5,100',
                'email' => 'required|unique:users,email,'.$request->id,
            ]);

            $usuario = User::find(intval($request->id));
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->nomecompleto = $request->nome_completo;
            $usuario->documento = $request->documento;
            $usuario->nacionalidade = $request->nacionalidade;
            $usuario->telefone = $request->telefone;
            $usuario->celular = $request->celular;


            $usuario->save();
        }catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }


        return view('profile/edit',['msg'=>$msgret]);
    }

    public function  updateCompletar(Request $request){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];

        try{

            if ($request->tipopessoa==="F"){
            $input = $request->validate([
                'nome_completo' => 'required|between :20,100',
                'documento' => 'required|cpf|unique:users,documento,'.$request->id,
                'telefone' => 'required',
                'celular' => 'required',
                'email_alternativo' => 'required',
            ]);
            } else{
                $input = $request->validate([
                    'nome_completo' => 'required|between :20,100',
                    'documento' => 'required|cnpj|unique:users,documento,'.$request->id,
                    'telefone' => 'required',
                    'celular' => 'required',
                    'email_alternativo' => 'required',
                ]);

            }

            $usuario = User::find(intval($request->id));
            $usuario->nomecompleto = $request->nome_completo;
            $usuario->documento = $request->documento;
            $usuario->nacionalidade = $request->nacionalidade;
            $usuario->telefone = $request->telefone;
            $usuario->celular = $request->celular;
            $usuario->email_alternativo = $request->email_alternativo;
            $usuario->instagram = $request->instagram;
            $usuario->facebook = $request->facebook;
            $usuario->twitter = $request->twitter;
            $usuario->sexo = $request->sexo;
            $usuario->tipopessoa= $request->tipopessoa;

            $usuario->save();
        }catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }


        return view('profile/edit',['msg'=>$msgret]);
    }

    public function delete(Request $request){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];

        try{

            $usuario = User::find($request->id);
            $usuario->delete();
            $this->logout($request);

        }catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }
        return view('auth/login',['msg'=>$msgret] );
     }

     public function addEndereco($id=null){
         $endereco = new Endereco();
        if ($id){
            $endereco = Endereco::find($id);
        }
        return view("profile/endereco",['msg'=>null,'obj'=>$endereco]);
     }

    public function delEndereco($id=null){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        try{
            Endereco::find($id)->delete();
        }
        catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }
        $endereco = new Endereco();
        return view("profile/edit",['msg'=>null,'obj'=>$endereco]);
    }

    public function setPrincialEndereco($id=null){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        try{
            $bd = Endereco::find($id);
            DB::table('enderecos')->where('user_id','=',$bd->user_id)->update(['principal'=>false]);
            $bd = Endereco::find($id);
            $bd->principal=True;
            $bd->save();
        }
        catch (QueryException $exp ){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }
        $endereco = new Endereco();
        return view("profile/edit",['msg'=>null,'obj'=>$endereco]);
    }

    public function addEnderecoDo(Request $request){
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        try {
            $endereco = new Endereco();
            if ($request->id_add){
                $endereco = Endereco::find($request->id_add);
            }

            $endereco->recebedor = $request->recebedor;
            $endereco->cep = $request->cep;
            $endereco->estado = $request->estado;
            $endereco->cep = $request->cep;
            $endereco->cidade = $request->cidade;
            $endereco->bairro = $request->bairro;
            $endereco->rua = $request->rua;
            $endereco->numero = $request->numero;
            $endereco->complemento = $request->complemento;
            $endereco->informacoes = $request->informacoes;
            if ($request->principal){
            $endereco->principal = $request->principal;
            }else{
                $endereco->principal=false;
            }


            $endereco->user_id= $request->id;
            $endereco->save();

        }catch (QueryException $exception){
            $msgret = ['valor'=>"Erro ao executar a operação",'tipo'=>'danger'];
        }

        return view("profile/edit",['msg'=>$msgret,'obj'=>$endereco]);
    }

    public function turnVendedor(){
        $msgret = ['valor' => "Operação realizada com sucesso!", 'tipo' => 'success'];
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->tipouser = "V";
        $user->save();
        Auth::user()->tipouser= "V";
        session(['msg' => $msgret]);
        return back();
    }


    public function comentariosComprador(){
        $id = Auth::user()->id;
        $comentarios = Comentarios::join('anuncios','anuncios.id','=','comentarios.anuncio_id')
            -> where('comprador_id',$id)
            ->orderby('comentarios.created_at','desc')
            ->select(DB::raw('comentarios.*'),DB::raw('anuncios.id_anuncio as anc'))
            ->get();
        return view('profile/perguntas',['comentarios'=>$comentarios]);
    }

    public function compras(){
        $id = Auth::user()->id;
        $comentarios = Vendas::where('comprador_id',$id)
            ->orderby('created_at','desc')
            ->select(DB::raw('vendas.*'))
            ->get();
        return view('profile/compras',['compras'=>$comentarios]);
    }
    public function listFavoritos(){
        $id = Auth::user()->id;
        $fav = Favoritos::join('anuncios','anuncios.id','=','anuncio_id')->where('comprador_id',$id)
            ->orderby('favoritos.created_at','desc')
            ->select(DB::raw('*'))
            ->get();
        return view('profile/favoritos',['fav'=>$fav]);

    }


    public function listNotificacoes($msg = null){
        $id = Auth::user()->id;
        $fav = Notificacoes::join('anuncios','notificacoes.id_anuncio','=','anuncios.id')
            ->where('id_user','=',$id)->select(['notificacoes.descricao','anuncios.id_anuncio as anc','notificacoes.id'
                ,'anuncios.id as id_anuncio','notificacoes.created_at','notificacoes.data_leitura'])
            ->orderBy('created_at','desc')
            ->get();
        return view('profile/notificacoes',['comentarios'=>$fav, 'msg'=>$msg]);

    }
    public function lerNotificacoes($id){
        $not = Notificacoes::find($id);
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i');
        $not->data_leitura = $date;
        $not->save();
        $msgret = ['valor'=>"Operação realizada com sucesso!",'tipo'=>'success'];
        return $this->listNotificacoes($msgret);

    }





}
