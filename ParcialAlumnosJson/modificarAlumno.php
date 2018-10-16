<?php
/**
 * 7- (2 pts.) caso: modificarAlumno(post): 
 * Debe poder modificar todos los datos del alumno menos el email y 
 * guardar la foto antigua en la carpeta /backUpFotos , 
 * el nombre será el apellido y la fecha.
 */
include_once "./Entidades/alumno.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./funciones.php";
function modificarAlumno($archivoAlumnos,$carpetaFotos,$carpetaBkp, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["email"]) && isset($_POST["apellido"]) 
        && isset($_POST["nombre"]) && isset($_FILES["foto"]))
        {

            $email = $_POST["email"];
            $apellido = $_POST["apellido"];
            $nombre = $_POST["nombre"];
            $arrayFoto = $_FILES["foto"];
            
            $archAlumnos = new archivo($archivoAlumnos);
            
            $listAlumnos = $archAlumnos->toArrayObj("alumno", $tipoArchivo);
            $i;
      
            if($i = existeEnArray($listAlumnos,$email) != -1)
            {
     
                $dirFoto = explode(".",($listAlumnos[$i])->foto);
                
                $ext = array_pop($dirFoto);
                $nombreBkp = $carpetaBkp . $apellido . "_" . date("YYYYMMDD").$ext;

                move_uploaded_file(($listAlumnos[$i])->foto,$nombreBkp);
                
                $file = new File($arrayFoto);
                $file->newName = $email.$file->Ext;
                $file->newPath = $carpetaFotos;
                $file->moveFile();
          
                ($listAlumnos[$i])->apellido = $apellido;
                ($listAlumnos[$i])->nombre = $nombre;
                ($listAlumnos[$i])->foto = $file->newPath.$file->newName;

                $archAlumnos->arrayToFile($listAlumnos, $tipoArchivo);

                msgInfo("Alumno $apellido, $nombre ($email) - Modificado con Exito");
            }
            else
                msgInfo("No existe el alumno $apellido, $nombre ($email)");

            mostrarTodos("alumno",$archAlumnos,alumno::title(),alumno::header(), $tipoArchivo);
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}


?>