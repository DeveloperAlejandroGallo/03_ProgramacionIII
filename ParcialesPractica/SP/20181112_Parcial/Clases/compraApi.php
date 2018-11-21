<?php
require_once 'compra.php';

class compraApi extends compra 
{
    public function altaCompra($request, $response, $args)
    {
        $micompra = new compra();
        $res = new stdclass();
        $codRespuesta = 402;

        $token = $request->getHeader('token')[0];

        $body =  json_decode(json_encode($request->getParsedBody()));
        //var_dump($body);
        $idUsuario = AutentificadorJWT::ObtenerData($token)->email;

        if(isset($idUsuario)&&isset($body->marca)&&isset($body->modelo)&&isset($body->fecha)&&isset($body->precio))
        {

            
            $micompra->idUsuario = $idUsuario;
            $micompra->marca = $body->marca;
            $micompra->modelo = $body->modelo;
            $micompra->fecha = $body->fecha;
            $micompra->precio = $body->precio;
            $id = $micompra->InsertarCompra(); 
            if(isset($id))
            {
                $archivos = $request->getUploadedFiles();
                $destino="./IMGCompras/";
                $res->variableArchivo = json_decode(json_encode($archivos));
                #TITULO
                $titulo = $id . '_' . $idUsuario;
                
                if(isset($archivos['foto']))
                {
                    $idAnterior=$archivos['foto']->getClientFilename();
                    $extension= explode(".", $idAnterior)  ;
                    //var_dump($idAnterior);
                    $extension=array_reverse($extension);
                    $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
                }       
                $res->respuesta = "Se guardo la compra $id.";
                $codRespuesta = 200;
            }
            else
            {
                $res->respuesta = "Error al insertar.";
            }
        }
        else
        {
            $res->respuesta = "Parametros incorrectos.";
        }

        return $response->withJson($res, $codRespuesta);
    }




    public function listarCompras($request, $response)
    {//post
        
       
        $token = $request->getHeader('token')[0];//Acaa ya sabemos que el toqken es valido por el MW que valida usr
        $data = AutentificadorJWT::ObtenerData($token);
        if($data->perfil=="admin")
        {
            $compras = compra::TraerTodasLasCompras();
        }
        else
        {
            $compras = compra::TraerTodasLasComprasUnUsr($data->email);
        }

        return $response->withJson($compras, 200);

    }

    public function listarModelosMarca($request, $response, $args)
    {//post
        
        $obj = new stdClass();
        $res = $response;
        $token = $request->getHeader('token')[0];//Acaa ya sabemos que el toqken es valido por el MW que valida usr
        $data = AutentificadorJWT::ObtenerData($token);
        if($data->perfil=="admin")
        {
            if(isset($args['marca']))
            {
                $compras = compra::TraerModelosMarca($args['marca']);
                $res = $response->withJson($compras, 200);
            }
            else
            {
                $obj->error = "Debe ingresar una marca";
                $res = $response->withJson($obj, 501); 
            }
        }
        else
        {
            $obj->error = "Debe ser Administrador";
            $res = $response->withJson($obj, 501); 
        }

        return $res;
    }


    public function productosVendidos($request, $response, $args)
    {//post
        
        $obj = new stdClass();
        $res = $response;
        $compras = compra::TraerProdVendidos();
        $res = $response->withJson($compras, 200);

        return $res;
    }



}