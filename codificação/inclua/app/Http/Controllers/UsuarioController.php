<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Clinica;
use App\Models\Comentarios;
use App\Models\Endereco;
use App\Models\Especialista;
use App\Models\Favoritos;
use App\Models\Notificacoes;
use App\Models\Paciente;
use App\Models\PasswordResets;
use App\Models\User;
use App\Models\Vendas;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function logar(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $dados = ['email' => $request->email, 'password' => $request->password];
        if (Auth::validate($dados)) {
            //VERIFICA SE O CADASTRO FOI FINALIZADO
            $usuario = User::where('email', $request->email)->first();
            if ($usuario) {
                return $this->verifyCadastro($usuario->id);
            }

            Auth::loginUsingId($usuario->id);
            $request->session()->regenerate();
            
            if (session()->has('nextview')) {
                return redirect(session('nextview'));
            }            

            return redirect()->route('home');
        } else {
            session()->flash('msg', ['valor' => trans("Usuário/Senha inválido"), 'tipo' => 'danger']);
            
            return redirect()->route('index');
        }
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
        //QUANDO O USUARIO INSERIR UM E-MAIL JÁ CADASTRADO
        if ($request->usuario_id == null) {
            $user = User::where('email', $request->email)->first();
            
            if ($user) {
                return $this->verifyCadastro($user->id);
            }
        }

        $rules = [
            "email" => "required|unique:users,email,{$request->usuario_id}",
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
        $feedbacks = [
            "email.required" => "O campo Email é obrigatório.",
            "email.unique" => "O email utilizado já foi cadastrado.",
            "password.required" => "O campo Senha é obrigatório.",
            "password.confirmed" => "As senhas não são correspondentes.",
            "password.min" => "O campo senha deve ter no mínimo 8 caracteres.",
            "password_confirmation.required" => "O campo Confirmar a senha é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            if($request->usuario_id) {
                $user = User::find($request->usuario_id );
            } else {
                $user = new User();
            }
            $user->email = $request->email;
            $user->nome_completo = $request->nome ?? null;
            $user->password = bcrypt($request->password);
            $user->codigo_validacao = Helper::generateRandomNumberString(5);
            $user->tipo_pessoa = $request->tipo_pessoa;
            $user->tipo_user = $request->tipo_user;
            $user->save();
            //ENVIAR O EMAIL COM CÓDIGO DE CONFIRMAÇÃO
            //Mail::to($user->email)->send(new verificarEmail($user->codigo_validacao));
            Helper::sendEmail("Validação de Código", "Seu Código de Verificação é: ".$user->codigo_validacao, $user->email);

            $msg = ['valor' => trans("Cadastro do usuário realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('view.verificar_email', ['usuario_id' => $user->id]);
    }

    public function editUser($usuario_id)
    {
        $user = User::find($usuario_id);
        return view('cadastro.form_usuario', ['user' => $user]);
    }

    public function storeDados(Request $request)
    {
        try {
            //salvando a avatar do usuario
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUM AVATAR JA CADASTRADO PARA DELETAR
                $avatar = User::find($request->usuario_id)->avatar;
                if(!empty($avatar)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $avatar);
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

            $user = User::find($request->usuario_id);
            $user->avatar = !empty($pathAvatar) ? "storage/$pathAvatar" : null;
            $user->documento = Helper::removerCaractereEspecial($request->documento)  ?? null;
            $user->nome_completo = $request->nome ?? $user->nome_completo;
            $user->telefone = Helper::removerCaractereEspecial($request->telefone) ?? null;
            $user->celular = Helper::removerCaractereEspecial($request->celular) ?? null;
            $user->codigo_validacao = Helper::generateRandomNumberString(5);
            $user->rg = $request->rg ?? null;
            $user->data_nascimento = $request->data_nascimento ?? null;
            $user->estado_civil = $request->estado_civil ?? null;
            $user->sexo = $request->sexo ?? null;
            $user->consentimento = $request->consentimento ?? null;
            $user->save();

            Helper::sendSms($user->celular, "Bem vindo a plataforma Inclua, o seu código de verificação é: $user->codigo_validacao");

            $msg = ['valor' => trans("Cadastro de dados realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            dd($e);
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }

        return $user;
    }

    public function handleProviderCallback()
    {
        //TENTATIVA DE REALIZAÇÃO DE AUTENTICAÇÃO COM O GOOGLE
        try {
            $providerUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            $msg = ['valor' => trans("Não foi possível realizar a autenticação com Google. Realize seu cadastro em Criar um conta."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return redirect()->route("index");
        }

        $user = User::firstOrCreate([
            'email' => $providerUser->getEmail()
        ], [
            'name' => $providerUser->getName(),
            'google_id' => $providerUser->getId(),
            'avatar' => $providerUser->getAvatar(),
            'etapa_cadastro' => "1"
        ]);
        
        $user_id = $user->id;
        $this->logout(request());

        if ($user && $user->docucumento != null) {
            return redirect()->route('home');
        } else {
            return $this->verifyCadastro($user_id);
        }
    }

    public function redirectToProvider()
    {
        //REDIREDIONANDO PARA O TRATAMENTO DE AUTENTICAÇÃO DO GOOGLE
        return Socialite::driver('google')->redirect();
    }

    public function verifyCadastro($usuario_id)
    {
        $user = User::find($usuario_id);
        if ($user->etapa_cadastro == "1") {
            session()->flash('msg', ['valor' => trans("Autenticação com Google realizada com sucesso, prossiga com o seu cadastro."), 'tipo' => 'success']);

            return redirect()->route('usuario.edit', ['usuario_id' => $user->id]);
        } else if ($user->etapa_cadastro == '2') {
            session()->flash('msg', ['valor' => trans("Já existe um cadastro realizado com o e-mail utilizado, prossiga com o seu cadastro."), 'tipo' => 'success']);
            
            if ($user->tipo_user == "P") {
                return redirect()->route('usuario.paciente.dados.edit', ['usuario_id' => $user->id]);
            } elseif ($user->tipo_user == "E") {
                return redirect()->route('usuario.especialista.dados.edit', ['usuario_id' => $user->id]);
            } elseif ($user->tipo_user == "C") {
                return redirect()->route('usuario.clinica.dados.create', ['usuario_id' => $user->id]);
            }
        } else if ($user->etapa_cadastro == '3') {
            session()->flash('msg', ['valor' => trans("Já existe um cadastro realizado com o e-mail utilizado, prossiga com o seu cadastro."), 'tipo' => 'success']);
            
            if ($user->tipo_user == "P") {
                return redirect()->route('usuario.clinica.dados.create', ['usuario_id' => $user->id]);
            } elseif ($user->tipo_user == "E") {
                return redirect()->route('dados-bancarios.create', ['usuario_id' => $user->id]);
            } elseif ($user->tipo_user == "C") {
                return redirect()->route('clinica.endereco.create', ['usuario_id' => $user->id]);
            }
        } else if ($user->etapa_cadastro == '4') {
            session()->flash('msg', ['valor' => trans("Já existe um cadastro realizado com o e-mail utilizado, prossiga com o seu cadastro."), 'tipo' => 'success']);
            
            return redirect()->route('cartao.create', ['usuario_id' => $user->id]);
        } else if ($user->etapa_cadastro == 'F') {
            session()->flash('msg', ['valor' => trans("Seu cadastro foi finalizado com sucesso. Bem vindo a Plataforma Inclua!"), 'tipo' => 'success']);
            auth()->login($user, true);

            return redirect()->route('home');
        } else if ($user->tipo_user == 'R') {
            session()->flash('msg', ['valor' => trans("Bem vindo a Plataforma Inclua!"), 'tipo' => 'success']);
            auth()->login($user, true);

            return redirect()->route('home');
        } else {
            session()->flash('msg', ['valor' => trans("Realize o seu cadastro"), 'tipo' => 'danger']);
            
            return redirect()->route('index');
        }
    }

    public function perfil($id=null)
    {
        return view('profile/edit');
    }

    public function updateUser(Request $request)
    {
        $rules = [
            "nome" => "required|min:5",
            "email" => "required|unique:users,email,{$request->usuario_id}"
        ];
        $feedbacks = [
            "nome.required" => "O campo Nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
            "email.required" => "O campo Email é obrigatório.",
            "email.unique" => "O email utilizado já foi cadastrado.",
        ];
        $request->validate($rules, $feedbacks);
        
        try {
            $usuario = User::find($request->usuario_id);
            $usuario->nome_completo = $request->nome;
            $usuario->email = $request->email;
            $usuario->save();
            
            if ($usuario->tipo_user == "P") {
                $paciente = Paciente::where('usuario_id', $usuario->id)->first();
                $paciente->nome = $request->nome;
                $paciente->save();
            } elseif ($usuario->tipo_user == "E") {
                $especialista = Especialista::where('usuario_id', $usuario->id)->first();
                $especialista->nome = $request->nome;
                $especialista->save();
            } elseif ($usuario->tipo_user == "C") {
                $clinica = Clinica::where('usuario_id', $usuario->id)->first();
                $clinica->nome = $request->nome;
                $clinica->save();
            }
            
            session()->flash('msg', ['valor' => "Operação realizada com sucesso!", 'tipo' => 'success']);
        } catch (QueryException $exp) {
            session()->flash('msg', ['valor' => "Erro ao executar a operação", 'tipo' => 'danger']);
        }

        return back();
    }

    public function  updateDadosUser(Request $request)
    {
        if ($request->tipo_pessoa === "F") {
            $rules = [
                "tipo_pessoa" => "required",
                "documento" => "required|unique:users,documento,{$request->usuario_id}",
                "telefone" => "unique:users,telefone,{$request->usuario_id}",
                "celular" => "required|unique:users,celular,{$request->usuario_id}",
                "sexo" => "required"
            ];
        } else {
            $rules = [
                "tipo_pessoa" => "required",
                "documento" => "required|unique:users,documento,{$request->usuario_id}",
                "telefone" => "unique:users,telefone,{$request->usuario_id}",
                "celular" => "required|unique:users,celular,{$request->usuario_id}",
            ];
        }
        $feedbacks = [
            "tipo_pessoa.required" => "O campo Tipo Pessoa é obrigatório.",
            "documento.required" => "O campo CPF é obrigatório.",
            "documento.unique" => "Este CPF já foi utilizado.",
            "telefone.unique" => "Este número de telefone já foi utilizado.",
            "celular.required" => "O campo Celular é obrigatório.",
            "celular.unique" => "Este número de celular já foi utilizado.",
            "sexo.required" => "O campo Gênero é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            $usuario = User::find($request->usuario_id);
            $usuario->tipo_pessoa = $request->tipo_pessoa;
            $usuario->documento = $request->documento;
            $usuario->telefone = $request->telefone;
            $usuario->celular = $request->celular;
            $usuario->sexo = $request->sexo;
            $usuario->save();
            
            session()->flash('msg', ['valor' => "Operação realizada com sucesso!", 'tipo' => 'success']);
        } catch (QueryException $exp) {
            session()->flash('msg', ['valor' => "Erro ao executar a operação", 'tipo' => 'danger']);
        }

        return back();
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
    
    public function updateAvatar(Request $request)
    {
        try {
            //salvando a avatar do usuario
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUM AVATAR JA CADASTRADO PARA DELETAR
                $avatar = User::find($request->usuario_id)->avatar;
                if(!empty($avatar)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $avatar);
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
            
            $user = User::find($request->usuario_id);
            $user->avatar = !empty($pathAvatar) ? "storage/$pathAvatar" : null;
            $user->save();

            $response = true;
        } catch (QueryException $e) {
            $response = false;
        }

        return response()->json($response);
    }

    public function turnVendedor(){
        $msgret = ['valor' => "Operação realizada com sucesso!", 'tipo' => 'success'];
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->tipo_user = "V";
        $user->save();
        Auth::user()->tipo_user= "V";
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
