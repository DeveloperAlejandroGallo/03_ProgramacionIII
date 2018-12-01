<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'clases/accesoDatos.php';
require_once 'clases/empleadosApi.php';
require_once 'clases/mesasApi.php';
require_once 'clases/pedidosApi.php';
require_once 'clases/cartaApi.php';
require_once 'clases/cajaApi.php';
require_once 'clases/encuestaApi.php';
require_once 'clases/MWparaAutentificar.php';


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

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/empleados', function () {
 
  $this->get('/', \empleadosApi::class . ':TraerTodos');//':traerLogs');

  $this->post('/', \empleadosApi::class . ':CargarUno');

  $this->delete('/', \empleadosApi::class . ':BorrarUno');

  $this->put('/', \empleadosApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarSocios');


$app->group('/login', function () {

  $this->get('/', \empleadosApi::class . ':traerLogs')->add(\MWparaAutentificar::class . ':VerificarSocios');

  $this->get('/{id}', \empleadosApi::class . ':traerUnLog')->add(\MWparaAutentificar::class . ':VerificarSocios');

  $this->post('/porsector', \empleadosApi::class . ':traerLogsPorSector')->add(\MWparaAutentificar::class . ':VerificarSocios');

  $this->post('/porempleado', \empleadosApi::class . ':traerLogsPorEmpleado')->add(\MWparaAutentificar::class . ':VerificarSocios');
 
  $this->post('/', \empleadosApi::class . ':verificar');
      
});


$app->group('/mesas', function () {
 
  $this->get('/', \mesasApi::class . ':traerTodos');
 
  $this->get('/{id}', \mesasApi::class . ':traerUno');

  $this->post('/', \mesasApi::class . ':CargarUno');

  $this->delete('/', \mesasApi::class . ':BorrarUno');

  $this->put('/', \mesasApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarMozos');


$app->group('/pedidos', function () {
 
  $this->get('/', \pedidosApi::class . ':traerTodos');
 
  $this->post('/', \pedidosApi::class . ':CargarUno');

  $this->delete('/', \pedidosApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarMozos');

  $this->put('/', \pedidosApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario');


$app->group('/carta', function () {
 
  $this->get('/', \cartaApi::class . ':traerTodos');
 
  $this->post('/', \cartaApi::class . ':CargarUno');

  $this->delete('/', \cartaApi::class . ':BorrarUno');

  $this->put('/', \cartaApi::class . ':ModificarUno');

       
})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->group('/caja', function () {
 
  $this->get('/', \cajaApi::class . ':traerTodos');

  $this->post('/', \cajaApi::class . ':CargarUno');
  
  })->add(\MWparaAutentificar::class . ':VerificarSocios');


$app->group('/cliente', function () {
 
$this->get('/', \cartaApi::class . ':traerTodos');

$this->post('/tiempo', \pedidosApi::class . ':tiempoPedido');

$this->post('/encuesta', \encuestaApi::class . ':CargarUno');

});

$app->group('/encuesta', function () {

  $this->get('/', \encuestaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarSocios');
 
  
  
 
  
  });


$app->run();

?>