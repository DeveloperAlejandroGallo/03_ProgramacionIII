<?php
/**3-(1pts.) caso: cargarMateria(post):
 * Se recibe el nombre de la materia, código de materia, el cupo de alumnos y el aula donde se dicta
 * y se guardan los datos en el archivo materias.txt, tomando como identificador el códigode la materia
 *  */


include_once "./archivoJson.php";
include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/materia.php";


function cargarMateria($fNameMaterias)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["codigo"]) && isset($_POST["nombre"]) and isset($_POST["cupo"]) and isset($_POST["aula"]))
        {

            //$fileMateriasJson = new archivoJson($fNameMateriasJson);
            $entidad = "materia";    

            $codigo= $_POST["codigo"];
            $nombre= $_POST["nombre"];
            $cupo= $_POST["cupo"];
            $aula= $_POST["aula"];

            $archMaterias = new archivo($fNameMaterias);

            $materia = new materia($codigo,$nombre,$cupo,$aula);
            $listMaterias = CSVtoArrayObj($entidad,$archMaterias);

            if(existeEnArray($listMaterias,$codigo) ==-1)
                $archMaterias->save($materia);
            //$fileMateriasJson->addToJson($materia->toJson);
            else
                msgInfo("La materia $codigo-$nombre ya existe en la BD");

            mostrarTodos($entidad,$archMaterias,materia::title(),materia::header());
            
        }        
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}    
?>