<?php

include_once "archivo.php";
include_once "Helado.php";
$nombreArchHelado = "Helados.txt";

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET["sabor"]) && isset($_GET["precio"]) 
    && isset($_GET["tipo"])  && isset($_GET["cantidad"]))
    {
        $getSabor = strtolower($_GET["sabor"]);
        $getTipo = strtolower($_GET["tipo"]);
        $getCant = $_GET["cantidad"];
        $getPrecio = $_GET["precio"];

        $heladoNvo = new Helado($getSabor,$getTipo,$getCant,$getPrecio);
        $archivoHelados = new archivo($nombreArchHelado);
        $saborTipo = $getSabor . "," . $getTipo;
        
        if($archivoHelados->buscar($saborTipo)) #Si ya existe sobreescribo.
        {
            $listaHelados = Helado::toArray($nombreArchHelado);//Paso a lista

            $archivoHelados->createNew(); //Lo limpio para reescribir
            $i = 0;
            foreach($listaHelados as $helado)
            {
                $sabor = $helado[0];
                $tipo  = $helado[1];
                $cant  = $helado[2];
                $precio= $helado[3]; 
                $heladoLista = new Helado($sabor,$tipo,$cant,$precio);

                if($sabor.",".$tipo == $saborTipo)
                {
                    $heladoLista->cantidad = $getCant;
                    $heladoLista->precio = $getPrecio;
                }
                echo "=>". var_dump($heladoLista)."<br>";
                $archivoHelados->save($heladoLista);
            }

        }
        else
            $archivoHelados->save($heladoNvo);
        
        Helado::verStock($nombreArchHelado);
    }
    else
    {
        echo "<script>alert('No configuraron todas las variables');</script>";
    }
}
else
    echo "<script>alert('ERROR: Se debe llamar con metodo GET');</script>";

?>