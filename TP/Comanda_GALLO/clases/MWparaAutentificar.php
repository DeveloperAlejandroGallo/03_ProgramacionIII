<?php

require_once 'AutentificadorJWT.php';

class MWparaAutentificar
{

	public function VerificarMozos($request, $response, $next)
	{

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";

		$token = $request->getHeader('token')[0];

		try {

			AutentificadorJWT::verificarToken($token);
			$objDelaRespuesta->esValido = true;
		} catch (Exception $e) {      
			//guardar en un log
			$objDelaRespuesta->excepcion = $e->getMessage();
			$objDelaRespuesta->esValido = false;
		}
		if ($objDelaRespuesta->esValido) {
			$payload = AutentificadorJWT::ObtenerPayLoad($token);
			$nuevoUser = new empleados();
			$nuevoUser = $payload->data;

			if ($nuevoUser->tipo == "mozos" || $nuevoUser->tipo == "socios") 
			{
				$datos = array(
					'metodo' => $_SERVER['REQUEST_METHOD'],
					'ruta' => $_SERVER["REDIRECT_URL"]
				);

				empleados::GuardarIngreso($datos, $nuevoUser);

				$response = $next($request, $response);

			} else {
				$objDelaRespuesta->respuesta = "Solo los mozos o los socios puden acceder, usted es $nuevoUser->tipo ";
			}


		} else {
			$objDelaRespuesta->respuesta = "No es un Token valido";
		}



		if ($objDelaRespuesta->respuesta != "") {
			$nueva = $response->withJson($objDelaRespuesta, 401);
			return $nueva;
		}
		return $response;
	}

	public function VerificarUsuario($request, $response, $next)
	{

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";



		if ($request->isGet() || $request->isPost() || $request->isPut() || $request->isDelete()) {
			$token = $request->getHeader('token')[0];

			try {

				AutentificadorJWT::verificarToken($token);
				$objDelaRespuesta->esValido = true;
			} catch (Exception $e) {      
		//guardar en un log
				$objDelaRespuesta->excepcion = $e->getMessage();
				$objDelaRespuesta->esValido = false;
			}
			if ($objDelaRespuesta->esValido) {
				$payload = AutentificadorJWT::ObtenerPayLoad($token);
				$nuevoUser = new empleados();
				$nuevoUser = $payload->data;

				$datos = array(
					'metodo' => $_SERVER['REQUEST_METHOD'],
					'ruta' => $_SERVER["REDIRECT_URL"]
				);

				empleados::GuardarIngreso($datos, $nuevoUser);

				$response = $next($request, $response);




			} else {
				$objDelaRespuesta->respuesta = "No es un Token valido";
			}

		} else {

			$response = $next($request, $response);
		}

		if ($objDelaRespuesta->respuesta != "") {
			$nueva = $response->withJson($objDelaRespuesta, 401);
			return $nueva;
		}
		return $response;
	}



	public function VerificarSocios($request, $response, $next)
	{

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->respuesta = "";

		$token = $request->getHeader('token')[0];

		try 
		{
			AutentificadorJWT::verificarToken($token);
			$objDelaRespuesta->esValido = true;
		} 
		catch (Exception $e) 
		{      
			//guardar en un log
			$objDelaRespuesta->excepcion = $e->getMessage();
			$objDelaRespuesta->esValido = false;
		}

		if ($objDelaRespuesta->esValido) 
		{
			$payload = AutentificadorJWT::ObtenerPayLoad($token);
			$nuevoUser = new empleados();
			$nuevoUser = $payload->data;

			if ($nuevoUser->tipo == "socios") {
				$datos = array(
					'metodo' => $_SERVER['REQUEST_METHOD'],
					'ruta' => $_SERVER["REDIRECT_URL"]
				);

				empleados::GuardarIngreso($datos, $nuevoUser);

				$response = $next($request, $response);

			} 
			else 
			{
				$objDelaRespuesta->respuesta = "Solo los Socios puden acceder, usted es $nuevoUser->tipo ";
			}


		} 
		else 
		{
			$objDelaRespuesta->respuesta = "No es un Token valido";
		}

		if ($objDelaRespuesta->respuesta != "") 
		{
			$nueva = $response->withJson($objDelaRespuesta, 401);
			return $nueva;
		}
		return $response;
	}






}