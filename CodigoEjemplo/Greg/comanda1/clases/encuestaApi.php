<?php

//require_once 'IApiUsable.php';
require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'caja.php';
require_once 'encuesta.php';

class encuestaApi extends encuesta //implements IApiUsable
{


    public function CargarUno($request, $response, $args) {
   
        $ArrayDeParametros = $request->getParsedBody();

    if(isset($ArrayDeParametros['codigoPedido'],$ArrayDeParametros['mesa'],$ArrayDeParametros['restaurante'],$ArrayDeParametros['cocinero'],$ArrayDeParametros['mozo'],$ArrayDeParametros['experiencia']))
    {

    if(is_numeric($ArrayDeParametros['mesa'])==true & is_numeric($ArrayDeParametros['restaurante'])==true & is_numeric($ArrayDeParametros['mozo'])==true & is_numeric($ArrayDeParametros['cocinero'])==true)
    {

         
        $codigo=$ArrayDeParametros['codigoPedido'];
        $respuesta=  pedidos::TraerIdMesa($codigo,"pagado");
        if($respuesta!=null){

           $mesa= mesas::TraerId($respuesta->mesa);
           if($mesa->estado == "con clientes pagando"){

            $miEncuesta= new encuesta();
            $miEncuesta->codigoPedido= $codigo;
            $miEncuesta->codigoMesa=$mesa->codigo;
            $miEncuesta->restaurante= $ArrayDeParametros['restaurante'];
            $miEncuesta->cocinero=$ArrayDeParametros['cocinero'];
            $miEncuesta->mozo=$ArrayDeParametros['mozo'];
            $miEncuesta->mesa=$ArrayDeParametros['mesa'];
            $miEncuesta->experiencia= $ArrayDeParametros['experiencia'];

            $consulta=$miEncuesta->InsertarUno();
            if($consulta=!null){
                $respuesta = "Se guardo correctamente la encuesta";
            }else{
                $respuesta = "Error al ejecutar la consulta";
            }


           }else{
            $respuesta = "El mozo todavia no habilito la encuesta";
           }
           

        }else{
            $respuesta = "Codigo Erroneo";
        }
        
    }else{
        $respuesta = "Alguno de los parametros no son validos la puntuacion tiene que ser del 1 al 10";
    }   
        
    }else{
        $respuesta = "Faltan Parametros";
    }
    $objDelaRespuesta->resultado=$respuesta;
    return $response->withJson($objDelaRespuesta, 200);
}




public function traerTodos($request, $response, $args) {
 $encuestas =encuesta::TraerTodos();
  $newResponse= encuesta::GenerarTabla($encuestas); 
  $response->getBody()->write($newResponse);
  return  $response;
  /*$objDelaRespuesta->resultado=$respuesta;
  return $response->withJson($objDelaRespuesta, 200);*/
}


}