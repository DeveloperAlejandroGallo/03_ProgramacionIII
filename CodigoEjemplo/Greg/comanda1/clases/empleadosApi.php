<?php
require_once 'empleados.php';
require_once 'IApiUsable.php';
require_once 'login.php';


class empleadosApi extends empleados implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
		
		
		 $id=$args['id'];        
        $elEmpleado=empleados::TraerId($id);
        //var_dump($elEmpleado);
     	$newResponse = $response->withJson($elEmpleado, 200);  
    	return $newResponse;
    }
	
	public function TraerTodos($request, $response, $args) {
      	$todosLosEmpleados=empleados::traerTodos();
		$newResponse= empleados::GenerarTabla($todosLosEmpleados); 
		$response->getBody()->write($newResponse);
        return $response;
    }
	
	
	public function CargarUno($request, $response, $args) {
		 $ArrayDeParametros = $request->getParsedBody();
		
	if(isset($ArrayDeParametros['nombre'],$ArrayDeParametros['tipo'],$ArrayDeParametros['pass'],$ArrayDeParametros['estado']))
	{
		 
        //var_dump($ArrayDeParametros);
				
		$nombre= $ArrayDeParametros['nombre'];
        $tipo= $ArrayDeParametros['tipo'];
		$pass= $ArrayDeParametros['pass'];
		$estado= $ArrayDeParametros['estado'];
		
		$miEmpleado = new empleados();
		$miEmpleado->setnombre($nombre);
		$miEmpleado->settipo($tipo);
		$miEmpleado->setpass($pass);
		$miEmpleado->estado=$estado;
		$respuesta = $miEmpleado->InsertarUno();
        
		if($response !=""){
			$response = "se guardo el empleado con el id $respuesta";
		}else{
			$response = "Error al  guardar el empleado";
		}

	}else{
		$response = "Faltan Parametros";
	}


        return $response;
    }
	  
	public function BorrarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
		 $id=$ArrayDeParametros['id'];   
		 	     	
     	$cantidadDeBorrados=empleados::BorrarId($id);

     	$objDelaRespuesta= new stdclass();
	   // $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados)
	    	{
				 $objDelaRespuesta->resultado="algo borro!!!";
				 
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada !!!";
	    	}
		$newResponse = $response->withJson($objDelaRespuesta, 200);  
		
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
		//var_dump($ArrayDeParametros);   
	if(isset($ArrayDeParametros['id'],$ArrayDeParametros['estado']))
	{
		
	    $miEmpleado = new empleados();
	    $id=$ArrayDeParametros['id'];
		$miEmpleado->estado=$ArrayDeParametros['estado'];
	    		

	   	$resultado =$miEmpleado->ModificarUno($id);
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;

	}else{
		$objDelaRespuesta->resultado = "Faltan Parametros";
	}	
		return $response->withJson($objDelaRespuesta, 200);		
	}
	
	/////
	// --------------LOGIn

	public function verificar($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
	  //var_dump($ArrayDeParametros);
	  $nombre= $ArrayDeParametros['nombre'];
	  $pass= $ArrayDeParametros['pass'];
	  $miLogin = empleados::verificarlogin($nombre,$pass);
	  
	  $response->getBody()->write($miLogin);


        return $response;
	}


	public function traerLogs($request, $response, $args) {
		$todosLosEmpleados=empleados::traerLogs();
		$newResponse=empleados::GenerarTablaLogs($todosLosEmpleados);
	   
	  	$response->getBody()->write($newResponse);
        return $response;
  }


public function traerLogsPorSector($request, $response, $args) {
	
	$todosLosEmpleados=empleados::TraerCantidadDeLogs();
	$newResponse=empleados::GenerarTablaCantidadDeLogs($todosLosEmpleados);
   
	  $response->getBody()->write($newResponse);
	return $response;
}


public function traerLogsPorEmpleado($request, $response, $args) {
	$todosLosEmpleados= new empleados();
	$todosLosEmpleados=empleados::TraerCantidadDeLogsPorSeparado();
	$newResponse=empleados::GenerarTablaCantidadDeLogsPorSeparado($todosLosEmpleados);
   
	  $response->getBody()->write($newResponse);
	return $response;
	//$newResponse=$todosLosEmpleados;
	//return $response->withJson($newResponse, 200);
}




public function traerUnLog($request, $response, $args){
	$id=$args['id']; 
		$elEmpleado=  new empleados();       
        $elEmpleado=empleados::TraerCantidadPorEmpleado($id);
        if($elEmpleado->nombre != null){
			$newResponse= empleados::GenerarTablaPorEmpleado($elEmpleado);
			//$newResponse=$elEmpleado;
		}else{
			$newResponse="Error al traer el empleado";
		}

		$response->getBody()->write($newResponse);
		return $response;
		//return $response->withJson($newResponse, 200);
  }



}