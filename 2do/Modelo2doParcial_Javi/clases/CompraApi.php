<?php

class CompraApi extends Compra
{
    public function __construct()
    {
    }

    public static function IngresaCompra($request, $response)
    {
        $newResponse = $response;
        $objRespuesta = new stdclass();
        $respuestaApuntada = $objRespuesta;

        $body = $newResponse->getBody()->__toString();
        $miJsonReseponse = json_decode($body);

        if (isset($miJsonReseponse))
        {
            //existe algo en el body
            $respuestaApuntada = $miJsonReseponse;
        }
        $headerJWT = $request->getHeader('JWT');
        $miToken = $headerJWT[0];
        $data = $request->getParsedBody();
        $input = [];
        $input['articulo'] = filter_var($data['articulo'], FILTER_SANITIZE_STRING);
        $input['fecha'] = filter_var($data['fecha'], FILTER_SANITIZE_STRING);
        $input['precio'] = filter_var($data['precio'], FILTER_SANITIZE_STRING);

        if(!(isset($_FILES["foto"])))
        {
            $respuestaApuntada->Error = "Falta cargar foto";
            $newResponse = $newResponse->withJson($respuestaApuntada, 500);
            return $newResponse;
        }
        $archivos = $request->getUploadedFiles();
        $fotoSubida = $archivos["foto"];
        $nombreAnterior = $fotoSubida->getClientFilename();
        $extension = explode(".", $nombreAnterior);
        $iExt = count($extension) - 1;

        if ($extension[$iExt] == "jpg")
        {
            if(isset($data['articulo']) && isset($data['fecha']) && isset($data['precio']))
            {
                if (CompraApi::ValidaFecha($input['fecha']) && CompraApi::ValidaPrecio($input['precio']))
                {
                    $miCompra = new Compra($input['articulo'], $input['fecha'], $input['precio']);
                    try
                    {
                        $miUsuario = Usuario::TraerUno(AutentificadorJWT::ObtenerNombre($miToken));
                        Compra::InsertaCompraBase($miCompra, $miUsuario[0]['ROW_ID']);
                        $respuestaApuntada->Result = "La compra se ingreso correctamente";
                        $newResponse = $newResponse->withJson($respuestaApuntada, 200);
                    }
                    catch (Exception $e)
                    {
                        $respuestaApuntada->Error = "Token invalido";
                        return $newResponse->withJson($respuestaApuntada, 500);
                    }

                    if($fotoSubida->getError() === UPLOAD_ERR_OK)
                    {
                        $pathImagen = ".\\IMGCompras\\{$miCompra->id}{$miCompra->articulo}.{$extension[$iExt]}";
                        move_uploaded_file($_FILES["foto"]["tmp_name"], $pathImagen);

                        $respuestaApuntada->Result .= ". La foto se cargo correctamente";
                        $newResponse = $newResponse->withJson($respuestaApuntada, 200);
                    }
                }
                else
                {
                    $respuestaApuntada->Error = "Fecha y/o precio incorrectos";
                    $newResponse = $newResponse->withJson($respuestaApuntada, 500);
                } 
            }
            else
            {
                $respuestaApuntada->Error = "Faltan setear parametros";
                $newResponse = $newResponse->withJson($respuestaApuntada, 500);
            }
        }
        else
        {
            $respuestaApuntada->Error = "La foto solo puede ser de formato .jpg";
            $newResponse = $newResponse->withJson($respuestaApuntada, 500);
        }

        return $newResponse;
    }

    public static function ListadoCompras($request, $response)
    {
        $newResponse = $response;
        $objRespuesta = new stdclass();
        $respuestaApuntada = $objRespuesta;
        $headerJWT = $request->getHeader('JWT');
        $miToken = $headerJWT[0];
        $sqltxt = "";

        $body = $newResponse->getBody()->__toString();
        $miJsonReseponse = json_decode($body);

        if (isset($miJsonReseponse))
        {
            //existe algo en el body
            $respuestaApuntada = $miJsonReseponse;
        }

        $miUsuario = Usuario::TraerUno(AutentificadorJWT::ObtenerNombre($miToken));
        $listado = Compra::TraerCompras($miUsuario);
        
        $output = "";

        if(count($listado) > 0)
        {
            $rows = "";
            
            foreach($listado as $compra)
            {
                $foto = "<img src='.\\IMGCompras\\{$compra['ROW_ID']}{$compra['articulo']}.jpg' alt='Foto compra ID {$compra['ROW_ID']}'height='100' width='100'>";
                $rows .= "<tr><td>" . $compra['ROW_ID'] . "</td>";
                $rows .= "<td>" . $compra['articulo'] . "</td>";
                $rows .= "<td>" . $compra['precio'] . "</td>";
                $rows .= "<td>" . $compra['nombre'] . "</td>";
                $rows .= "<td>" . $foto . "</td></tr>";
            }
            $output = "<table id='tablaCompras'><tr><th>Id Compra</th><th>Articulo</th><th>Precio</th><th>Usuario</th><th>Foto</th></tr>" . $rows . "</table>";
        
            $respuestaApuntada->Listado = $output;
            $newResponse = $newResponse->withJson($respuestaApuntada, 200);
        }
        else
        {
            $respuestaApuntada->Listado = "No existen compras ingresadas";
            $newResponse = $newResponse->withJson($respuestaApuntada, 200);
        }

        return $newResponse;
    }

    

    public static function ValidaFecha($fecha)
    {
        $output = false;
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]))
        {
            $output = true;
        }
        return $output;
    }

    public static function ValidaPrecio($precio)
    {
        $output = false;

        if(is_numeric($precio))
        {
            $output = true;
        }
        
        return $output;  
    }

}



?>