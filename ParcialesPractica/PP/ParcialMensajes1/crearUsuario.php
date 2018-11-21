<?php
/**1- (2 pt.) caso: crearUsuario (post): Se deben guardar los siguientes datos: nombre, apellido, email y foto. 
Los datos se guardan en el archivo de texto usuarios.txt, tomando el email como identificador. */
include_once "./Entidades/usuario.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./funciones.php";

function crearUsuario($archivoUsuario, $carpetaFotos)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["email"]) && isset($_POST["apellido"]) && isset($_POST["nombre"]) && isset($_FILES["foto"]))
        {

            $entidad = "usuario";            
            $email = $_POST["email"];
            $apellido = $_POST["apellido"];
            $nombre = $_POST["nombre"];
            $arrayFoto = $_FILES["foto"];


            $file = new File($arrayFoto);
            $file->newName = $email.$file->Ext;
            $file->newPath = $carpetaFotos;
            $file->moveFile();
            
            $archUsuario = new archivo($archivoUsuario);
            $usuario = new usuario($email,$apellido,$nombre, $file->newPath . $file->newName);

            $listUsuario = CSVtoArrayObj($entidad,$archUsuario);
            

            if(existeEnArray($listUsuario,$email) == -1)
                $archUsuario->save($usuario);
            else
                msgInfo("El mail ($email) ya existe en la base.");

            mostrarTodos($entidad,$archUsuario,usuario::title(),usuario::header());


        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}

?>