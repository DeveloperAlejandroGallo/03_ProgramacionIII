<?php

include_once "./usuario.php";
include_once "./mensaje.php";


////////Array
function CSVtoArrayObj($entidad,$archivo)
{
    $lista = array();
    $file = fopen($archivo->nombre,"a+");

    while(!feof($file))
    {
        $linea = fgets($file);
        $lineaPars = explode(";",$linea);
        $obj;
        if(count($lineaPars)>1)
        {
            switch ($entidad)
            {
                case "usuario":
                    $obj = crearUsuario($lineaPars);
                    break;
                case "mensaje":
                    $obj = crearMensaje($lineaPars);
                    break;
                  
            }
            array_push($lista,$obj);
        }
    }
    fclose($file);

    return $lista;
}

function existeEnArray($list,$buscado)
{
    $i=0;
    foreach($list as $obj)
    {
        if(strcasecmp($obj->clave(),$buscado)==0)
            return $i;
        $i++;
    }
    return -1;
}



/////Creacion de objetos/////////
function crearUsuario($lineaPars)
{   //$email, $apellido, $nombre,  $foto
    return new usuario($lineaPars[0],$lineaPars[1],$lineaPars[2],$lineaPars[3]);
}

function crearMensaje($lineaPars)
{   //$codigo, $nombre, $cupo,  $aula
    return new mensaje($lineaPars[0],$lineaPars[1],$lineaPars[2],$lineaPars[3]);
}



/**Visualizacion */
function mostrarTodos($entidad,$archivo,$title,$header)
{
    $lista = CSVtoArrayObj($entidad,$archivo);
    listToTable($title,$header,$lista);
    
}        

function listToTable($title,$header,$arrayObj)
{
    $paginaHead = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
        <title>$title</title>
    </head>
    <body>
        <h2 style='color: blue'>$title</h2>
        <table>
            <thead style='color: green'>
            $header
            </thead>
            <tbody> ";

    $paginaFoot ="</tbody>
        </table>
    </body>
    </html>";
    $body = "";

    if(count($arrayObj)>0)
    {
        foreach($arrayObj as $obj)
            $body .= $obj->row();
    }
    else
    {
        $rowspan = substr_count($header,"<th>");
        $body .= "<tr><td rowspan='4'>Sin $title</td></tr>";
    }


    echo $paginaHead . $body . $paginaFoot;
}


function msgInfo($msg)
{
    echo "<label style='color: red'>Información: $msg</label> <script>alert('$msg');</script>";
}

?>