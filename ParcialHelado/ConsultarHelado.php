<?php

include_once "archivo.php";
include_once "Helado.php";
$nombreArchivo = "Helados.txt";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["sabor"]) && isset($_POST["tipo"]))
    {
        $archivo = new archivo($nombreArchivo);

        $saborTipo = strtolower($_POST["sabor"]) . "," . strtolower($_POST["tipo"]);
        if($archivo->buscar( $saborTipo))
            echo "Si hay " . $_POST["sabor"] . ", " . $_POST["tipo"];
        else
            echo "No hay " . $_POST["sabor"] . ", " . $_POST["tipo"];
    }
    else
    {
        echo "<script>alert('No configuraron todas las variables');</script>";
    }
}
else
    echo "<script>alert('ERROR: Se debe llamar con metodo POST');</script>";

?>