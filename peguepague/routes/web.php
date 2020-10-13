<?php

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // Transaction routes
    $router->get('transactions', 'TransactionController@index');
    $router->post('transaction', 'TransactionController@store');

    // User routes
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->post('users', 'UserController@store');
    $router->delete('users/{id}', 'UserController@destroy');
});