<?php

require_once 'IApiUsable.php';
require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';

class pedidosApi extends pedidos implements IApiUsable
{


    public function CargarUno($request, $response, $args) {
   
        $arrayConToken = $request->getHeader('comandaToken');
        $token=$arrayConToken[0];
        $payload= login::ObtenerPayLoad($token);
                            
        $nuevoUser= new empleados();
        $nuevoUser= $payload->data;


        //si soy mozo cargo un pedido nuevo
    if( $nuevoUser->tipo == "socios" ||$nuevoUser->tipo == "mozos" ){    
   
   
    $ArrayDeParametros = $request->getParsedBody();
       
   
   
    if(isset($ArrayDeParametros['cliente'],$ArrayDeParametros['mesa'],$ArrayDeParametros['idArticulo'],$ArrayDeParametros['cantidad']))
   {
        
    
       //var_dump($ArrayDeParametros);
       $datetime_now = date("Y-m-d H:i:s");
       $idEmpleado=$nuevoUser->id;       
       $cliente= $ArrayDeParametros['cliente'];
       $mesa= $ArrayDeParametros['mesa'];
       $idArticulo= $ArrayDeParametros['idArticulo'];
       $cantidad= $ArrayDeParametros['cantidad'];
       
    if( carta::verificarArticulo($idArticulo))
    {


       
       $miPedido = new pedidos();

       //verifico si la mesa ya esta siendo cargda
       $verificacion=pedidos::verificarPedido($mesa);
       if($verificacion != null)
       {
        $miPedido->codigo = $verificacion;
       }else{
        $miPedido->codigo= pedidos::GenerarCodigo($mesa);
       }

       
       $miPedido->idEmpleado=$idEmpleado;
       $miPedido->cliente=$cliente;
       $miPedido->mesa= $mesa;
       $miPedido->idArticulo= $idArticulo;
       $miPedido->cantidad=$cantidad;
       $miPedido->estado="pendiente";
       $miPedido->horaInicio= $datetime_now;
       $miPedido->importe= carta::CalcularImporte($idArticulo,$cantidad);

       //cambio estado de mesa y genero codigo
       
       $mimesa = new mesas();
       $mimesa =mesas:: TraerId($mesa);
       $codigoMesa= $mimesa->codigo;

       if($mimesa->estado != "con cliente esperando pedido"){
        $mimesa->estado="con cliente esperando pedido";              
        $mimesa->Modificarestado();
       }
      
       

    //foto
       $archivos = $request->getUploadedFiles();
       $destino="./fotos/";
       //var_dump($archivos);
       //var_dump($archivos['foto']);
       if(isset($archivos['foto']))
       {   
           $nombrefoto=$cliente."_".$mesa;
           
           $nombreAnterior=$archivos['foto']->getClientFilename();
           $extension= explode(".", $nombreAnterior)  ;
           //var_dump($nombreAnterior);
           $extension=array_reverse($extension);
           $archivos['foto']->moveTo($destino.$nombrefoto.".".$extension[0]);
           $miPedido->foto = $nombrefoto.".".$extension[0];
       }else{
           $nombrefoto="sin foto";
           $miPedido->foto = $nombrefoto;
       }


       $respuesta = $miPedido->InsertarUno();


       
       if($response !=""){
           $response = "se guardo el pedido con el codigo $miPedido->codigo, $codigoMesa";
       }else{
           $response = "Error al  guardar el pedido";
       }

    }else{
        $response = "Articulo Inexistente: $idArticulo";
    }

    
   }else{
       $response = "Faltan Parametros";
   }

}else{
    ///si soy bartender,cocinero o cervecero puedo tomar el pedido para preparlo

    $ArrayDeParametros = $request->getParsedBody();
   


if(isset($ArrayDeParametros['idPedido'],$ArrayDeParametros['estimado']))
{
    $id= $ArrayDeParametros['idPedido'];
    $estimado=$ArrayDeParametros['estimado'];

    if(pedidos::Consultar($id,$nuevoUser->tipo)){
        $miPedido = new pedidos();
        $miPedido->estado="en preparacion";
        $miPedido->id=$id;
        $miPedido->estimado= $estimado;
        $miPedido->idEmpleado= $nuevoUser->id;

       if( $miPedido->TomarPedido()){
           $response = "El pedido se tomo correctamente";
       }else{
        $response = "Error al tomar el pedido";
       }
    
    }else{
        $response = "El pedido no se  puede tomar";
    }


}else{
    $response = "Faltan Parametros";
}

}
       return $response;
   }
     

public function ModificarUno($request, $response, $args) {
    //$response->getBody()->write("<h1>Modificar  uno</h1>");
    $arrayConToken = $request->getHeader('comandaToken');
    $token=$arrayConToken[0];
    $payload= login::ObtenerPayLoad($token);
                        
    $nuevoUser= new empleados();
    $nuevoUser= $payload->data;

    $objDelaRespuesta= new stdclass();
    $ArrayDeParametros = $request->getParsedBody();
   
    //si soy mozo cargo un pedido nuevo

if(isset($ArrayDeParametros['idPedido']))
{
    $id=$ArrayDeParametros['idPedido'];

if( $nuevoUser->tipo == "bartender" ||$nuevoUser->tipo == "cerveceros"||$nuevoUser->tipo == "cocineros" )
{      
    
   
   //var_dump($ArrayDeParametros);   

    
    if(pedidos::ConsultarTipo($id,$nuevoUser->tipo)){
        $miPedido = new pedidos();
        $miPedido->estado="listo para servir";
        $miPedido->id=$id;
        $miPedido->idEmpleado= $nuevoUser->id;
        $miPedido->horaFin= date("Y-m-d H:i:s");
       
        if( $miPedido->PedidoTerminado()){

           $respuesta = "El pedido se modifico correctamente";
       }else{
        $respuesta = "Error al cambiar el pedido";
       }
    
    }else{
        $respuesta= "El pedido no se  puede cambiar";
    }
   
  //var_dump($resultado);
  

}elseif( $nuevoUser->tipo == "mozos"){

    $miPedido = new pedidos();
        $miPedido->estado="entregado";
        $miPedido->id=$id;
        $miPedido->idEmpleado= $nuevoUser->id;
    if(pedidos::ConsultarEstado($id,"listo para servir"))
    {
        
        if( $miPedido->PedidoEntregado()){
            $pedido= pedidos::TraerId($id);
            mesas::ModificarMesa($pedido->mesa,"con clientes comiendo");
            $respuesta = "El pedido se entrego correctamente";
        }else{
         $respuesta = "Error al cambiar el pedido";
        }
        
    }else{
        $respuesta= "El pedido no esta listo";
    }

}

$objDelaRespuesta->resultado=$respuesta;
  		
}else{
    $objDelaRespuesta->resultado = "Faltan Parametros";
 }	

return $response->withJson($objDelaRespuesta, 200);

}


