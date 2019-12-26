<?php

Auth::routes();
Route::get('/', 'AdministradorController@index');


Route::get('/teste', function () {
    return view('home');
});

Route::group(['prefix' => 'admin'], function () {

    // Rota principal do administrador
    Route::get('/', 'AdministradorController@index')->name('admin');
    //Rotas de cadastro
    Route::group(['prefix' => 'cadastrar'], function () {

        Route::get('funcionario', 'FuncionarioController@create')->name('funcionario.create');
        Route::post('funcionario', 'FuncionarioController@store')->name('funcionario.store');

        Route::get('fluxo', 'FluxoDiarioController@create')->name('fluxo.create');
        Route::post('fluxo', 'FluxoDiarioController@store')->name('fluxo.store');

        Route::get('conta', 'ContaController@create')->name('conta.create');
        Route::post('conta', 'ContaController@store')->name('conta.store');

        Route::get('folga', 'FolgaController@create')->name('folga.create');
        Route::post('folga', 'FolgaController@store')->name('folga.store');

        Route::get('cheque', 'ChequeController@create')->name('cheque.create');
        Route::post('cheque', 'ChequeController@store')->name('cheque.store');

        Route::get('boleto', 'BoletoController@create')->name('boleto.create');
        Route::post('boleto', 'BoletoController@store')->name('boleto.store');

        Route::get('movimentacao', 'MovimentacaoBancariaController@create')->name('movimentacao.create');
        Route::post('movimentacao', 'MovimentacaoBancariaController@store')->name('movimentacao.store');
    });

    // Rotas de controle
    Route::group(['prefix' => 'controle'], function () {

        Route::get('folga', 'FolgaController@show')->name('folga.show');

        Route::get('funcionario', 'FuncionarioController@show')->name('funcionario.show');

        Route::get('boleto', 'BoletoController@show')->name('boleto.show');

        Route::get('cheque', 'ChequeController@show')->name('cheque.show');

        Route::get('conta', 'ContaController@show')->name('conta.show');

        Route::get('fluxo', 'FluxoDiarioController@show')->name('fluxo.show');

        Route::get('movimentacao', 'MovimentacaoBancariaController@show')->name('movimentacao.show');
    });

    // Rotas de Edição
    Route::group(['prefix' => 'editar'], function () {

        Route::get('/', 'AdministradorController@edit')->name('admin.edit');
        Route::post('/', 'AdministradorController@update')->name('admin.update');

        Route::get('funcionario/{id}', 'FuncionarioController@edit')->name('funcionario.edit');
        Route::post('funcionario', 'FuncionarioController@update')->name('funcionario.update');

        Route::get('folga/{id}', 'FolgaController@edit')->name('folga.edit');
        Route::post('folga', 'FolgaController@update')->name('folga.update');

        Route::get('fluxo/{id}', 'FluxoDiarioController@edit')->name('fluxo.edit');
        Route::post('fluxo', 'FluxoDiarioController@update')->name('fluxo.update');

        Route::get('conta/{id}', 'ContaController@edit')->name('conta.edit');
        Route::post('conta', 'ContaController@update')->name('conta.update');

        Route::get('cheque/{id}', 'ChequeController@edit')->name('cheque.edit');
        Route::post('cheque', 'ChequeController@update')->name('cheque.update');

        Route::get('boleto/{id}', 'BoletoController@edit')->name('boleto.edit');
        Route::post('boleto', 'BoletoController@update')->name('boleto.update');
    });

    // Rotas de Exclusão
    Route::group(['prefix' => 'deletar'], function () {

        Route::get('funcionario/{id}', 'FuncionarioController@delete')->name('funcionario.delete');
        Route::get('folga/{id}', 'FolgaController@delete')->name('folga.delete');
        Route::get('fluxo/{id}', 'FluxoDiarioController@delete')->name('fluxo.delete');
        Route::get('conta/{id}', 'ContaController@delete')->name('conta.delete');
        Route::get('cheque/{id}', 'ChequeController@delete')->name('cheque.delete');
        Route::get('boleto/{id}', 'BoletoController@delete')->name('boleto.delete');
    });

});





