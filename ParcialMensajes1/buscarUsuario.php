<?php
/**2- (2pt.) caso: buscarUsuario (get): Se ingresa apellido, si coincide con algún registro del 
archivo usuarios.txt se retorna todos los usuarios con dicho apellido, si no coincide se debe retornar 
“No existe usuario con apellido xxx” (xxx es el apellido que se buscó) La búsqueda tiene que ser case insensitive.*/
include_once "./Entidades/usuario.php";
include_once "./archivo.php";
include_once "./funciones.php";


function consultarUsuario($nombreArchivo)
{    
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if(isset($_GET["apellido"]) )
        {
            $entidad = "usuario";

            $apellido = $_GET["apellido"];
            $archUsuarios = new archivo($nombreArchivo);
            $listUsuarios = CSVtoArrayObj($entidad,$archUsuarios);
            $busqueda = array(); 
            foreach($listUsuarios as $usr)
            {
                if(strcasecmp($usr->apellido, $apellido)==0)
                    array_push($busqueda,$usr);
            }

            if(count($busqueda)>0)
                listToTable(usuario::title(),usuario::header(),$busqueda);
            else
                msgInfo("No existe usuario con apellido $apellido");
        }
        else
            msgInfo("No configuraron todas las variables.");
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}

?>