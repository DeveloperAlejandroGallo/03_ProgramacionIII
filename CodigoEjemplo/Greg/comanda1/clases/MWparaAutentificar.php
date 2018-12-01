<?php

require_once 'login.php';

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */





	public function VerificarMozos($request, $response, $next) {
				 
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
	   
		
		
		
				$arrayConToken = $request->getHeader('comandaToken');
				$token=$arrayConToken[0];
				
				try 
			{
				
				login::verificarToken($token);
				$objDelaRespuesta->esValido=true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}
			if($objDelaRespuesta->esValido)
			{
				$payload= login::ObtenerPayLoad($token);
				$nuevoUser= new empleados();
				$nuevoUser= $payload->data;
					
					if($nuevoUser->tipo=="mozos" ||$nuevoUser->tipo=="socios" )
					{
						$datos = array(
							'metodo'=>$_SERVER['REQUEST_METHOD'],
							'ruta' =>$_SERVER["REDIRECT_URL"]								
						);
		
						empleados::GuardarIngreso($datos,$nuevoUser); 

						$response = $next($request, $response);

					}		           	
					else
					{	
						$objDelaRespuesta->respuesta ="Solo los mozos o los socios puden acceder, usted es $nuevoUser->tipo ";
					}			  


			}else{	
				$objDelaRespuesta->respuesta ="No es un Token valido";
			}		
			
			
		
		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}
		return $response; 
	}

	public function VerificarUsuario($request, $response, $next) {
		
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
	   
		
		
		if($request->isGet()|| $request->isPost() || $request->isPut() ||$request->isDelete() )
		  {
				$arrayConToken = $request->getHeader('comandaToken');
				$token=$arrayConToken[0];
				
				try 
			{
				
				login::verificarToken($token);
				$objDelaRespuesta->esValido=true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}
			if($objDelaRespuesta->esValido)
			{
				$payload= login::ObtenerPayLoad($token);
				$nuevoUser= new empleados();
				$nuevoUser= $payload->data;
					
					
						
						
						$datos = array(
							'metodo'=>$_SERVER['REQUEST_METHOD'],
							'ruta' =>$_SERVER["REDIRECT_URL"]								
						);
		
						empleados::GuardarIngreso($datos,$nuevoUser); 
						
						$response = $next($request, $response);

						  


			}else{	
				$objDelaRespuesta->respuesta ="No es un Token valido";
			}		
			
			}
			else{

				$response = $next($request, $response);
			}
		
		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}
		return $response;
		}
		


		public function VerificarSocios($request, $response, $next) {
				 
			$objDelaRespuesta= new stdclass();
			$objDelaRespuesta->respuesta="";
		   
			
			
			
					$arrayConToken = $request->getHeader('comandaToken');
					$token=$arrayConToken[0];
					
					try 
				{
					
					login::verificarToken($token);
					$objDelaRespuesta->esValido=true;      
				}
				catch (Exception $e) {      
					//guardar en un log
					$objDelaRespuesta->excepcion=$e->getMessage();
					$objDelaRespuesta->esValido=false;     
				}
				if($objDelaRespuesta->esValido)
				{
					$payload= login::ObtenerPayLoad($token);
					$nuevoUser= new empleados();
					$nuevoUser= $payload->data;
						
						if($nuevoUser->tipo=="socios")
						{
							$datos = array(
								'metodo'=>$_SERVER['REQUEST_METHOD'],
								'ruta' =>$_SERVER["REDIRECT_URL"]								
							);
			
							empleados::GuardarIngreso($datos,$nuevoUser); 
							
							$response = $next($request, $response);
	
						}		           	
						else
						{	
							$objDelaRespuesta->respuesta ="Solo los Socios puden acceder, usted es $nuevoUser->tipo ";
						}			  
	
	
				}else{	
					$objDelaRespuesta->respuesta ="No es un Token valido";
				}		
				
				
			
			if($objDelaRespuesta->respuesta!="")
			{
				$nueva=$response->withJson($objDelaRespuesta, 401);  
				return $nueva;
			}
			return $response; 
		}



		


}