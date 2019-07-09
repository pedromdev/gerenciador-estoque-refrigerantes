<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\DadosRequisicao;
use App\Http\Controllers\Utils\ErrosValidacao;
use App\Http\Controllers\Utils\ManipularModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{

    use ErrosValidacao, DadosRequisicao, ManipularModel;

    /**
     * @var array
     */
    private $messages = [
        'name.required' => 'O campo nome é obrigatório.',
        'name.max' => 'O campo nome não pode ter mais do que 255 caracteres.',
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
        'email.unique' => 'Este e-mail já está em uso.',
        'password.required' => 'O campo senha é obrigatório.',
        'password.confirmed' => 'As senhas não são iguais.',
        'password.min' => 'O campo senha deve ter pelo menos 6 caracteres.',
        'password_confirmation.required' => 'O campo confirmar senha é obrigatório.',
        'password_confirmation.min' => 'O campo confirmar senha deve ter pelo menos 6 caracteres.',
    ];

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ], $this->messages);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        try {
            User::adicionar(request(['name', 'email', 'password']));
        } catch (\Exception $exception) {
            return response()->json([ 'mensagem' => 'Ocorreu um erro ao adicionar o usuário no sistema' ], 500);
        }

        /** @var AutenticacaoController $autenticacaoController */
        $autenticacaoController = app(AutenticacaoController::class);
        return $autenticacaoController->entrar()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $mensagemErro = 'Ocorreu um erro ao atualizar os dados do usuário';
        $validador = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => "email|unique:users,email,$user->id",
            'password' => 'confirmed|min:6',
            'password_confirmation' => 'min:6',
        ], $this->messages);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        $dados = $this->removerValoresVazios(request(['name', 'email', 'password']));
        $resposta = $this->atualizarDados($dados, $user, $mensagemErro);

        if ($resposta) return $resposta;

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function destroy()
    {
        auth()->user()->delete();
        return response()->noContent();
    }
}
