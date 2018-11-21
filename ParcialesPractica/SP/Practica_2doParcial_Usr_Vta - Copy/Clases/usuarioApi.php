<?php

require_once 'usuario.php';

class usuarioApi extends usuario
{
    public function altaUsuario($request, $response, $args)
    {#POST
        $objValido = new usuario();
        $res = new stdclass();
        $codRespuesta = 402;

        $body =  json_decode(json_encode($request->getParsedBody()));
        // var_dump($body);

        if(isset($body->nombre)&&isset($body->clave)&&isset($body->sexo))
        {

            $miusuario = new usuario();
            $miusuario->nombre = $body->nombre;
            $miusuario->clave = $body->clave;
            $miusuario->sexo = $body->sexo;
        
            if($miusuario->InsertarUsuario())
            {
                $res->respuesta = "Se guardo el usuario $body->nombre.";
                $codRespuesta = 200;
            }
            else
            {
                $res->respuesta = "Error al insertar.";
            }
        }
        else
        {
            $res->respuesta = "Parametros incorrectos.";
        }

        return $response->withJson($res, $codRespuesta);
    }

    public function crearTokenUsr($request, $response)
    {
        
        $respuesta = $response;
        $objRespuesta = new stdClass();
        $respuestaStr = "Datos erroneos: ";
        
        $datos =  json_decode(json_encode($request->getParsedBody()));

        if(isset($datos->nombre))
        {           

            $elusuario = usuario::TraerUnUsuario($datos->nombre);
            // echo "<br><b>Devolucion de usuario:</b>"; var_dump($elusuario);

            if ($elusuario) 
            {

                if($datos->nombre == $elusuario->nombre && $datos->clave == $elusuario->clave)
                {
                    $input = [];
                    $input['nombre'] = $elusuario->nombre;
                    $input['sexo'] = $elusuario->sexo;
                    $input['perfil'] = $elusuario->perfil;
                    
                    $token = AutentificadorJWT::CrearToken($input);
                    $objRespuesta->mensaje = "Token Creado";
                    $objRespuesta->token = $token;
                    $response->withHeader('token',$token);
                    $respuesta = $response->withHeader('token',$token);
                    //$response->withJson( $objRespuesta, 200);
                    
                    
                }
                else
                {
                    if($datos->clave != $elusuario->clave)
                        $respuestaStr .= "Clave incorrecta. ";
                    
                    if($datos->sexo != $elusuario->sexo)
                        $respuestaStr .= "Sexo incorrecto. ";
                    
                    $objRespuesta->error = $respuestaStr;
                    $respuesta = $response->withJson($objRespuesta,500);
                }
            }
            else
            {
                $objRespuesta->error =  "Nombre ingresado incorrecto";
                $respuesta = $response->withJson($objRespuesta, 500);
            }
        }
        else
        {
            $objRespuesta->error = "Debe informar el nombre de usuario.";
            $respuesta = $response->withJson($objRespuesta, 500);
        }

        return $respuesta;
    }



    public function listaDeUsuarios($request, $response)
    {
        
        
        $todosLosUsuarios = usuario::TraerTodosLosUsuarios();
        return  $response->withJson($todosLosUsuarios, 200);

    }



    public function TraerUno($request, $response,$nombre)
    {
        $NuevaRespuesta = $response;

        $elusuario = usuario::TraerUnUsuario($nombre);
        if (!$elusuario) 
        {
            $objDelaRespuesta = new stdclass();
            $objDelaRespuesta->error = "nombre de usuario inexistente.";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500);
        } else 
        {
            $NuevaRespuesta = $response->withJson($elusuario, 200);
        }

        return $NuevaRespuesta;
    }

}