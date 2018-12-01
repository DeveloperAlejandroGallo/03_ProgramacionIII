<?php

require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'caja.php';
require_once 'encuesta.php';

class encuestaApi extends encuesta 
{


public function CargarUno($request, $response, $args) 
{

    $body = json_decode(json_encode($request->getParsedBody()));

    if(isset($body->codigoPedido) && isset($body->mesa) && isset($body->restaurante)
    && isset($body->cocinero)     && isset($body->mozo) && isset($body->experiencia))
    {

        if(is_numeric($body->mesa)&& is_numeric($body->restaurante)
        && is_numeric($body->mozo)&& is_numeric($body->cocinero))
        {
           
            $codigo=$body->codigoPedido;
            $respuesta=  pedidos::TraerIdMesa($codigo,"pagado");
            if($respuesta!=null)
            {

                $mesa= mesas::TraerId($respuesta->mesa);
                if($mesa->estado == "con clientes pagando")
                {

                        $miEncuesta= new encuesta();
                        $miEncuesta->codigoPedido= $codigo;
                        $miEncuesta->codigoMesa=$mesa->codigo;
                        $miEncuesta->restaurante= $body->restaurante;
                        $miEncuesta->cocinero=$body->cocinero;
                        $miEncuesta->mozo=$body->mozo;
                        $miEncuesta->mesa=$body->mesa;
                        $miEncuesta->experiencia= $body->experiencia;

                        $consulta=$miEncuesta->InsertarUno();

                        if($consulta=!null)
                            $respuesta = "Se guardo correctamente la encuesta";
                        else
                            $respuesta = "Error al ejecutar la consulta";
                }
                else
                    $respuesta = "El mozo todavia no habilito la encuesta";

            }
            else
                $respuesta = "Codigo Erroneo";
        }
        else
            $respuesta = "Alguno de los parametros no son validos la puntuacion tiene que ser del 1 al 10";
        
    }
    else
        $respuesta = "Faltan Parametros";
    
    $objDelaRespuesta->resultado=$respuesta;
    return $response->withJson($objDelaRespuesta, 200);
}




public function traerTodos($request, $response, $args) 
{
 $encuestas =encuesta::obtenerTodos();
  return $response->withJson($encuestas, 200);
}


}