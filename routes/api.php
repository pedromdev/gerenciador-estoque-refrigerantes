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

Route::group([ 'prefix' => 'autenticacao' ], function () {

    Route::post('/entrar', 'AutenticacaoController@entrar');

    Route::group([ 'middleware' => 'auth:api' ], function () {

        Route::post('/atualizar', 'AutenticacaoController@atualizar');
        Route::post('/sair', 'AutenticacaoController@sair');

    });

});

/*
|--------------------------------------------------------------------------
| Usuários
|--------------------------------------------------------------------------
|
| Rotas da api para leitura e manipulação dos dados dos usuários
|
*/

Route::group([ 'prefix' => 'usuarios' ], function () {

    Route::post('', 'UsuarioController@store');

    Route::group([ 'prefix' => 'me', 'middleware' => 'auth:api' ], function () {

        Route::get('', 'UsuarioController@show');
        Route::patch('', 'UsuarioController@update');
        Route::delete('', 'UsuarioController@destroy');

    });
});

/*
|--------------------------------------------------------------------------
| Marcas
|--------------------------------------------------------------------------
|
| Rotas da api para leitura e manipulação dos dados das marcas de refrigerante
|
*/

Route::group([ 'middleware' => 'auth:api' ], function ($router) {

    $router->apiResources([
        'marcas' => 'MarcaController',
        'refrigerantes' => 'RefrigeranteController',
    ]);

});