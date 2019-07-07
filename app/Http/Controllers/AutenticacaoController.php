<?php

namespace App\Http\Controllers;

class AutenticacaoController extends Controller
{

    /**
     * AutenticacaoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['entrar']]);
    }

    public function entrar()
    {
        $credenciais = request(['email', 'password']);
        $token = auth()->attempt($credenciais);

        if (!$token) return response()->json(['error' => 'Não autorizado'], 401);

        return $this->gerarToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
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
