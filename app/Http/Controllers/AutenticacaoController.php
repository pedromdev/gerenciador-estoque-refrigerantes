<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\ErrosValidacao;
use Illuminate\Support\Facades\Validator;

class AutenticacaoController extends Controller
{

    use ErrosValidacao;

    /**
     * AutenticacaoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['entrar']]);
    }

    public function entrar()
    {
        $validador = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.'
        ]);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        $credenciais = request(['email', 'password']);
        $token = auth()->attempt($credenciais);

        if (!$token) return response()->json(['error' => 'Não autorizado'], 401);

        return $this->gerarToken($token);
    }

    public function atualizar()
    {
        return $this->gerarToken(auth()->refresh());
    }

    public function sair()
    {
        auth()->logout();

        return response()->noContent();
    }

    protected function gerarToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
