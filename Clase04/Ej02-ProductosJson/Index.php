<?php

include_once "producto.php";
include_once "File.php";



$valido = false;
$fileName = "productos.txt";
$nombre = "";
$codigoBarras = "";
$arrayFile;
switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST":
    {
        if(!ISSET($_FILES["imagen"]) ||  !ISSET($_POST["nombre"]) || !ISSET($_POST["codBarr"]))
        {   
            echo "FALTAN CONFIGURAR VARIABLES"; 
            break;
        }
        echo "Variables OK";
        $arrayFile = $_FILES["imagen"];
        $nombre = $_POST["nombre"];
        $codigoBarras = $_POST["codBarr"];
        $valido = true;

    }
    break;
    case "GET":
    {
        // if(!ISSET($_GET["nombre"]) || !ISSET($_GET["apellido"]) ||!ISSET($_GET["legajo"]) )
        // {   
        //     echo "FALTAN CONFIGURAR VARIABLES"; 
        //     break;
        // }
        // $nombre = $_GET["nombre"];
        // $apellido = $_GET["apellido"];
        // $legajo= $_GET["legajo"];  
            echo "NO CONFIGURADO PARA LLAMADO GET";
       
    }
    break;
    case "PUT":
    {
        echo "NO CONFIGURADO PARA LLAMADO PUT";
    }
    break;   
    case "DELETE":
    {
        echo "NO CONFIGURADO PARA LLAMADO DELETE";
    }
    break; 
}

if($valido)
{
    $file = new Files($arrayFile);
    echo "Archivo Recibido<br><br>";
    //var_dump($arrayFile);
    //var_dump($file);
    if($file->Type == "image" && $file->Size < 4000000)
    {
        echo "Archivo de Imagen valido <br>";
        $imgPathDest = $file->Name ."_" .$codigoBarras .$file->Ext;
       
        
        if(move_uploaded_file($file->Path,$imgPathDest))
        {
            echo "Archivo Guardado con exito<br>";
        }
        else
        {
            echo "Archivo no guardado<br>";
        }
    }

}

?>