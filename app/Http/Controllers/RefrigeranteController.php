<?php

namespace App\Http\Controllers;

use App\Exceptions\RefrigeranteRegistradoException;
use App\Http\Controllers\Utils\DadosRequisicao;
use App\Http\Controllers\Utils\ErrosValidacao;
use App\Http\Controllers\Utils\ManipularModel;
use App\Marca;
use App\Refrigerante;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefrigeranteController extends Controller
{

    use ErrosValidacao, DadosRequisicao, ManipularModel;

    /**
     * @var array
     */
    private $messages = [
        'marca_id.required' => 'O campo marca é obrigatório.',
        'marca_id.exists' => 'A marca informada não existe',
        'litragem.required' => 'O campo litragem é obrigatório.',
        'litragem.min' => 'A litragem deve ser maior que 0',
        'litragem.max' => 'A litragem deve ser menor ou igual a 5 L',
        'tipo.required' => 'O campo tipo é obrigatório.',
        'tipo.in' => 'O tipo selecionado não existe',
        'quantidade.min' => 'O campo quantidade deve ser pelo menos 0',
        'valor_unitario.required' => 'O campo valor unitário é obrigatório.',
        'valor_unitario.min' => 'O valor unitário deve ser pelo menos 0.',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matrizRefrigerantes = [];
        $user = auth()->user();

        foreach ($user->marcas as $marca) {
            $matrizRefrigerantes[] = $marca->refrigerantes;
        }

        $refrigerantes = array_reduce($matrizRefrigerantes, function($array, $refrigerantes) {
            return array_merge($array, $refrigerantes->toArray());
        }, []);
        return response()->json($refrigerantes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'marca_id' => 'required|exists:marcas,id',
            'litragem' => 'required|min:0|max:5',
            'tipo' => 'required|in:Pet,Garrafa,Lata',
            'quantidade' => 'min:0',
            'valor_unitario' => 'required|min:0',
        ], $this->messages);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        try {
            $refrigerante = Refrigerante::adicionar(
                request(['litragem', 'tipo', 'quantidade', 'valor_unitario']),
                Marca::find($request->post('marca_id'))
            );
            return response()->json($refrigerante, 201);
        } catch (RefrigeranteRegistradoException $e) {
            $validador->errors()->add('litragem', 'Refrigerante já cadastrado');
            return $this->retornarErrosDoValidador($validador);
        } catch (\Exception $exception) {
            return response()->json(
                [ 'mensagem' => 'Ocorreu um erro ao cadastrar o refrigerante no estoque' ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Refrigerante  $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function show(Refrigerante $refrigerante)
    {
        $resposta = $this->verificarRefrigerante($refrigerante);

        if ($resposta) return $resposta;

        return response()->json($refrigerante);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Refrigerante  $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Refrigerante $refrigerante)
    {
        $user = auth()->user();
        $mensagemErro = 'Ocorreu um erro ao atualizar os dados do refrigerante';
        $validador = Validator::make($request->all(), [
            'marca_id' => "exists:marcas,id,user_id,{$user->id}",
            'litragem' => 'min:0|max:5',
            'tipo' => 'in:Pet,Garrafa,Lata',
            'quantidade' => 'min:0',
            'valor_unitario' => 'min:0',
        ], $this->messages);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        $refrigeranteExistente = $this->pegarRefrigeranteExistente(
            $user,
            $request->post('litragem'),
            $request->get('marca_id')
        );

        if ($refrigeranteExistente && $refrigeranteExistente->id !== $refrigerante->id) {
            $validador->errors()->add('litragem', 'Refrigerante já cadastrado');
            return $this->retornarErrosDoValidador($validador);
        }
        $dados = $this->removerValoresVazios(request(['marca_id', 'litragem', 'tipo', 'quantidade', 'valor_unitario']));
        $marcaId = $refrigerante->marca->id;
        $resposta = $this->atualizarDados($dados, $refrigerante, $mensagemErro);

        if (isset($dados['marca_id']) && $marcaId !== $dados['marca_id']) {
            $marca = Marca::find($dados['marca_id']);
            $marca->refrigerantes()->save($refrigerante);
        }

        if ($resposta) return $resposta;

        return response()->json($refrigerante);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Refrigerante  $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refrigerante $refrigerante)
    {
        $resposta = $this->verificarRefrigerante($refrigerante);

        if ($resposta) return $resposta;

        try {
            $refrigerante->delete();
        } catch (\Exception $e) {
            return response()->json(
                [ 'mensagem' => 'Ocorreu um erro ao excluir o refrigerante do estoque' ],
                500
            );
        }

        return response()->noContent();
    }

    /**
     * Retorna um refrigerante de mesma litragem e marca, se houver
     *
     * @param User $user
     * @param float $litragem
     * @param int $marcaId
     * @return Refrigerante|null
     */
    public function pegarRefrigeranteExistente(User $user, $litragem, $marcaId)
    {
        $marca = null;

        foreach ($user->marcas as $marcaUsuario) {
            if ($marcaUsuario->id === $marcaId) $marca = $marcaUsuario;
        }

        if (!$marca) return null;

        /** @var Marca $marca */
        foreach ($marca->refrigerantes as $refrigerante) {
            if ($refrigerante->litragem == $litragem) return $refrigerante;
        }

        return null;
    }

    /**
     * Verifica se o refrigerante é do usuário atual
     *
     * @param Refrigerante $refrigerante
     * @return \Illuminate\Http\Response
     */
    public function verificarRefrigerante(Refrigerante $refrigerante)
    {
        $user = auth()->user();

        if ($refrigerante && $refrigerante->marca->user->id !== $user->id) {
            return response()->json([ 'mensagem' => 'Refrigerante não encontrado' ], 404);
        }
    }
}
