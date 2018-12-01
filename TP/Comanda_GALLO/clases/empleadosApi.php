<?php
require_once 'empleados.php';
require_once 'AutentificadorJWT.php';


class empleadosApi extends empleados 
{


	public function loguearse($request, $response, $args)
	{
        $respuesta = $response;
        $objRespuesta = new stdClass();
        $respuestaStr = "Datos erroneos: ";
        
        $datos =  json_decode(json_encode($request->getParsedBody()));

        if(isset($datos->nombre))
        {           

            $elEmpleado = empleados::obtenerEmpleado($datos->nombre);

            if ($elEmpleado) 
            {
                if($datos->nombre == $elEmpleado->nombre && $datos->pass == $elEmpleado->pass)
                {

					$dato = array(
						'id'=>$elEmpleado->id,
						'nombre'=>$elEmpleado->nombre,
						'tipo' =>$elEmpleado->tipo            				
					);
                    
                    $token = AutentificadorJWT::CrearToken($dato);
					$objRespuesta->mensaje = $elEmpleado->nombre . " Logueado.";
					$objRespuesta->tipo = $elEmpleado->tipo;
                    $objRespuesta->token = $token;
                    $respuesta = $response->withHeader('token',$token);
                    $respuesta = $response->withJson( $objRespuesta, 200);
                                        
                }
                else
                {
                    if($datos->clave != $elEmpleado->clave)
                        $respuestaStr .= "Clave incorrecta. ";
                    
                    // if($datos->tipo != $elEmpleado->tipo)
                    //     $respuestaStr .= "Tipo incorrecto. ";
                    
                    $objRespuesta->error = $respuestaStr;
                    $respuesta = $response->withJson($objRespuesta,500);
                }
            }
            else
            {
                $objRespuesta->error =  "Nombre ingresado incorrecto";
                $respuesta = $response->withJson($objRespuesta, 500);
            }
        }
        else
        {
            $objRespuesta->error = "Debe informar el nombre de Empleado.";
            $respuesta = $response->withJson($objRespuesta, 500);
        }

        return $respuesta;

	}




	public function TraerUno($request, $response, $args)
	{
		$nombre = $args['nombre'];
		$elEmpleado = empleados::obtenerEmpleado($nombre);
        //var_dump($elEmpleado);
		$newResponse = $response->withJson($elEmpleado, 200);
		return $newResponse;
	}

	public function traerTodos($request, $response, $args)
	{
		$todosLosEmpleados = empleados::traerLogs();

		return $response->withJson($todosLosEmpleados,200);
	}

	public function CargarUno($request, $response, $args)
	{
		$res = new stdClass();
		$codRes = 500;
		$body = json_decode(json_encode($request->getParsedBody()));

		if (isset($body->nombre, $body->tipo, $body->pass)) 
		{
		 
        //var_dump($body);

			$nombre = $body->nombre;
			$tipo = $body->tipo;
			$pass = $body->pass;
			$estado = 'activo';

			$miEmpleado = new empleados();
			$miEmpleado->nombre=$nombre;
			$miEmpleado->tipo=$tipo;
			$miEmpleado->pass=$pass;
			$miEmpleado->estado = $estado;
			$idInsertado = $miEmpleado->InsertarUno();

			if ($idInsertado) 
				{
					$res->mensaje = "Se guardo el empleado $nombre con el id: $idInsertado";
					$codRes = 200;
				}
			else 
				$res->mensaje = "Error al  guardar el empleado";
			

		} 
		else 
			$res->mensaje = "Faltan Parametros";
		


		return $response->withJson($res,$codRes);
	}

	public function BorrarUno($request, $response, $args)
	{
		$objDelaRespuesta = new stdclass();
		$msgNro = 500;
		$body = json_decode(json_encode($request->getParsedBody()));

		if(isset($body->nombre))
		{

			$id = empleados::TraerId($body->nombre);
	
			if($id)
			{
				$cantidadDeBorrados = empleados::BorrarId($id);
				
				if ($cantidadDeBorrados) 
				{
					$objDelaRespuesta->mensaje = "Empleado $body->nombre Borrado!!!";
					$msgNro = 200;
				} 
				else 
				{
					$objDelaRespuesta->mensaje = "No Borro nada !!!";
				}
				
			}
			else
				$objDelaRespuesta->mensaje = "Usuario ". $body->nombre. " no encontrado";
		}
		else
			$objDelaRespuesta->mensaje = "Ingrese Nombre";

		return $response->withJson($objDelaRespuesta, $msgNro);;
	}

	public function ModificarUno($request, $response, $args)
	{//PUT
		$resNum = 500;
		$objDelaRespuesta = new stdclass();
		$body = json_decode(json_encode($request->getParsedBody()));

		if (isset($body->nombre, $body->estado)) 
		{

			$id = empleados::TraerId($body->nombre);

			$resultado = empleados::Modificar($id, $body->estado);
			
			if($resultado)
			{
				$objDelaRespuesta->resultado = "Empleado $body->nombre Modificado a estado $body->estado";
				$resNum = 200;
			}
			else
			$objDelaRespuesta->resultado = "No se logró modificar";
		}
		 else 
		 {
			$objDelaRespuesta->resultado = "Faltan Parametros";
		}
		return $response->withJson($objDelaRespuesta, $resNum);
	}
	

	public function traerLogsPorSector($request, $response, $args)
	{

		$todosLosEmpleados = empleados::TraerCantidadDeLogs();
		return  $response->withJson($todosLosEmpleados,200);
	}


	public function traerLogsPorEmpleado($request, $response, $args)
	{
		$todosLosEmpleados = new empleados();
		$todosLosEmpleados = empleados::TraerCantidadDeLogsPorSeparado();
		
		return  $response->withJson($todosLosEmpleados,200);

	}


	public function ingresoPorEmpleado($request, $response, $args)
	{
		$nombre = $args['nombre'];
		$res = new stdClass();
		$errorNro = 500;
		$elEmpleado = empleados::TraerCantidadPorEmpleado($nombre);

		if ($elEmpleado) 
		{
			$res = $elEmpleado;
			$errorNro = 200;
		} 
		else 
			$res->mensaje = "Error al traer logueos del empleado $nombre";

		return  $response->withJson($res,200);

	}



}