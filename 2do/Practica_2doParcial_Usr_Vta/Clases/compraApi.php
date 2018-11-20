<?php
require_once 'compra.php';

class compraApi extends compra 
{
    public function altaCompra($request, $response, $args)
    {#Post
        $micompra = new compra();
        $res = new stdclass();
        $codRespuesta = 402;

        $token = $request->getHeader('token')[0];

        $body =  json_decode(json_encode($request->getParsedBody()));
        //var_dump($body);
        $idUsuario = AutentificadorJWT::ObtenerData($token)->nombre;

        if(isset($idUsuario)&&isset($body->articulo)&&isset($body->fecha)&&isset($body->precio))
        {
            $res->usuario = $idUsuario;
            $micompra->usuarioNombre = $idUsuario;
            $micompra->articulo = $body->articulo;
            $micompra->fecha = $body->fecha;
            $micompra->precio = $body->precio;
            try
            {
                $id = $micompra->InsertarCompra(); 

                if(isset($id))
                {
                    $res->respuesta = "Se guardo la compra $id.";
                    $codRespuesta = 200;
                    #TITULO
                    $titulo = $id . '_' . $idUsuario;
                    $this->guardarArchivoSubido($request,$titulo,$res);
                }
                else
                {
                    $res->respuesta = "Error al insertar.";
                }


            }
            catch(Exception $ex)
            {
                $res->respuesta = "Error al insertar compra (".$ex->getMessage().")";
            }

        }
        else
        {
            $res->respuesta = "Parametros incorrectos.";
        }

        return $response->withJson($res, $codRespuesta);
    }

    private function guardarArchivoSubido($request,$titulo,$res)
    {
        $archivos = $request->getUploadedFiles();
        $destino="./IMGCompras/";
        $res->variableArchivo = json_decode(json_encode($archivos));
                
        if(isset($archivos['foto']))
        {
            $idAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $idAnterior)  ;
            //var_dump($idAnterior);
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
            $res->rutaDestino = $destino.$titulo.".".$extension[0];
        } 
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
            $compras = compra::TraerTodasLasComprasUnUsr($data->nombre);
        }

        return $response->withJson($compras, 200);

    }

    public function listarModelosarticulo($request, $response, $args)
    {//post
        
        $obj = new stdClass();
        $res = $response;
        $token = $request->getHeader('token')[0];//Acaa ya sabemos que el toqken es valido por el MW que valida usr
        $data = AutentificadorJWT::ObtenerData($token);
        if($data->perfil=="admin")
        {
            if(isset($args['articulo']))
            {
                $compras = compra::TraerModelosarticulo($args['articulo']);
                $res = $response->withJson($compras, 200);
            }
            else
            {
                $obj->error = "Debe ingresar una articulo";
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