   public function TraerTodos($request, $response, $args) {

    $arrayConToken = $request->getHeader('comandaToken');
     $token=$arrayConToken[0];
     $payload= login::ObtenerPayLoad($token);
                         
     $nuevoUser= new empleados();
     $nuevoUser= $payload->data;
     if( $nuevoUser->tipo == "socios" ||$nuevoUser->tipo == "mozos" ){         
        $fecha= date("Y-m-d");
        $pedidos=pedidos::traerTodos($fecha);
        $todosLosPedidos=pedidos::GenerarTabla($pedidos,$nuevoUser->tipo);
     }else{
        $fecha= date("Y-m-d");
        $pedidos=pedidos::TraerPedidosSector($nuevoUser->tipo,$fecha);
        $todosLosPedidos=pedidos::GenerarTabla($pedidos,$nuevoUser->tipo);
    }

    $response->getBody()->write($todosLosPedidos);
    return $response;
  
}


public function TraerUno($request, $response, $args) {		
		
    $id=$args['id'];        
    $elPedido=pedidos::TraerId($id);
   //var_dump($elEmpleado);
    $newResponse = $response->withJson($elPedido, 200);  
   return $newResponse;
}


public function BorrarUno($request, $response, $args) {
    
    $arrayConToken = $request->getHeader('comandaToken');
    $token=$arrayConToken[0];
    $payload= login::ObtenerPayLoad($token);
                        
    $nuevoUser= new empleados();
    $nuevoUser= $payload->data;
      
    $ArrayDeParametros = $request->getParsedBody();
    $id=$ArrayDeParametros['id'];   
    
    $miPedido = new pedidos();
    $miPedido->estado="cancelado";
    $miPedido->id=$id;
    $miPedido->idEmpleado= $nuevoUser->id;

    if( $miPedido->PedidoCancelado()){
        $respuesta = "El pedido se cancelo correctamente";
    }else{
     $respuesta = "Error al cancelar el pedido";
    }      

    $objDelaRespuesta= new stdclass(); 
    $objDelaRespuesta->resultado= $respuesta;     
    $newResponse = $response->withJson($objDelaRespuesta, 200);  
   
    return $newResponse;
}

///Consulto el tiempo que falta para el pedido

public function tiempoPedido($request, $response, $args) {
    $ArrayDeParametros = $request->getParsedBody();

    if(isset($ArrayDeParametros['codigoPedido'],$ArrayDeParametros['codigoMesa']))
	{   $pedidos= new pedidos();
        $codigoMesa= $ArrayDeParametros['codigoMesa'];
        $codigoPedido= $ArrayDeParametros['codigoPedido'];
        $pedidos =  pedidos::CalcularTiempo($codigoPedido,$codigoMesa);
        $newResponse = pedidos::GenerarTablaTiempo($pedidos);
      

    }else{
        $respuesta = "Faltan Parametros";

    }
    $response->getBody()->write($newResponse);
     return  $response;
    
    
    }


}




?>