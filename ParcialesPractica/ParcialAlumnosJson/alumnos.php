<?php
/**
 * caso: alumnos (get): Mostrar una tabla con todos 
 * los datos de los alumnos, incluida la foto.
 */
include_once "./Entidades/alumno.php";
include_once "./archivo.php";
include_once "./funciones.php";

function listarAlumnos($archivoAlumnos,$carpetaFotos,$carpetaBkp, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
                   
        $archAlumnos = new archivo($archivoAlumnos);
            
        mostrarTodos("alumno",$archAlumnos,alumno::title(),alumno::header(), $tipoArchivo);

    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET");
}


?>