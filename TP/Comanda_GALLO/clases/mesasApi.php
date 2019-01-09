<?php
require_once 'mesas.php';

class mesasApi extends mesas
{
	public function TraerUno($request, $response, $args)
	{
		$codigo = $args['codigo'];
		$elmesas = mesas::TraerId($codigo);
		$newResponse = $response->withJson($elmesas, 200);
		return $newResponse;
	}


	public function TraerTodos($request, $response, $args)
	{
		$todosLosmesas = mesas::obtenerTodos();

		return $response->withJson($todosLosmesas,200);
	}


	public function CargarUno($request, $response, $args)
	{
		$body = json_decode(json_encode($request->getParsedBody()));
        //var_dump($body);
		$res = new stdClass();
		$resNro = 500;
		if (isset($body->codigo)) {
			$codigo = $body->codigo;
			$estado = "cerrada"; //la mesa nace cerrada.

			$mimesa = new mesas();
			$mimesa->codigo = $codigo;
			$mimesa->estado = $estado;
			try
			{
				$idInsertado = $mimesa->InsertarUno();
				if ($idInsertado) 
				{
					$res->mensaje = "Mesa creada";
					$res->codigo = $codigo;
					$res->id = $idInsertado;
					$resNro = 200;
				} else
					$res->error = "No se insertó la mesa";
			}
			catch (Exception $ex)
			{
				$res->error = $ex->getMessage();
			}

		} else
			$res->error = "Faltan Parametros";

		return $response->withJson($res, $resNro);
	}

	public function BorrarUno($request, $response, $args)
	{
		$body = json_decode(json_encode($request->getParsedBody()));
		$codigo = $body->codigo;

		$cantidadDeBorrados = mesas::BorrarCodigo($codigo);

		$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->cantidad = $cantidadDeBorrados;
		if ($cantidadDeBorrados > 0) 
		{
			$objDelaRespuesta->resultado = "Se Borro la mesa codigo: $codigo!!!";
		} else 
		{
			$objDelaRespuesta->resultado = "No Borro nada!!!";
		}
		$newResponse = $response->withJson($objDelaRespuesta, 200);
		return $newResponse;
	}

	public function ModificarUno($request, $response, $args)
	{
		$body = json_decode(json_encode($request->getParsedBody()));
		$token = $request->getheader('token')[0];
		$res = new stdclass();
		$resNro = 500;

		if (isset($body->codigo, $body->estado)) 
		{
			$mimesa = new mesas();
			$mimesa->codigo = $body->codigo;

			$mesa = mesas::traerUnaMesa($body->codigo);
			if ($mesa->estado != null) 
			{
				$mimesa->id = $mesa->id;
				switch ($body->estado)
				{
					case "con clientes esperando pedido":
					{
						if($mesa->estado == "cerrada")
						{
							$mimesa->estado = $body->estado;
							$resNro = 200;
						}
						break;
					}
					case "con clientes comiendo":
						{
							if ($mesa->estado == "con clientes esperando pedido") {
								$mimesa->estado = $body->estado;
								$resNro = 200;
							}
							break;
						}
					case "con clientes pagando":
						{
							if ($mesa->estado == "con clientes comiendo") {
								$mimesa->estado = $body->estado;
								$resNro = 200;
							}
							break;
						}
					case "cerrada":
						{
							//if ($mesa->estado == "con clientes pagando") 
							//{
								$payload = AutentificadorJWT::ObtenerPayLoad($token);

								$nuevoUser = new empleados();
								$nuevoUser = $payload->data;
								if($nuevoUser->tipo == "socios")
								{
									$mimesa->estado = $body->estado;
									$resNro = 200;
								}
								else
									$res->error = "Solo los socios pueden cerrar una mesa.";								
							//}
							break;
						}
				}

				if($resNro == 500)
				{
					if(!isset($res->error))
						$res->error = "No se puede pasar la mesa al estado $body->estado, porque posee el estado $mesa->estado";
				}
				else
				{
					if($mimesa->Modificarestado())
					{
						$res->mensaje = "Mesa cambiada a $mimesa->estado";
						$res->mesa = $mimesa;
					}
					else
						$res->error = "No se modifico el estado de la mesa.";
				}	
			}
			else
				$res->error = "No existe la mesa";	

		}
		else 
			$res->resultado = "Faltan Parametros";
		

		return $response->withJson($res, $resNro);
	}


}