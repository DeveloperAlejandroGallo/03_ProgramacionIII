<?php
/**
 * 3- (1 pt.) caso: listarUsuarios (get): 
 * Muestra un listado con todos los datos de los usuarios.
 */
include_once "./Entidades/usuario.php";
include_once "./archivo.php";
include_once "./funciones.php";

function listarUsuarios($archivoUsuario)
{
      
        $archUsuario = new archivo($archivoUsuario);
            
        mostrarTodos("usuario",$archUsuario,usuario::title(),usuario::header());

}


?>