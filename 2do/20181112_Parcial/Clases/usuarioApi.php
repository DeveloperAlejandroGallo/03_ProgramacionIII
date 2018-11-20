<?php
require_once 'usuario.php';

class usuarioApi extends usuario
{
    public function altaUsuario($request, $response, $args)
    {
        $objValido = new usuario();
        $res = new stdclass();
        $codRespuesta = 402;

        $body =  json_decode(json_encode($request->getParsedBody()));
        // var_dump($body);

        if(isset($body->email)&&isset($body->clave)&&isset($body->perfil))
        {

            $miusuario = new usuario();
            $miusuario->email = $body->email;
            $miusuario->clave = $body->clave;
            $miusuario->perfil = $body->perfil;
        
            if($miusuario->InsertarUsuario())
            {
                $res->respuesta = "Se guardo el usuario $body->email.";
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



    public function TraerUno($request, $response,$email)
    {
        $NuevaRespuesta = $response;

        $elusuario = usuario::TraerUnUsuario($email);
        if (!$elusuario) 
        {
            $objDelaRespuesta = new stdclass();
            $objDelaRespuesta->error = "email de usuario inexistente.";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500);
        } else 
        {
            $NuevaRespuesta = $response->withJson($elusuario, 200);
        }

        return $NuevaRespuesta;
    }



    public function crearTokenUsr($request, $response)
    {
        
        $respuesta = $response;
        $objRespuesta = new stdClass();
        $respuestaStr = "Datos erroneos: ";
        
        $datos =  json_decode(json_encode($request->getParsedBody()));

        if(isset($datos->email))
        {           

            $elusuario = usuario::TraerUnUsuario($datos->email);
            // echo "<br><b>Devolucion de usuario:</b>"; var_dump($elusuario);

            if ($elusuario) 
            {

                if($datos->email == $elusuario->email && $datos->clave == $elusuario->clave)
                {
                    $input = [];
                    $input['email'] = $elusuario->email;
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
                    
                    if($datos->perfil != $elusuario->perfil)
                        $respuestaStr .= "perfil incorrecto. ";
                    
                    $objRespuesta->error = $respuestaStr;
                    $respuesta = $response->withJson($objRespuesta,500);
                }
            }
            else
            {
                $objRespuesta->error =  "Email ingresado incorrecto";
                $respuesta = $response->withJson($objRespuesta, 500);
            }
        }
        else
        {
            $objRespuesta->error = "Debe informar el email de usuario.";
            $respuesta = $response->withJson($objRespuesta, 500);
        }

        return $respuesta;
    }



    public function listaDeUsuarios($request, $response)
    {
        
        
        $todosLosUsuarios = usuario::TraerTodosLosUsuarios();
       return  $response->withJson($todosLosUsuarios, 200);

    }



}