<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class usuarioApi extends usuario implements IApiUsable
{

    public function login($request, $response)
    {
        echo "ingreso a Login";
        $respuesta = $response;
        $objRespuesta = new stdClass();
        $respuestaStr = "Datos erroneos: ";
        
        $datos = $request->getParsedBody();
        

        if(isset($datos['nombre']))
        {           
            echo "<br>datos seteados";
            $input = [];
            $input['nombre'] = filter_var($datos['nombre'], FILTER_SANITIZE_STRING);
            $input['clave'] = filter_var($datos['clave'], FILTER_SANITIZE_STRING);
            $input['sexo'] = filter_var($datos['sexo'], FILTER_SANITIZE_STRING);
            //$input['perfil'] = filter_var($datos['perfil'], FILTER_SANITIZE_STRING);
            var_dump($input);
            echo "<br>voy a consultar el usr";
            $usuarioBuscado = $this->TraerUno($request,$response, $input['nombre']);
            //var_dump($consultaUsuario);
            if ($consultaUsuario->getStatusCode() == 200) 
            {
                if($input['clave'] == $consultaUsuario->clave 
                && $input['sexo'] == $consultaUsuario->sexo)
                {
                    $token = AutentificadorJWT::CrearToken($datos);
                    $respuesta = $response->withJson($token, 200);
                    
                }
                else
                {
                    if($input['clave'] != $consultaUsuario->clave)
                        $respuestaStr .= "Clave incorrecta. ";
                    
                    if($input['sexo'] != $consultaUsuario->clave)
                        $respuestaStr .= "Sexo incorrecto. ";
                    
                    $objDelaRespuesta->error = $respuestaStr;
                    $respuesta = $response->withJson($objDelaRespuesta,460);
                }
            }
            else
            {
                $objRespuesta->error =  $consultaUsuario->error;
                $respuesta = $response->withJson($objDelaRespuesta, 461);
            }
        }
        else
        {
            $objRespuesta->error = "Debe informar el nombre de usuario.";
            $respuesta = $response->withJson($objDelaRespuesta, 462);
        }

        return $respuesta;
    }




    public function TraerUno($request, $response,$nombre)
    {
        $NuevaRespuesta = $response;

        $elusuario = usuario::TraerUnUsuario($nombre);
        echo "<br><b>Devolucion de usuario:</b>"; var_dump($elusuario);
        if (!$elusuario) 
        {
            $objDelaRespuesta = new stdclass();
            $objDelaRespuesta->error = "Nombre de usuario inexistente.";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500);
        } else 
        {
            $NuevaRespuesta = $response->withJson($elusuario, 200);
        }
        echo "<br><b>NUEVA RESPUESTA :</b> "; VAR_DUMP($NuevaRespuesta->getParsedBody()); 
        return $NuevaRespuesta;
    }

    public function TraerTodos($request, $response, $args)
    {
        $todosLosusuarios = usuario::TraerTodoLosUsuarios();
        $newresponse = $response->withJson($todosLosUsuarios, 200);
        return $newresponse;
    }

    public function CargarUno($request, $response, $args)
    {

        $objDelaRespuesta = new stdclass();

        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre = $ArrayDeParametros['nombre'];
        $clave = $ArrayDeParametros['clave'];
        $sexo = $ArrayDeParametros['sexo'];


        if (isset($ArrayDeParametros['perfil']))
            $perfil = $ArrayDeParametros['perfil'];
        else
            $perfil = "usuario";

        $miusuario = new usuario();
        $miusuario->nombre = $nombre;
        $miusuario->clave = $clave;
        $miusuario->sexo = $sexo;
        $miusuario->perfil = $perfil;
        $miusuario->InsertarUsuario();
        // $archivos = $request->getUploadedFiles();
        // $destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        // if(isset($archivos['foto']))
        // {
        //     $nombreAnterior=$archivos['foto']->getClientFilename();
        //     $extension= explode(".", $nombreAnterior)  ;
        //     //var_dump($nombreAnterior);
        //     $extension=array_reverse($extension);
        //     $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
        // }       
        //$response->getBody()->write("se guardo el usuario");
        $objDelaRespuesta->respuesta = "Se guardo el usuario.";
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['id'];
        $usuario = new usuario();
        $usuario->id = $id;
        $cantidadDeBorrados = $usuario->BorrarUsuario();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        if ($cantidadDeBorrados > 0) {
            $objDelaRespuesta->resultado = "algo borro!!!";
        } else {
            $objDelaRespuesta->resultado = "no Borro nada!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }

    public function ModificarUno($request, $response, $args)
    {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
        $miusuario = new usuario();
        $miusuario->id = $ArrayDeParametros['id'];
        $miusuario->nombre = $ArrayDeParametros['nombre'];
        $miusuario->clave = $ArrayDeParametros['clave'];
        $miusuario->sexo = $ArrayDeParametros['sexo'];
        $miusuario->perfil = $ArrayDeParametros['perfil'];

        $resultado = $miusuario->Modificarusuario();
        $objDelaRespuesta = new stdclass();
		//var_dump($resultado);
        $objDelaRespuesta->resultado = $resultado;
        $objDelaRespuesta->tarea = "modificar";
        return $response->withJson($objDelaRespuesta, 200);
    }



}