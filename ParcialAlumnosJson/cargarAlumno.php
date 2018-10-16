<?php
/**1-(2pt.) caso: cargarAlumno (post): 
 * Se deben guardar los siguientes datos: nombre, apellido, email y foto. 
 * Los datos se guardan en el archivo de texto alumnos.txt, tomando el email como identificador. */

include_once "./Entidades/alumno.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./funciones.php";

function cargarAlumno($archivoAlumnos, $carpetaFotos, $tipoArchivo)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["email"]) && isset($_POST["apellido"]) && isset($_POST["nombre"]) && isset($_FILES["foto"]))
        {

            $entidad = "alumno";            
            $email = $_POST["email"];
            $apellido = $_POST["apellido"];
            $nombre = $_POST["nombre"];
            $arrayFoto = $_FILES["foto"];


            $file = new File($arrayFoto);
            $file->newName = $email.$file->Ext;
            $file->newPath = $carpetaFotos;
            $file->moveFile();
            
            $archAlumno = new archivo($archivoAlumnos);
            $alumno = new alumno($email,$apellido,$nombre,$file->newPath.$file->newName);

            $listAlumnos = $archAlumno->ToArrayObj($entidad,$tipoArchivo);

            if(!is_null($listAlumnos))
            {
                if(existeEnArray($listAlumnos,$email) == -1)
                {
                    $archAlumno->save($alumno,$tipoArchivo);
                    msgInfo("Alumno $apellido, $nombre dado de alta con exito.");
                }
                else
                    msgInfo("El mail ($email) ya existe en la base.");
            }
            else
            {
                $archAlumno->save($alumno);
               
                msgInfo("Alumno $apellido, $nombre dado de alta con exito.");
            }
            mostrarTodos($entidad,$archAlumno,alumno::title(),alumno::header(),$tipoArchivo);


        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}

?>