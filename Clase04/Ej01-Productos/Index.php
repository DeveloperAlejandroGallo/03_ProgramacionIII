<?php

include_once "producto.php";
include_once "file.php";



$valido = false;
$fileName = "productos.txt";
$nombre = "";
$codigoBarras = "";
$arrayFile;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
        if(/*ISSET($_FILES["imagen"]) ||*/  ISSET($_POST["nombre"]) || ISSET($_POST["codBarr"]))
        {   
            
            echo "Variables OK<br>";
            $arrayFile = $_FILES["imagen"];
            $nombre = $_POST["nombre"];
            $codigoBarras = $_POST["codBarr"];
            $valido = true;
        }
        else
            echo  "FALTAN CONFIGURAR VARIABLES"; 
    
   
}

if($valido)
{

    $file = new Files($arrayFile);
    echo "Archivo Recibido<br><br>";
    //var_dump($arrayFile);
    var_dump($file);
    if($file->Type == "image" && $file->Size < 4000000)
    {
        
        echo "Archivo de Imagen valido <br>";
        $imgPathDest = $file->Name ."_" .$codigoBarras .$file->Ext;
       
        
        if($file->moveFile($imgPathDest))
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