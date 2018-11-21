<?php 

require_once 'usuario.php';
require_once 'IApiUsable.php';
require_once 'AutentificadorJWT.php';

class usuarioApi extends usuario implements IApiUsable
{
    function __construct()
    {
    }

    public function AltaDeUsuario($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";

        $body=$request->getParsedBody();
        $verificarDuplicado=usuario::TraerUnUsuario($body["email"]);
        if($verificarDuplicado==NULL)
        {

            $unUsuario = new usuario($body["email"], $body["clave"], $body["perfil"]);

            $insertOk= usuario::InsertaUsuarioBase($unUsuario);

            if($insertOk)
            {
                $objDelaRespuesta->respuesta="El usuario $unUsuario->email se ingreso correctamente";
                $nueva=$response->withJson($objDelaRespuesta, 401);
            }
            else
            {
                $objDelaRespuesta->respuesta="Hubo un error. Intente de nuevo";
                $nueva=$response->withJson($objDelaRespuesta, 401);
            }
        }
        else
        {
            $objDelaRespuesta->respuesta="El usuario ya se encuentra registrado en el sistema";
            $nueva=$response->withJson($objDelaRespuesta, 401);
        }

        return $response;
    }

    public function CrearTokenParaUsuario($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        $output = $response;
        $body=$request->getParsedBody();
        $input = usuario::TraerUnUsuario($body["email"]);//MODIFICAR BODY
        if($input!=NULL)
        {
            $unUsuario = new usuario($input[0][0], $input[0][1], $input[0][2]);
            //var_dump($unUsuario);
            if ($unUsuario != NULL)
            {
                if ($body["clave"] == $unUsuario->clave)
                {
                    if($body["email"] == $unUsuario->email)
                    {
                        $token = AutentificadorJWT::CrearToken($unUsuario->email);
                        $output = $response->withAddedHeader('token', $token);
                        $objDelaRespuesta->respuesta=$token;
                        $nueva=$response->withJson($objDelaRespuesta, 401);
                    }
                    else
                    {
                        $objDelaRespuesta->respuesta="El email es incorrecto";
                        $nueva=$response->withJson($objDelaRespuesta, 401);
                    }
                }
                else
                {
                    $objDelaRespuesta->respuesta="La clave es incorrecta";
                    $nueva=$response->withJson($objDelaRespuesta, 401);
                }
            }
        }
        else
        {
            $objDelaRespuesta->respuesta="El email es incorrecto; no se encontro registrado en el sistema";
            $nueva=$response->withJson($objDelaRespuesta, 401);
        }
        
        return $output;
    }

    public function ArmaListaUsuarios($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";

        $usuarios=usuario::TraerTodoLosUsuarios();//revisar como lo devuelve
        $objDelaRespuesta->respuesta=$usuarios;
        $nueva=$response->withJson($objDelaRespuesta, 401);
        //var_dump($response);
        return $response;
    }
}