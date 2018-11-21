<?php

require_once "AutentificadorJWT.php";
require_once "usuario.php";
class MiddlewareAPI
{
    public function VerificarUsuario($request, $response, $next) {
         
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
	   
		if($request->isGet())
		{
		 	$response = $next($request, $response);
		}
		else
		{
			$arrayConToken = $request->getHeader('token');
			$token=$arrayConToken[0];			
			$objDelaRespuesta->esValido=true; 
			try 
			{
				//$token="";
				AutentificadorJWT::verificarToken($token);
				$objDelaRespuesta->esValido=true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}

			if($objDelaRespuesta->esValido)
			{						
				if($request->isPost())
				{		
					// el post sirve para todos los logeados			    
					$response = $next($request, $response);
				}
				else
				{
					$payload=AutentificadorJWT::ObtenerData($token);
					//var_dump($payload);
					// DELETE,PUT y DELETE sirve para todos los logeados y admin
					/*if($payload->perfil=="Administrador")
					{
						$response = $next($request, $response);
					}		           	
					else
					{	
						$objDelaRespuesta->respuesta="Solo administradores";
					}*/
				}		          
			}    
			else
			{
				$objDelaRespuesta->respuesta="Solo usuarios registrados";
				$objDelaRespuesta->elToken=$token;

			}  
		}		  
		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}

		 return $response;   
    }
    

    public function VerificarPerfilUsuario($request, $response, $next)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        
        $arrayConToken = $request->getHeader('token');
		$token=$arrayConToken[0];
        $mailUsuario=AutentificadorJWT::ObtenerData($token);
        $unUsuario=usuario::TraerUnUsuario($mailUsuario);
        //var_dump($unUsuario);

        if($unUsuario[0][2] == "admin")
        {
            $response=$next($request,$response);//la de usuario api
        }
        else
        {
            $uri=$request->getUri();
            
            $objDelaRespuesta->respuesta=compraApi::ListaPorUsuario($request, $response);
            $nueva=$response->withJson($objDelaRespuesta, 401); //mejorar apariencia pq sigue estado el doble array
        }

        return $response;
    }

    public function VerificarPerfilUsuarioMarca($request, $response, $next)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        
        $arrayConToken = $request->getHeader('token');
		$token=$arrayConToken[0];
        $mailUsuario=AutentificadorJWT::ObtenerData($token);
        $unUsuario=usuario::TraerUnUsuario($mailUsuario);
        //var_dump($unUsuario);

        if($unUsuario[0][2] == "admin")
        {
            $response=$next($request,$response);//la de usuario api
        }
        else
        {
            $uri=$request->getUri();
            
            $objDelaRespuesta->respuesta="Usuario no habilitado para realizar la operacion";
            $nueva=$response->withJson($objDelaRespuesta, 401); 
        }

        return $response;
    }

    public function GuardarUsuarioRuta($request, $response, $next)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        
        $usuario='';
        $metodo='';
        $ruta=''; 
        $hora='';

        if($request->isPost())
        {
            $metodo="post";
        }
        else
        {
            $metodo="get";
        }

        $uri=$request->getUri();
        $ruta=$uri->getPath();

        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $hora = date("H:i:s");
        //$hora= time();

        $arrayConToken = $request->getHeader('token');
        if(count($arrayConToken)>0)
        {
            $token=$arrayConToken[0];
            $usuario=AutentificadorJWT::ObtenerData($token);
        }
        else
        {
            $usuario="no logueado";
        }
        
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("insert into `api_datos`(`usuario`, `metodo`, `ruta`, `hora`) values ('$usuario', '$metodo', '$ruta', '$hora')");
        $consulta->execute();

        $response = $next($request, $response);
        return $response;
    }

}