<?php
require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'caja.php';

class cajaApi extends caja 
{

    public function CargarUno($request, $response, $args) {
   
        
        $token=$request->getHeader('token')[0];
        $payload= AutentificadorJWT::ObtenerPayLoad($token);
                            
        $nuevoUser= new empleados();
        $nuevoUser= $payload->data;
        $objDelaRespuesta= new stdclass();

        $body = json_decode(json_encode($request->getParsedBody()));

    if(isset($body->mesa))
    {

        
        $datetime_now = date("Y-m-d");
        $empleado=$nuevoUser->nombre;       
        $mesa=$body->mesa;
        //$codigo=$body->codigoPedido;
        $factura= new caja();
        $factura->fecha=$datetime_now;
        $factura->empleado= $empleado;
        $factura->mesa=$mesa;
        //$factura->codigoPedido= $codigo;
        $factura->importe= 0;

        $respuesta =$factura->CerrarPedido();
        //$respuesta = pedidos::CerrarPedido($mesa,$codigo);
        
    }else{
        $respuesta = "Faltan Parametros";
    }
    /*$objDelaRespuesta->resultado=$respuesta;
    return $response->withJson($objDelaRespuesta, 200);*/
    $response->getBody()->write($respuesta);
     return  $response;
}

public function traerTodos($request, $response, $args) {
    $cajas =caja::obtenerTodos();
  
     return  $response->withJson($cajas, 200);

   }
   




}