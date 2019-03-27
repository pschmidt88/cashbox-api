<?php
/**
 * @var $router \Laravel\Lumen\Routing\Router
 */

$router->put('player/{id}', 'PlayerController@createPlayer');
$router->get('player/{id}', 'PlayerController@findById');
$router->post('player/{id}/fines', 'PlayerController@addFine');
