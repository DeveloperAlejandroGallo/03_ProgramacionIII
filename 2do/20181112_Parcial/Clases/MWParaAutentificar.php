<?php

require_once "AutentificadorJWT.php";
class MWparaAutentificar
{

	public function ValidarUsuario($request, $response, $next) {
         
		$resp = new stdclass();
		$resp->respuesta="";
		$token="";
		$newResponse = $response;

		$token = $request->getHeader('token')[0];
			
		try 
		{
			//$token="";
			AutentificadorJWT::verificarToken($token);
			$resp->esValido=true;      
		}
		catch (Exception $e) {      
			//guardar en un log
			$resp->excepcion=$e->getMessage();
			$resp->esValido=false;     
		}

		if($resp->esValido)
		{	
				
			$newResponse = $next($request, $response);
		}    
		else
		{
			//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
			$resp->respuesta="Solo usuarios registrados";
			$resp->elToken=$token;
			$newResponse = $response->withJson($resp, 501);  
		}  
				  
		 return $newResponse;
	}
}