<?php
/**
 * caso: inscribirAlumno (get): Se recibe nombre, apellido, mail del alumno, materia y código de la materia 
 * y se guarda en el archivo inscripciones.txt restando un cupo a la materia en el archivo materias.txt.
 * Si no hay cupo o la materia no existe informar cada caso particular.
 */

include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/inscripcion.php";

function inscribirAlumno($archivoMaterias,$archivoInscripciones)
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
            
            $listInscripciones = CSVtoArrayObj("inscripcion",$archInscripciones);

            if(existeEnArray($listInscripciones,"$email-$codigo") == -1)
            {    
                $listaMaterias = CSVtoArrayObj("materia",$archMaterias);

                if($indice = existeEnArray($listaMaterias,$codigo) != -1)
                {
                    if(($listaMaterias[$indice])->cupo > 0)
                    {
                        $inscripcion = new  inscripcion($email,$apellido,$nombre,$codigo,$materia);
                        $archInscripciones->save($inscripcion);

                        ($listaMaterias[$indice])->cupo--;

                        $archMaterias->arrayToCSV($listaMaterias);

                    }
                    else
                        msgInfo ("No hay cupo en la materia $codigo-$materia."); 
                }
                else
                    msgInfo ("No existe la materia $codigo-$materia."); 
            }
            else
                msgInfo("El alumno $apellido, $nombre ya esta anotado a la materia $materia");

            mostrarTodos("inscripcion",$archInscripciones,inscripcion::title(),inscripcion::header());
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}


?>