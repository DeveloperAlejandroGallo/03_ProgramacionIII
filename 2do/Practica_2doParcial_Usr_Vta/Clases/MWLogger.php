<?php

class MWLogger
{
    public function logger($request, $response, $next)
    {
        //Hacer un middleware para todas las rutas que guarde en la BD los siguientes datos: usuario, metodo,ruta y hora.
        $obj = new stdClass();
        $obj->usr = "Sin loguear";
        $obj->metodo = "";
        $obj->ruta = "";
        $obj->ruta = $request->getAttribute('route')->getName();
        try
        {
            $tokenAux = $request->getHeader('token');
            if($tokenAux)
                $token = $tokenAux[0];
            else
                $token = null;
        }
        catch (Exception $ex)
        {
            $token = null;
        }


        if($token != null)
        {
            try
            {
                AutentificadorJWT::VerificarToken($token);
                $obj->usr = AutentificadorJWT::ObtenerData($token)->nombre;
            }
            catch(Exception $ex)
            {
                $obj->usr = "Usuario inválido";
            }
            
        }

        if($request->isGet())
            $obj->metodo = "GET";
        
        if($request->isPost())
            $obj->metodo = "POST";
    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sqltxt = "INSERT INTO logs(usuario, metodo, ruta) VALUES ('$obj->usr', '$obj->metodo', '$obj->ruta')";
        $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
        $consulta->execute();
        $newResponse = $next($request, $response);
        return $newResponse;
    }
}
?>