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
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

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
            'password' => 'confirmed|min:6'
        ]);

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
