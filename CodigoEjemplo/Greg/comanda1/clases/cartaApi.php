<?php

require_once 'IApiUsable1.php';
require_once 'carta.php';


class cartaApi extends carta implements IApiUsable1
{


    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
       
   if(isset($ArrayDeParametros['id'],$ArrayDeParametros['descripcion'],$ArrayDeParametros['precio'],$ArrayDeParametros['sector']))
   {
        $id= $ArrayDeParametros['id'];
       if( carta::verificarArticulo($id) == false){

           $descripcion= $ArrayDeParametros['descripcion'];
           $precio= $ArrayDeParametros['precio'];
           $sector= $ArrayDeParametros['sector'];
           
           $miArticulo = new carta();
           $miArticulo->id=$id;
           $miArticulo->descripcion=$descripcion;
           $miArticulo->precio=$precio;
           $miArticulo->sector=$sector;
           $respuesta = $miArticulo->InsertarUno();
           
           if($response !=""){
               $response = "se guardo el articulo con el id $id";
           }else{
               $response = "Error al  guardar el articulo";
           }
       
        }
        else
        {
            $response = "El id esta duplicado";
        } 
       
               
       

   }else{
       $response = "Faltan Parametros";
   }


       return $response;
   }

   public function BorrarUno($request, $response, $args) {
    $ArrayDeParametros = $request->getParsedBody();
    
    $id=$ArrayDeParametros['id'];   
    if( carta::verificarArticulo($id) == true){
    
    $cantidadDeBorrados=carta::BorrarId($id);

    $objDelaRespuesta= new stdclass();
  // $objDelaRespuesta->cantidad=$cantidadDeBorrados;
   if($cantidadDeBorrados)
       {
            $objDelaRespuesta->resultado="Se Borro el id: $id!!!";
            
       }
       else
       {
           $objDelaRespuesta->resultado="no Borro nada !!!";
       }


    }else
    {
        $objDelaRespuesta->resultado = "El id no existe";
    } 


   $newResponse = $response->withJson($objDelaRespuesta, 200);  
   
     return $newResponse;
}


public function ModificarUno($request, $response, $args) {
    //$response->getBody()->write("<h1>Modificar  uno</h1>");
    $ArrayDeParametros = $request->getParsedBody();
   //var_dump($ArrayDeParametros);  
   $objDelaRespuesta= new stdclass(); 
if(isset($ArrayDeParametros['id'],$ArrayDeParametros['precio']))
{
   
   $miArticulo = new carta();
   $id=$ArrayDeParametros['id'];
   $miArticulo->precio=$ArrayDeParametros['precio'];
   $miArticulo->id=$id;
   if( carta::verificarArticulo($id) == true){           

      $resultado =$miArticulo->ModificarUno();
      $objDelaRespuesta= new stdclass();
   //var_dump($resultado);
   $objDelaRespuesta->resultado=$resultado;
   }else
   {
    $objDelaRespuesta->resultado = "el id no existe"; 
   }

}else{
   $objDelaRespuesta->resultado = "Faltan Parametros";
}	
   return $response->withJson($objDelaRespuesta, 200);		
}





   public function TraerTodos($request, $response, $args) {
    $articulos= array();
    $tabla; 
    
    $articulos=carta::TraerTodosLosArticulos();

     if($articulos != null){
                
        $tabla = "<table width='70%' border='1px' align='center'><tr align='center'><th>Id</th><th>Descripcion</th><th>Precio</th><th>Sector</th>";    
        foreach($articulos as $art ) {
            
           
           $tabla .="<tr align='center'><td>$art->id</td><td>$art->descripcion</td><td>$art->precio</td><td>$art->sector</td></tr>";
                  
        } 
    }
    $todosLosArticulos= $tabla;
    
    $response->getBody()->write($todosLosArticulos);
    return $response;
}





}