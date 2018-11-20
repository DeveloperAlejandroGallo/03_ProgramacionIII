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
        $arrayConToken = $request->getHeader('token');
        $token=$arrayConToken[0];
        
        $nombreUsuario=AutentificadorJWT::ObtenerData($token);//como lo toma del token, ya se que esta registrado

        $unaCompra = new compra($body["nombreArticulo"], $body["fechaCompra"], $body["precio"], $nombreUsuario);
        $insertOk=compra::InsertarCompra($unaCompra);

        $archivos = $request->getUploadedFiles();
        $foto= $archivos['imagen'];
        if($insertOk>0)
        {
            $nuevaCarpeta="IMGCompras";//PARA LOS NOMBRES, VER EL TEMA DE MISMO MISMO NOMBRE, traer id con insert
            if(!file_exists($nuevaCarpeta))
            {
                mkdir($nuevaCarpeta);
            }
            $nuevoNombre="./$nuevaCarpeta/".$insertOk.$unaCompra->nombreArticulo.".jpg";
            $foto->moveTo($nuevoNombre);

            $response="La compra se registro correctamente";
        }
        else if($insertOk==0)
        {
            $response="Ocurrió un error al registrar su compra";
        }

        return $response;
    }

    public function ArmaListaCompras($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->respuesta="";

        $compras=compra::TraerTodasLasCompras();//revisar como lo devuelve
        //$objDelaRespuesta->respuesta=$compras;
        //$nueva=$response->withJson($objDelaRespuesta, 401);
        $respuesta="";
        $carpetaFotos="IMGCompras";
        $rows="";
        for($i=0;$i<count($compras);$i++)
        {
            $imagenCompra="./$carpetaFotos/".$compras[$i][0].$compras[$i][1].".jpg";
            if(file_exists($imagenCompra))
            {


                $foto = "<img src='.\\IMGCompras\\{$compras[$i][0]}{$compras[$i][1]}.jpg' alt='Foto compra ID {$compras[$i][0]}'height='100' width='100'>";
                $rows .= "<tr><td>" . $compras[$i][0] . "</td>";
                $rows .= "<td>" . $compras[$i][1] . "</td>";
                //$rows .= "<td>" . $compras[$i][2] . "</td>";
                $rows .= "<td>" . $compras[$i][3] . "</td>";
                $rows .= "<td>" . $compras[$i][4] . "</td>";
                $rows .= "<td>" . $foto . "</td></tr>";


                //$respuesta=$respuesta.$compras[$i][1].",".$compras[$i][2].",".$compras[$i][3].",".$compras[$i][4].$imagenCompra.PHP_EOL;
                //$type = 'image/jpeg';//no funciona
                //header('Content-Type:'.$type);
                //header('Content-Length: ' . filesize($imagenCompra));
                //readfile($imagenCompra);
            }
            else
            {
                $respuesta=$respuesta.$compras[$i][1].",".$compras[$i][2].",".$compras[$i][3].",".$compras[$i][4].PHP_EOL;
            }
            
        }

        $output = "<table id='tablaCompras'><tr><th>Id Compra</th><th>Articulo</th><th>Precio</th><th>Usuario</th><th>Foto</th></tr>" . $rows . "</table>";

        $objDelaRespuesta->respuesta=$output;
        $nueva=$response->withJson($objDelaRespuesta, 401);

        return $response;
    }
    
}