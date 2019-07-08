<?php


namespace App\Http\Controllers\Utils;


trait DadosRequisicao
{

    /**
     * Remove valores vazios do array
     *
     * @param $dados
     * @return array
     */
    public function removerValoresVazios($dados)
    {
        $dados = array_filter($dados, function ($value) {
            return (bool) $value || is_numeric($value);
        });
        return $dados;
    }
}