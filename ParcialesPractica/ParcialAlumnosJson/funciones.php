<?php

include_once "./Entidades/alumno.php";
include_once "./Entidades/materia.php";
include_once "./Entidades/inscripcion.php";



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
function crearAlumno($lineaPars)
{   //$email, $apellido, $nombre,  $foto
    return new alumno($lineaPars[0],$lineaPars[1],$lineaPars[2],$lineaPars[3]);
}

function crearMateria($lineaPars)
{   //$codigo, $nombre, $cupo,  $aula
    return new materia($lineaPars[0],$lineaPars[1],$lineaPars[2],$lineaPars[3]);
}

function crearInscripcion($lineaPars)
{   //$email, $apellido, $nombre,  $codigo, $materia
    return new inscripcion($lineaPars[0],$lineaPars[1],$lineaPars[2],$lineaPars[3], $lineaPars[4]);
}
///////////////////////////////


/**Visualizacion */
function mostrarTodos($entidad,$archivo,$title,$header,$tipoArchivo)
{
    $lista = $archivo->toArrayObj($entidad,$tipoArchivo);
    
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
        $body .= "<tr><td rowspan='10'>Sin $title</td></tr>";
    }


    echo $paginaHead . $body . $paginaFoot;
}


function msgInfo($msg)
{
    echo "<label style='color: red'>$msg</label> <script>alert('$msg');</script>";
}

?>