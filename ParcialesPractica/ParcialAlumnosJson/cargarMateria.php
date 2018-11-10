<?php
/**3-(1pts.) caso: cargarMateria(post):
 * Se recibe el nombre de la materia, código de materia, el cupo de alumnos y el aula donde se dicta
 * y se guardan los datos en el archivo materias.txt, tomando como identificador el códigode la materia
 *  */


include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/materia.php";


function cargarMateria($fNameMaterias, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["codigo"]) && isset($_POST["nombre"]) and isset($_POST["cupo"]) and isset($_POST["aula"]))
        {

            $entidad = "materia";    

            $codigo= $_POST["codigo"];
            $nombre= $_POST["nombre"];
            $cupo= $_POST["cupo"];
            $aula= $_POST["aula"];

            $archMaterias = new archivo($fNameMaterias);

            $materia = new materia($codigo,$nombre,$cupo,$aula);
            $listMaterias = $archMaterias->toArrayObj($entidad, $tipoArchivo);

            if(existeEnArray($listMaterias,$codigo) ==-1)
                $archMaterias->save($materia, $tipoArchivo);
            else
                msgInfo("La materia $codigo-$nombre ya existe en la BD");

            mostrarTodos($entidad,$archMaterias,materia::title(),materia::header(), $tipoArchivo);
            
        }        
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}    
?>