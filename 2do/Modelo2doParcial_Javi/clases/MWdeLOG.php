<?php
class MWdeLOG
{
    function __invoke ($request, $response, $next)
    {
        $datosGuardar = new stdclass();
        $newResponse = $response;
        $headerJWT = $request->getHeader('JWT');
        
        if(count($headerJWT) > 0)
        {
            $miToken = $headerJWT[0];
            try
            {
                $miUsuario = Usuario::TraerUno(AutentificadorJWT::ObtenerNombre($miToken));
            }
            catch (Exception $e)
            {
                $datosGuardar->Error = "Token invalido";
                return $newResponse->withJson($datosGuardar, 500);
            }
            $datosGuardar->Usuario = $miUsuario[0]["nombre"];
        }
        else
        {
            $datosGuardar->Usuario = "Sin loguearse";
        }

        if($request->isGet())
        {
            $datosGuardar->Metodo = "GET";
        }
        else if($request->isPost())
        {
            $datosGuardar->Metodo = "POST";
        }

        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $datosGuardar->Hora = date("H:i:s");

        $route = $request->getAttribute('route');
        $datosGuardar->Ruta = $route->getName();
       
       
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sqltxt = "INSERT into `logs`(`usuario`, `metodo`, `hora`, `ruta`) VALUES ('{$datosGuardar->Usuario}', '{$datosGuardar->Metodo}', '{$datosGuardar->Hora}', '{$datosGuardar->Ruta}')";
        $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
        $consulta->execute();




        $newResponse = $next($request, $newResponse);
        return $newResponse;
    }
}

?>