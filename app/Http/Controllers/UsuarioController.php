<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{

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
            'password' => 'required|confirmed|min:6'
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors()->toArray(), 422);
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
        $validador = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => "email|unique:users,email,$user->id",
            'password' => 'confirmed|min:6'
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors()->toArray(), 422);
        }

        $dados = $this->removerValoresVazios(request(['name', 'email', 'password']));

        if (!empty($dados)) {
            foreach ($dados as $prop => $valor) {
                $user->{$prop} = $valor;
            }

            try {
                $user->save();
            } catch (\Exception $exception) {
                return response()->json([ 'mensagem' => 'Ocorreu um erro ao atualizar os dados do usuário' ], 500);
            }
        }

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

    /**
     * Remove valores vazios do array
     *
     * @param $dados
     * @return array
     */
    private function removerValoresVazios($dados)
    {
        $dados = array_filter($dados, function ($value) {
            return (bool) $value;
        });
        return $dados;
    }
}
