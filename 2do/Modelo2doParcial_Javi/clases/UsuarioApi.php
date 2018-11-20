<?php 
require_once 'AutentificadorJWT.php';

class UsuarioApi extends Usuario
{
    public function __construct()
    {
    }

    public function AltaDeUsuario($request, $response)
    {
        $newResponse = $response;
        $objRespuesta = new stdclass();
        $respuestaApuntada = $objRespuesta;

        $body = $newResponse->getBody()->__toString();
        $miJsonReseponse = json_decode($body);

        if (isset($miJsonReseponse))
        {
            //existe algo en el body
            $respuestaApuntada = $miJsonReseponse;
        }

        $data = $request->getParsedBody();
        $input = [];
        $input['nombre'] = filter_var($data['nombre'], FILTER_SANITIZE_STRING);
        $input['clave'] = filter_var($data['clave'], FILTER_SANITIZE_STRING);
        $input['sexo'] = filter_var($data['sexo'], FILTER_SANITIZE_STRING);
        $input['perfil'] = "usuario";

        if(isset($data['nombre']) && isset($data['clave']) && isset($data['sexo']))
        {
            $usuarioAlta = new Usuario($input['nombre'], $input['clave'], $input['sexo'], $input['perfil']);
            //echo var_dump($usuarioAlta);
            //echo var_dump(gettype(Usuario::ValidarIDUsuario($usuarioAlta->nombre)));
            if (gettype(Usuario::ValidarIDUsuario($usuarioAlta->nombre)) != "string")
            {     
                if(Usuario::InsertaUsuarioBase($usuarioAlta))
                {
                    $respuestaApuntada->Result = "El usuario {$usuarioAlta->nombre} se ingreso correctamente";
                    $newResponse = $newResponse->withJson($respuestaApuntada, 200);
                }
                else
                {
                    $respuestaApuntada->Error = "Hubo un error. Intente de nuevo";
                    $newResponse = $newResponse->withJson($respuestaApuntada, 500);
                }
            }
            else
            {
                $respuestaApuntada->Error = "Ya existe un usuario con nombre '{$usuarioAlta->nombre}'";
                $newResponse = $newResponse->withJson($respuestaApuntada, 200);
            }
        }
        else
        {
            $respuestaApuntada->Error = "Faltan setear parametros de entrada";
            $newResponse = $newResponse->withJson($respuestaApuntada, 500);
        }

        
        return $newResponse;
    }

    public function CrearTokenParaUsuario($request, $response)
    {
        $newResponse = $response;
        $objRespuesta = new stdclass();
        $errorString = "Datos incorrectos:";

        $data = $request->getParsedBody();
        $input = [];
        $input['nombre'] = filter_var($data['nombre'], FILTER_SANITIZE_STRING);
        $input['clave'] = filter_var($data['clave'], FILTER_SANITIZE_STRING);
        $input['sexo'] = filter_var($data['sexo'], FILTER_SANITIZE_STRING);

        $datosCorrectos = Usuario::TraerUno($input['nombre']);

        if (isset($datosCorrectos[0]))
        {
            $datosOK = $datosCorrectos[0];
            if ($datosOK['clave'] == $input['clave'] && $datosOK['sexo'] == $input['sexo'])
            {
                $objRespuesta->JWT = AutentificadorJWT::CrearToken($input['nombre']);
                $newResponse = $response->withJson($objRespuesta, 200);
            }
            else
            {
                if ($datosOK['clave'] != $input['clave'])
                {
                    $errorString .= " clave";
                }
                if ($datosOK['sexo'] != $input['sexo'])
                {
                    $errorString .= " sexo";
                }
                $objRespuesta->Error = $errorString;
                $newResponse = $response->withJson($objRespuesta, 407);
            }
        }
        else
        {
            $errorString .= " nombre";
            $objRespuesta->Error = $errorString;
            $newResponse = $response->withJson($objRespuesta, 407);
        }

        return $newResponse;
    }

    public function ListaDeUsuarios($request, $response)
    {
        $newResponse = $response;
        $objRespuesta = new stdclass();
        $respuestaApuntada = $objRespuesta;

        $body = $newResponse->getBody()->__toString();
        $miJsonReseponse = json_decode($body);

        if (isset($miJsonReseponse))
        {
            //existe algo en el body
            $respuestaApuntada = $miJsonReseponse;
        }

        $usuarios = Usuario::TraerTodos();
        
        $output = "";
        $rows = "";
        foreach($usuarios as $dato)
        {
            $rows .= "<tr><td>" . $dato['nombre'] . "</td>";
            $rows .= "<td>" . $dato['sexo'] . "</td>";
            $rows .= "<td>" . $dato['perfil'] . "</td>";
            $rows .= "<td>" . $dato['ROW_ID'] . "</td></tr>";
        }

        $output = "<table id='tablaUsuarios'><tr><th>Nombre</th><th>Sexo</th><th>Perfil</th><th>User ID</th></tr>" . $rows . "</table>";
        $respuestaApuntada->Result = $output;
        $newResponse = $response->withJson($respuestaApuntada, 200);
        return $newResponse;
    }
}