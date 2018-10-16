<?php
/**
 * 5- (1pt.) caso: inscripciones(get):
 * Se devuelve un tabla con todos los alumnos inscriptos a todas las materias.
 * 6- (2pts.) caso: inscripciones(get): 
 * Puede recibir el parámetro materia o apellido y filtra la tabla de acuerdo al parámetro pasado.
 */
include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/inscripcion.php";

function consultarInscripciones($archivoInscripciones, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $entidad = "inscripcion";

        $archInscripciones = new archivo($archivoInscripciones);
        $listInscripciones = $archInscripciones->toArrayObj("inscripcion", $tipoArchivo);
        $busqueda = array(); 

        foreach($listInscripciones as $ins)
        {
            if(isset($_GET["materia"]))
            {
                $codigo = $_GET["materia"];
                if(strcasecmp($ins->codigo, $codigo)==0)
                    array_push($busqueda,$ins);
            }
            else
            {
                if (isset($_GET["apellido"]))
                {
                    $apellido = $_GET["apellido"];
                    if(strcasecmp($ins->apellido, $apellido)==0)
                        array_push($busqueda,$ins);
                }
                else
                    array_push($busqueda,$ins);
            }   
        }     
                
        listToTable(inscripcion::title(),inscripcion::header(),$busqueda);
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}

?>