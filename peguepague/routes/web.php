<?php

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->post('users', 'UserController@store');
    $router->delete('users/{id}', 'UserController@destroy');
});