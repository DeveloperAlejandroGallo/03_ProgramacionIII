<?php
/**
*7- (2 pts.) caso: modificarUsuario(post): Debe poder modificar todos los datos del usuario menos el email y 
*guardar la foto antigua en la carpeta /backUpFotos , el nombre será el apellido y la fecha.
 */
include_once "./Entidades/usuario.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./funciones.php";
function modificarUsuario($archivoUsuarios,$carpetaFotos,$carpetaBkp)
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
            
            $archUsuarios = new archivo($archivoUsuarios);
            
            $listUsuarios = CSVtoArrayObj("usuario",$archUsuarios);
            $i;
            if($i = existeEnArray($listUsuarios,$email) != -1)
            {
                $dirFoto = explode(".",($listUsuarios[$i])->foto);
                
                $ext = array_pop($dirFoto);
                $nombreBkp = $carpetaBkp . $apellido . "_" . date("YYYYMMDD").$ext;

                move_uploaded_file(($listUsuarios[$i])->foto,$nombreBkp);
                
                $file = new File($arrayFoto);
                $file->newName = $email.$file->Ext;
                $file->newPath = $carpetaFotos;
                $file->moveFile();
                
                ($listUsuarios[$i])->apellido = $apellido;
                ($listUsuarios[$i])->nombre = $nombre;
                ($listUsuarios[$i])->foto = $file->newPath.$file->newName;

                $archUsuarios->arrayToCSV($listUsuarios);
                msgInfo("Usuario $apellido, $nombre ($email) - Modificado con Exito");
            }
            else
                msgInfo("No existe el usuario $apellido, $nombre ($email)");

            mostrarTodos("usuario",$archUsuarios,usuario::title(),usuario::header());
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo POST.");
}


?>