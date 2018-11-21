<?php
require_once "AutentificadorJWT.php";

class MWlistarUsuarios
{
    public function listarUsuarios($request, $response, $next)
    {
        $newRes = $response;
        $resp = new stdclass();
        // $token = $request->getQueryParam('token');
        $token = $request->getHeader('token')[0];
        $valido = false;
        try 
		{
			AutentificadorJWT::verificarToken($token);
            $valido = true;
		}
        catch (Exception $e) 
        {      
			//guardar en un log
			$resp->excepcion=$e->getMessage();
   
		}
        if($valido)
        {
            $data = AutentificadorJWT::ObtenerData($token);
            if($data->tipo == "admin")
            {
                $newRes = $next($request, $response); //ejecuta el listar del usr para el admin
            }
            else
            {
                 $resp->nombreUsuario = $data->nombre;
                 $resp->tipoUsuario = $data->tipo;

                 $newRes = $response->withJson($resp,200);  
            }
        }
        else
        {
            $resp->error = "Token Inválido";
            $newRes =  $response->withJson($resp,501);
        }
        
        return $newRes;
    }
}



?>