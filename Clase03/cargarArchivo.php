<?php 

$nombre = "";
$apellido = "";
$legajo = "";
$separador = ";";
$grabar = false;
$nombreArchivo="alumnos.csv";

switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST":
    {
        if(!ISSET($_POST["nombre"]) || !ISSET($_POST["apellido"]) ||!ISSET($_POST["legajo"]) )
        {   
            echo "FALTAN CONFIGURAR VARIABLES"; 
            break;
        }
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $legajo= $_POST["legajo"];
        $grabar = true;
    }
    break;
    case "GET":
    {
        if(!ISSET($_GET["nombre"]) || !ISSET($_GET["apellido"]) ||!ISSET($_GET["legajo"]) )
        {   
            echo "FALTAN CONFIGURAR VARIABLES"; 
            break;
        }
        $nombre = $_GET["nombre"];
        $apellido = $_GET["apellido"];
        $legajo= $_GET["legajo"];        
        $grabar = true;
    }
    break;
    case "PUT":
    {

    }
    break;   
    case "DELETE":
    {

    }
    break; 
}

if($grabar)
{
    echo "<H3>Datos Recibidos:</H3>";
 
    $linea = $nombre .$separador .$apellido .$separador .$legajo .PHP_EOL;
    echo $linea;
    $file = fopen($nombreArchivo,"a");
    fwrite($file,$linea);
}
else
    echo "<H3>NO SE RECIBIERON DATOS</H3>";





?>