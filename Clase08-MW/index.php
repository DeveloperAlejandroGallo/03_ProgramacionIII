<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './Api/vendor/autoload.php';
require_once './Api/classes/cdApi.php';
require_once './Api/classes/AccesoDatos.php';



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

})->add(function($request,$response,$next)
    {
        // $token = $request->getHeaders('token');
        $response->getBody()->write("Antes del Next");
        $next($response,$request);
        $response->getBody()->write("Despues del next");
        
    }

) ;



/*MAS CODIGO AQUI...*/





$app->run();