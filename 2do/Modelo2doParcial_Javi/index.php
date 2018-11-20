<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';
// Mis middleware
require_once './clases/MWdeJWT.php';
require_once './clases/MWdelPuntoTres.php';
require_once './clases/MWdeLOG.php';
// Mis clases entidad
require_once './clases/Usuario.php';
require_once './clases/Compra.php';
// Mis clases entidad-API
require_once './clases/UsuarioApi.php';
require_once './clases/CompraApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


/*
            TESTEADOS OK
$app->post('/usuario', \UsuarioApi::class . ':AltaDeUsuario');
$app->post('/login', \UsuarioApi::class . ':CrearTokenParaUsuario');

*//*
$app->post('/usuario', \UsuarioApi::class . ':AltaDeUsuario')->add(new MWdeJWT());

$app->post('/login', \UsuarioApi::class . ':CrearTokenParaUsuario');

$app->get('/usuario', \UsuarioApi::class . ':ListaDeUsuarios')->add(new MWdelPuntoTres())->add(new MWdeJWT());


$app->post('/compra', \CompraApi::class . ':IngresaCompra')->add(new MWdeJWT());

$app->get('/compra', \CompraApi::class . ':ListadoCompras')->add(new MWdeJWT());

$app->post('/prueba', function ($request, $response){
    
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $datosGuardar = date("H:i:s");
    echo var_dump($datosGuardar);
    
    //$miCompra = new Compra("lata de pintura", "2018-02-17", "20,48");


    //Compra::InsertaCompraBase();

});*/


$app->group('', function () {
    $this->post('/login', \UsuarioApi::class . ':CrearTokenParaUsuario')->setName('Punto 2');
    $this->group('', function () 
    {//grupo para las que necesitan web token
        $this->post('/usuario', \UsuarioApi::class . ':AltaDeUsuario')->setName('Punto 1');
        $this->get('/usuario', \UsuarioApi::class . ':ListaDeUsuarios')->setName('Punto 3')->add(new MWdelPuntoTres());
        $this->post('/compra', \CompraApi::class . ':IngresaCompra')->setName('Punto 4 y 7');
        $this->get('/compra', \CompraApi::class . ':ListadoCompras')->setName('Punto 5 y 8');
    })->add(new MWdeJWT());
})->add(new MWdeLOG());//el que guarda en la base las rutas/usuario etc

/*

Hay que averiguar como acumular contenido de los response para que no se pisen (como el JWT)
que no termina devolviendo el nuevo token si hay algun otro agregado al response

metodo getHeaders??

*/




//$app->group('', function() {
//    //      2)
//    //Retorna JWT o un error con la información de que esta mal(la clave o el sexo , o el nombre no existe) 
//    $app->post('/login','');
//    
//    $app->group('', function(){
//        //      1)
//        //Un alta de usuario (nombre, clave, sexo)
//        //REQUEST: nombre clave sexo (perfil default: usuario)
//        //Yo le agrego: valida que sea usuario admin
//        $app->post('usuario', \UsuarioApi::class . ':AltaDeUsuario');
//
//        //      3)
//        //retorna la lista de usuarios, solo si sos admin, de lo contrario retorna un “hola”.
//        $app->get('/usuario/{token}','(request response args)');//->add(/* Middleware punto3 */);
//
//        //      4)
//        //se ingresa un artículo , la fecha y el precio de la compra, solo personas que estén registradas en el sistema.
//        //subir una imagen que se guarde en la carpeta “IMGCompras” con el nombre del id de la compra y el artículo.
//        $app->post('/compra','');
//        
//        //      5)
//        //retorna el listado de compras del usuario pero si es un admin, retorna todas compras
//        $app->get('/compra/{token}','');
//
//    })/*->add(new MWdeJWT())*/;
//})->add(/* Middleware para todas las rutas */'');





//Hacer un middleware para todas las rutas que guarde en la BD los siguientes datos: usuario, metodo,ruta y hora.




/* Total:   Middlewares:
            - Valida JWT
            - Valida perfil
            - Guarda para todas las rutas {usuario, metodo, ruta, hora}             */

$app->run();


?>