<?php
include_once "./buscarUsuario.php";
include_once "./cargarMensaje.php";
include_once "./crearUsuario.php";
include_once "./listarUsuarios.php";
include_once "./mensajesEnviadosRecibidos.php";
include_once "./modificarUsuario.php";


$caso="";
$archivoUsuarios = "usuarios.txt";
$archivoMensajes = "mensajes.txt";

$carpetaFotos = "fotos/";
$carpetaFotoBkp = "fotos/backUpFotos/";

if(isset($_GET["caso"]))
    $caso = $_GET["caso"];
else if (isset($_POST["caso"]))
        $caso = $_POST["caso"];


switch($caso)
{
    case "crearUsuario": //1-post
        crearUsuario($archivoUsuarios,$carpetaFotos);
        break;
    case "buscarUsuario": //2-get
        buscarUsuario($archivoUsuarios);
        break;
    case "listarUsuarios": //3-get
        listarUsuarios($archivoUsuarios);
        break;
    case "cargarMensaje":  //4-post - 8 post
        cargarMensaje($archivoMensajes);
        break;
    case "mensajesRecibidos": //5-get -
        mensajesEnviadosRecibidos($archivoMensajes,"R");
        break;
    case "mensajesEnviados": //6-get
        mensajesEnviadosRecibidos($archivoMensajes,"E");
        break;
    case "modificarUsuario": //7-post
        modificarUsuario($archivoUsuarios,$carpetaFotos,$carpetaFotoBkp);
        break;
    case "mensajes": //9-p-post
        mensajesEnviadosRecibidos($archivoMensajes,"T");
        break;
    default:
        msgInfo( "Debe ingresar un caso válido($caso).");
        break;
}

?>

