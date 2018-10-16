<?php
/**
 * caso: inscribirAlumno (get): Se recibe nombre, apellido, mail del alumno, materia y código de la materia 
 * y se guarda en el archivo inscripciones.txt restando un cupo a la materia en el archivo materias.txt.
 * Si no hay cupo o la materia no existe informar cada caso particular.
 */

include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/inscripcion.php";

function inscribirAlumno($archivoMaterias,$archivoInscripciones,$archivoAlumnos, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if(isset($_GET["email"])  && isset($_GET["apellido"]) 
        && isset($_GET["nombre"]) && isset($_GET["materia"]) && isset($_GET["codigo"]))
        {
            
            $email = $_GET["email"];
            $apellido = $_GET["apellido"];
            $nombre = $_GET["nombre"];
            $materia = $_GET["materia"];
            $codigo = $_GET["codigo"];

            $archMaterias = new archivo($archivoMaterias);
            $archInscripciones = new archivo($archivoInscripciones);
            $archAlumnos = new archivo($archivoAlumnos);
            
            $listInscripciones = $archInscripciones->toArrayObj("inscripcion", $tipoArchivo);

            if(existeEnArray($listInscripciones,"$email-$codigo") == -1)
            {    
                $listaAlumnos = $archAlumnos->toArrayObj("alumno", $tipoArchivo);
                if(existeEnArray($listaAlumnos,$email)!= -1)
                {
                    $listaMaterias = $archMaterias->toArrayObj("materia", $tipoArchivo);

                    if($indice = existeEnArray($listaMaterias,$codigo) != -1)
                    {
                        if(($listaMaterias[$indice])->cupo > 0)
                        {
                            $inscripcion = new  inscripcion($email,$apellido,$nombre,$codigo,$materia);
                            $archInscripciones->save($inscripcion, $tipoArchivo);

                            ($listaMaterias[$indice])->cupo--;

                            $archMaterias->arrayToFile($listaMaterias, $tipoArchivo);
                            
                            msgInfo ("Inscripcion:  $apellido, $nombre - materia $materia - Exitosa"); 
                        }
                        else
                            msgInfo ("No hay cupo en la materia $codigo-$materia."); 
                    }
                    else
                        msgInfo ("No existe la materia $codigo-$materia."); 
                }
                else
                    msgInfo ("No existe el alumno $apellido, $nombre ($email)."); 
            }
            else
                msgInfo("El alumno $apellido, $nombre ya esta anotado a la materia $materia");

            mostrarTodos("inscripcion",$archInscripciones,inscripcion::title(),inscripcion::header(), $tipoArchivo);
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}


?>