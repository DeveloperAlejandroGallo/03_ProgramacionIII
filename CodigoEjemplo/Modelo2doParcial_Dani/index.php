<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require './vendor/autoload.php';

require_once './AccesoDatos.php';
require_once './usuario.php';
require_once './usuarioApi.php';
require_once './compra.php';
require_once './compraApi.php';
require_once './AutentificadorJWT.php';
require_once './MiddlewareAPI.php';

$nombreTablaUsuarios= "usuario_datos";
$nombreTablaCompras= "compra_datos";

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->group('', function () {//grupo para todos 
    
    $this->post('/usuario', \usuarioApi::class . ':AltaDeUsuario');
    
    $this->post('/login', \usuarioApi::class . ':CrearTokenParaUsuario');

    $this->group('/', function () 
    {//grupo para las que necesitan web token
        $this->get('usuario', \usuarioApi::class . ':ArmaListaUsuarios')->add(\MiddlewareAPI::class . ':VerificarPerfilUsuario');
        $this->post('compra', \compraApi::class . ':RegistrarCompra');
        $this->get('compra', \compraApi::class . ':ArmaListaCompras')->add(\MiddlewareAPI::class . ':VerificarPerfilUsuario');

    })->add(\MiddlewareAPI::class . ':VerificarUsuario');
    

})->add(\MiddlewareAPI::class . ':GuardarUsuarioRuta');//el que guarda en la base las rutas/usuario etc

$app->run();
