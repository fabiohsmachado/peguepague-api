<?php

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // Transaction routes
    $router->post('transaction', 'TransactionController@store');
    $router->get('transactions', 'TransactionController@index');

    // User routes
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->post('users', 'UserController@store');
});