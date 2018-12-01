<?php
require_once 'carta.php';


class cartaApi extends carta
{


    public function CargarUno($request, $response, $args)
    {
        $body = json_decode(json_encode($request->getParsedBody()));

        if (isset($body->id, $body->descripcion, $body->precio, $body->sector)) 
        {
            $id = $body->id;
            if (carta::verificarArticulo($id) == false) {

                $descripcion = $body->descripcion;
                $precio = $body->precio;
                $sector = $body->sector;

                $miArticulo = new carta();
                $miArticulo->id = $id;
                $miArticulo->descripcion = $descripcion;
                $miArticulo->precio = $precio;
                $miArticulo->sector = $sector;
                $respuesta = $miArticulo->InsertarUno();

                if ($response != "") {
                    $response = "se guardo el articulo con el id $id";
                } else {
                    $response = "Error al  guardar el articulo";
                }

            } else {
                $response = "El id esta duplicado";
            }




        } else {
            $response = "Faltan Parametros";
        }


        return $response;
    }

    public function BorrarUno($request, $response, $args)
    {
        $body = json_decode(json_encode($request->getParsedBody()));

        $id = $body->id;
        if (carta::verificarArticulo($id) == true) {

            $cantidadDeBorrados = carta::BorrarId($id);

            $objDelaRespuesta = new stdclass();
            // $objDelaRespuesta->cantidad=$cantidadDeBorrados;
            if ($cantidadDeBorrados) {
                $objDelaRespuesta->resultado = "Se Borro el id: $id!!!";

            } else {
                $objDelaRespuesta->resultado = "no Borro nada !!!";
            }


        } else {
            $objDelaRespuesta->resultado = "El id no existe";
        }


        $newResponse = $response->withJson($objDelaRespuesta, 200);

        return $newResponse;
    }


    public function ModificarUnArticulo($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $body = json_decode(json_encode($request->getParsedBody()));
        //var_dump($body);  
        $objDelaRespuesta = new stdclass();
        if (isset($body->id, $body->precio)) {

            $miArticulo = new carta();
            $id = $body->id;
            $miArticulo->precio = $body->precio;
            $miArticulo->id = $id;
            if (carta::verificarArticulo($id) == true) {

                $resultado = $miArticulo->ModificarUno();
                $objDelaRespuesta = new stdclass();
                //var_dump($resultado);
                $objDelaRespuesta->resultado = $resultado;
            } else {
                $objDelaRespuesta->resultado = "el id no existe";
            }

        } else {
            $objDelaRespuesta->resultado = "Faltan Parametros";
        }
        return $response->withJson($objDelaRespuesta, 200);
    }


    public function TraerTodos($request, $response, $args)
    {
        $articulos = array();

        $articulos = carta::TraerTodosLosArticulos();
        return $response->withJson($articulos, 200);
    }
}