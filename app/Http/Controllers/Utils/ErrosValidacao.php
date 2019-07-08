<?php


namespace App\Http\Controllers\Utils;


use Illuminate\Contracts\Validation\Validator;

trait ErrosValidacao
{

    /**
     * @param Validator $validator
     * @param int $status
     * @return \Illuminate\Http\Response
     */
    public function retornarErrosDoValidador(Validator $validator, $status = 422)
    {
        return response()->json($validator->errors()->toArray(), $status);
    }
}