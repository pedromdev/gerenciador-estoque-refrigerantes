<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
|
| Rotas da api para autenticação do usuário
|
*/

Route::group([ 'prefix' => 'autenticacao' ], function ($router) {

    Route::post('/entrar', 'AutenticacaoController@entrar');

    Route::group([ 'middleware' => 'auth:api' ], function ($router) {

        Route::post('/atualizar', 'AutenticacaoController@atualizar');
        Route::post('/sair', 'AutenticacaoController@sair');

    });

});