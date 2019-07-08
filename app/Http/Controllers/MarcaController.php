<?php

namespace App\Http\Controllers;

use App\Exceptions\MarcaRegistradaException;
use App\Http\Controllers\Utils\ErrosValidacao;
use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{

    use ErrosValidacao;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(auth()->user()->marcas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [ 'nome' => 'required|max:30' ]);

        if ($validador->fails()) {
            return $this->retornarErrosDoValidador($validador);
        }

        try {
            $marca = Marca::adicionar($request->post('nome'), auth()->user());
            return response()->json($marca, 201);
        } catch (MarcaRegistradaException $e) {
            $validador
                ->errors()
                ->add('nome', 'Marca já registrada');
            return $this->retornarErrosDoValidador($validador);
        } catch (\Exception $e2) {
            return response()->json(
                [ 'mensagem' => 'Ocorreu um erro ao tentar cadastrar a marca do refrigerante' ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
