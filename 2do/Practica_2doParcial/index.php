<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/MWparaCORS.php';
require_once './clases/MWparaAutentificar.php';
require_once './clases/usuarioApi.php';

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
echo 0;

// $app->get('/', function ($request, $response, $args) 
// {
//   echo "Hello, " ;
// });

// /*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
// $app->group('/sp', function () {
//   echo 1;
//   $this->post('/login', \usuarioApi::class . ':login');
//   echo 2;
//   // $this->get('/hello', function ($request, $response, $args) {
//   //   echo "Hello, " ;
// });

   $app->group('', function()
   { 
     $this->post('/usuario', \usuarioApi::class . ':cargarUno');//->add(\MWparaCORS::class . ':HabilitarCORSTodos');
     $this->post('/login', \usuarioApi::class . ':login');
  //  // $this->get('/usuario', \usuarioApi::class . ':traerTodos');
  
  //   // $this->post('/Compra', \compraApi::class . ':ingresarUno');
  
  //   // $this->get('/Compra', \compraApi::class . ':retornarCompras');
  // })->add(\MWparaAutentificar::class . ':VerificarUsuario');//add(\MWparaCORS::class . ':HabilitarCORS8080');

 });



$app->run();