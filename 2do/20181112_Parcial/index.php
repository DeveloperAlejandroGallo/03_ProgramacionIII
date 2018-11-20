<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/MWparaAutentificar.php';
require_once './clases/MWlistarUsuarios.php';
require_once './clases/MWLogger.php';
require_once './clases/usuarioApi.php';
require_once './clases/compraApi.php';

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


$app->group('', function()
{ 
   $this->post('/usuario', \usuarioApi::class . ':altaUsuario')->setname("usuario");#1
   $this->post('/login', \usuarioApi::class . ':crearTokenUsr')->setname("login");;#2
   $this->group('', function()
      {
         $this->get('/usuario', \usuarioApi::class . ':listaDeUsuarios')->add(\MWlistarUsuarios::class . ':listarUsuarios')->setName("usuario");#3
         $this->post('/compra', \compraApi::class . ':altaCompra')->setname("compra");#4#8
         $this->get('/compra', \compraApi::class . ':listarCompras')->setname("compra");#5
         $this->get('/compra/{marca}', \compraApi::class . ':listarModelosMarca')->setname("compra/marca");#6
         $this->get('/productos',\compraApi::class . ':productosVendidos')->setName('productos');
      })->add(\MWParaAutentificar::class . ':ValidarUsuario');
})->add(\MWLogger::class . ':logger');#7



$app->run();