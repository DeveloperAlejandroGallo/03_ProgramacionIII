<?php

//require_once 'IApiUsable.php';
require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'caja.php';

class cajaApi extends caja //implements IApiUsable
{


    public function CargarUno($request, $response, $args) {
   
        $arrayConToken = $request->getHeader('comandaToken');
        $token=$arrayConToken[0];
        $payload= login::ObtenerPayLoad($token);
                            
        $nuevoUser= new empleados();
        $nuevoUser= $payload->data;
        $objDelaRespuesta= new stdclass();

        $ArrayDeParametros = $request->getParsedBody();

    if(isset($ArrayDeParametros['mesa']))
    {

        
        $datetime_now = date("Y-m-d");
        $empleado=$nuevoUser->nombre;       
        $mesa=$ArrayDeParametros['mesa'];
        //$codigo=$ArrayDeParametros['codigoPedido'];
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
    $cajas =caja::TraerTodos();
     $newResponse= caja::GenerarTabla($cajas); 
     $response->getBody()->write($newResponse);
     return  $response;
     /*$objDelaRespuesta->resultado=$respuesta;
     return $response->withJson($objDelaRespuesta, 200);*/
   }
   




}