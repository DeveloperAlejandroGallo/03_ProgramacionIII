<?php
/**2-(2pt.) caso: consultarAlumno (get):
 * Se ingresa apellido, si coincide con algún registro del archivo alumno.txt 
 * se retorna todos los alumnos con dicho apellido, si no coincide se debe retornar 
 * “No existe alumno con apellido xxx” (xxx es el apellido que se busco)
 * La búsquedatiene que ser case insensitive */
include_once "./Entidades/alumno.php";
include_once "./archivo.php";
include_once "./funciones.php";


function consultarAlumno($nombreArchivo)
{    
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if(isset($_GET["apellido"]) )
        {
            $entidad = "alumno";

            $apellido = $_GET["apellido"];
            $archAlumnos = new archivo($nombreArchivo);
            $listAlumnos = CSVtoArrayObj($entidad,$archAlumnos);
            $busqueda = array(); 
            foreach($listAlumnos as $alum)
            {
                if(strcasecmp($alum->apellido, $apellido)==0)
                    array_push($busqueda,$alum);
            }

            if(count($busqueda)>0)
                listToTable(alumno::title(),alumno::header(),$busqueda);
            else
                msgInfo("No existe alumno con apellido $apellido");
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}

?>