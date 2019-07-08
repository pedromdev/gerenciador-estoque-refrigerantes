<?php


namespace App\Http\Controllers\Utils;


use Illuminate\Database\Eloquent\Model;

trait ManipularModel
{

    /**
     * Atualiza os dados de um model e retorna um erro caso não tenha atualizar
     *
     * @param array $dados
     * @param Model $model
     * @param string $mensagemErro
     * @return \Illuminate\Http\Response
     */
    public function atualizarDados(array $dados, Model $model, $mensagemErro)
    {
        if (!empty($dados)) {
            foreach ($dados as $prop => $valor) {
                $model->{$prop} = $valor;
            }

            try {
                $model->save();
            } catch (\Exception $exception) {
                return response()->json([ 'mensagem' => $mensagemErro ],500);
            }
        }
    }
}