<?php 

$nombre = "";
$apellido = "";
$legajo = "";
$separador = ";";
$valido = false;
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
        $valido = false;

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
        if(isset($_GET["legajo"]))
        {
            $legajo = $_GET["legajo"];
        }
        $valido = true;
       
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

$archivo = fopen($nombreArchivo,"a+");
echo "<h4>Informacion Buscada</h4>";
if($valido)
{
    if($legajo != "")
    {
        while(!feof($archivo))
        {
          $linea = fgets($archivo);
          $lineaPars = explode(";",$linea);
          if($lineaPars[2] = $legajo)
          {
            echo "<h4>Alumno:<h4> Nombre: " .$lineaPars[0]; 
            echo "<br>Apellido: " .$lineaPars[1];
            echo "<br>Legajo: " .$lineaPars[2];
              
          }
            
        }
    }
    else
    {//leo todo el archivo
        echo "<h4>Leo todo el archivo</h4>";
        $fileStream = fread($archivo,filesize($nombreArchivo));
        echo "<h4>Informacion Buscada</h4>";
        echo $fileStream;
    }
}
else
    echo "No Valido.";





?>