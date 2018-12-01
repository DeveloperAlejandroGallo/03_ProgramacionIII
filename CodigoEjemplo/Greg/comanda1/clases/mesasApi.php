<?php
require_once 'mesas.php';
require_once 'IApiUsable.php';

class mesasApi extends mesas implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$elmesas=mesas::TraerId($id);
     	$newResponse = $response->withJson($elmesas, 200);  
    	return $newResponse;
    }
	
	
	public function TraerTodos($request, $response, $args) {
      	$todosLosmesass=mesas::traerTodos();
		$newResponse=mesas::GenerarTabla($todosLosmesass); 
		$response->getBody()->write($newResponse);
        return $response;
    }
	
	
	public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
	   
		if(isset($ArrayDeParametros['numero']))
	{
		$numero= $ArrayDeParametros['numero'];
        $estado= "con cliente esperando pedido";
               
        $mimesa = new mesas();
		$mimesa->id= $numero;
		$mimesa->estado=$estado;
               
        $respuesta=  $mimesa->InsertarUno();

      
		$response->getBody()->write($respuesta);
	}else{
		$response->getBody()->write("Faltan Parametros");
	}

        return $response;
    }
      public function BorrarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['id'];
     	
     	$cantidadDeBorrados=mesas::BorrarId($id);

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="Se Borro el id: $id!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
		//var_dump($ArrayDeParametros);    	
		$objDelaRespuesta= new stdclass();
		
	if(isset($ArrayDeParametros['numero']))
	{
		$mimesa = new mesas();
	    $mimesa->id=$ArrayDeParametros['numero'];	    
	    $mimesa->estado="con clientes pagando";
		
		$dato =mesas::verificarMesa($mimesa->id);
	if($dato !=null){

		if(pedidos::CerrarPedido($mimesa->id)){

			$modificacion =$mimesa->Modificarestado();
			
			if($modificacion!=null){
				$objDelaRespuesta->resultado="El nuevo estado es: $mimesa->estado";
			}else{
				$objDelaRespuesta->resultado="No se pudo cambiar el estado";
			}

		}else{
			$objDelaRespuesta->resultado= "La mesa $mimesa->id todavia tiene pedidos pendientes o esta cerrada ";
		}	
	   
		
		
		

	}else{
		$objDelaRespuesta->resultado="El id ingresado es inexistente";
	}

	
	}else{
		$objDelaRespuesta->resultado="Faltan Parametros";
	}

	
		return $response->withJson($objDelaRespuesta, 200);		
    }


}