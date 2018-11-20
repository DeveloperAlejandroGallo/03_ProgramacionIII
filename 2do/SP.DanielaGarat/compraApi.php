<?php 

require_once 'usuario.php';
require_once 'compra.php';
require_once 'IApiCompras.php';
require_once 'AutentificadorJWT.php';

class compraApi extends compra implements IApiCompras
{
    function __construct()
    {
    }

    public function RegistrarCompra($request, $response, $args)
    {
        $body=$request->getParsedBody();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        $arrayConToken = $request->getHeader('token');
        $token=$arrayConToken[0];
        
        $emailUsuario=AutentificadorJWT::ObtenerData($token);//como lo toma del token, ya se que esta registrado
        $usuarioComprador=usuario::TraerUnUsuario($emailUsuario);

        $archivos = $request->getUploadedFiles();
        $foto= $archivos['imagen'];

        if($usuarioComprador!=NULL)
        {
            $unaCompra = new compra($body["fechaCompra"], $body["precio"], $body["modelo"], $body["marca"]);
            $insertOk=compra::InsertarCompra($unaCompra, $emailUsuario);
            if($insertOk>0)
            {
                $nuevaCarpeta="IMGCompras";
                if(!file_exists($nuevaCarpeta))
                {
                    mkdir($nuevaCarpeta);
                }
                $nuevoNombre="./$nuevaCarpeta/".$unaCompra->marca.$insertOk."celular".".jpg";
                $foto->moveTo($nuevoNombre);

                $objDelaRespuesta->respuesta="La compra se registro correctamente";
                $nueva=$response->withJson($objDelaRespuesta, 401);
            }
            else if($insertOk==0)
            {
                $objDelaRespuesta->respuesta="Ocurrió un error al registrar su compra";
                $nueva=$response->withJson($objDelaRespuesta, 401);
            }
        }
        else
        {
            $objDelaRespuesta->respuesta="Su usuario no se encuentra registrado"; 
            $nueva=$response->withJson($objDelaRespuesta, 401);  
        }
        

        return $response;
    }

    public function ArmaListaCompras($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";

        $listadoCompras=compra::TraerTodasLasCompras();//revisar como lo devuelve
        
        
        $output="";
        foreach($listadoCompras as $compra)
        {
            $output=$output. $compra['id']. "," .$compra['marca']. "," .$compra['modelo']. "," .$compra['precio']."," .$compra['fechaCompra'].",".$compra['email'].";";
        }
        
        $objDelaRespuesta->respuesta=$output;
        $nueva=$response->withJson($objDelaRespuesta, 401);
        return $response;
    }

    public function ListaPorUsuario($request, $response)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        $arrayConToken = $request->getHeader('token');
        $token=$arrayConToken[0];
        
        $emailUsuario=AutentificadorJWT::ObtenerData($token);

        $comprasDelUsuario=compra::TraerUnaCompra($emailUsuario);

        $output="";
        foreach($comprasDelUsuario as $compra)
        {
            $output=$output." ".$compra['id']. "," .$compra['marca']. "," .$compra['modelo']. "," .$compra['precio']."," .$compra['fechaCompra'].",".$compra['email'].";";
            
        }
        
        $objDelaRespuesta->respuesta=$output;
        $nueva=$response->withJson($objDelaRespuesta, 401);
        return $response;
    }

    public function ListaModelosPorMarca($request, $response)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        $arrayConToken = $request->getHeader('token');
        $token=$arrayConToken[0];

        $listadoCompras=compra::TraerTodasLasCompras();
        $output="";
        foreach($listadoCompras as $compra)
        {
            if($compra['marca']==$_GET["marca"])
            $output=$output. $compra['id']. "," .$compra['marca']. "," .$compra['modelo']. "," .$compra['precio']."," .$compra['fechaCompra'].",".$compra['email'].";";
            
        }
        
        $objDelaRespuesta->respuesta=$output;
        $nueva=$response->withJson($objDelaRespuesta, 401);
        return $response;
    }

    public function ListadoModelos($request, $response)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";
        $arrayConToken = $request->getHeader('token');
        $token=$arrayConToken[0];

        $listadoCompras=compra::TraerModelosMarcas();
        $output="";
        foreach($listadoCompras as $compra)
        {
            $output=$output. $compra['modelo']. $compra['marca']. ";";
        }

        $objDelaRespuesta->respuesta=$output;
        $nueva=$response->withJson($objDelaRespuesta, 401);
        return $response;
    }
    
}