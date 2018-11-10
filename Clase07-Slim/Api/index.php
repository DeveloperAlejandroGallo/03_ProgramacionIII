<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './classes/cdApi';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

/*
COMPLETAR POST, PUT Y DELETE
*/


$app->get('/saludar[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Hola mundo SlimFramework!!!");
    return $response;

});

/*MAS CODIGO AQUI...*/

#Grupos
$app->group('/cd',function()
{
    $this->get('[/]', \cdApi::class . ':GetAll');
    $this->get('/{id}', \cdApi::class . ':GetOne');
    $this->post('[/]', \cdApi::class . ':PutOne');
    $this->delete('[/]', \cdApi::class . ':DeleteOne');
    $this->put('[/]', \cdApi::class . ':ModifyOne');
});




$app->run();