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

$app = new \Slim\App(["settings" => $config]);

$app->group('/login', function () 
{
    $this->group('',function() 
    {
        $this->get('', \empleadosApi::class . ':traerTodos');
        $this->get('/{nombre}', \empleadosApi::class . ':ingresoPorEmpleado');
        $this->post('/sector', \empleadosApi::class . ':traerLogsPorSector');
        $this->post('/empleado', \empleadosApi::class . ':traerLogsPorEmpleado');
    })->add(\MWparaAutentificar::class . ':VerificarSocios');

    $this->post('', \empleadosApi::class . ':loguearse'); //usuario y password
});


$app->group('/empleados', function () {
    $this->get('', \empleadosApi::class . ':traerTodos');
    $this->post('', \empleadosApi::class . ':CargarUno');//recibe codigo
    $this->post('/del', \empleadosApi::class . ':BorrarUno');
    $this->post('/mod', \empleadosApi::class . ':ModificarUno');
})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->group('/mesas', function () 
{
    $this->get('', \mesasApi::class . ':traerTodos');
    $this->get('/{id}', \mesasApi::class . ':traerUno');
    $this->post('', \mesasApi::class . ':CargarUno');
    $this->post('/del', \mesasApi::class . ':BorrarUno');//recibe el codigo
    $this->post('/mod', \mesasApi::class . ':ModificarUno');//recibe el codigo

})->add(\MWparaAutentificar::class . ':VerificarMozos');


$app->group('/pedidos', function () 
{
    $this->get('', \pedidosApi::class . ':traerTodos');
    $this->post('', \pedidosApi::class . ':CargarUno');
    $this->post('/del', \pedidosApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarMozos');
    $this->post('/mod', \pedidosApi::class . ':ModificarUno');
    $this->post('/atender', \pedidosApi::class . ':atenderPedido');  
    $this->post('/facturado', \pedidosApi::class . ':facturadoEntreFechas');
})->add(\MWparaAutentificar::class . ':VerificarUsuario');


$app->group('/carta', function () 
{
    $this->get('', \cartaApi::class . ':traerTodos');
    $this->post('', \cartaApi::class . ':CargarUno');
    $this->post('/del', \cartaApi::class . ':BorrarUno');
    $this->post('/mod', \cartaApi::class . ':ModificarUno');

})->add(\MWparaAutentificar::class . ':VerificarSocios');

$app->group('/caja', function () 
{
    $this->get('', \cajaApi::class . ':traerTodos');
    $this->post('', \cajaApi::class . ':CargarUno');


})->add(\MWparaAutentificar::class . ':VerificarSocios');


$app->group('/cliente', function () 
{
    $this->get('', \cartaApi::class . ':traerTodos');
    $this->post('/tiempo', \pedidosApi::class . ':tiempoPedido');
    $this->post('/encuesta', \encuestaApi::class . ':CargarUno');
});

$app->group('/encuesta', function () 
{
  $this->get('', \encuestaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarSocios');
});


$app->run();

?>