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
        try 
		{
			AutentificadorJWT::verificarToken($token);
			$resp->esValido=true;      
		}
        catch (Exception $e) 
        {      
			//guardar en un log
			$resp->excepcion=$e->getMessage();
			$resp->esValido=false;     
		}
        if($resp->esValido)
        {
            if(AutentificadorJWT::ObtenerData($token)->perfil == "admin")
            {
                $newRes = $next($request, $response); //ejecuta el listar del usr para el admin
            }
            else
            {
                 $resp->mensaje = "Hola humano";
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