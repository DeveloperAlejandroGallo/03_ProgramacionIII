<?php
#includes
include_once "archivo.php";
include_once "Helado.php";
include_once "Venta.php";
###############

$nombreArchHelados = "Helados.txt";
$nombreArchVentas = "Ventas.txt";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["sabor"]) && isset($_POST["tipo"])
    && isset($_POST["email"]) && isset($_POST["cantidad"]))
    {
        $archivoHelados = new archivo($nombreArchHelados);
        $email = $_POST["email"];
        $cantVta = $_POST["cantidad"];
        $saborTipo = strtolower($_POST["sabor"]) . "," . strtolower($_POST["tipo"]);

        if($archivo->buscar($saborTipo))
        {
            
            $listaHelados = Helado::toArray($archivoHelados);//Paso a lista
            $archivoHelados->createNew(); //Lo limpio para reescribir
            $i = 0;
            foreach($listaHelados as $helado)
            {
                $sabor = $helado[0];
                $tipo  = $helado[1];
                $cant  = $helado[2];
                $precio= $helado[3]; 
                $helado = new Helado($sabor,$tipo,$cant,$precio);

                if($sabor.",".$tipo == $saborTipo)
                {
                    if($cant >= $cantVta)
                    {
                        $helado->cantidad = $cant - $cantidad;
                        //solo guardo la venta si alcanzó
                        $venta = new Venta($email,$saborTipo,$cantVta);
                        $archivoVentas = new archivo($nombreArchVentas);
                        $archivoVentas->save($venta);

                    }
                    else    
                        echo "<script>alert('No alcanza el helado');</script>";
                }

                $archivo->save($helado);
                $i++;

            }
        }
    }
    else
    {
        echo "<script>alert('No configuraron todas las variables');</script>";
    }
}
?>