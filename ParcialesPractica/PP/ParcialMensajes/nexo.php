<?php
include_once "./funciones.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./usuario.php";
include_once "./mensaje.php";


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
        usuario::crearUsuario($archivoUsuarios,$carpetaFotos);
        break;
    case "buscarUsuario": //2-get
        usuario::buscarUsuario($archivoUsuarios);
        break;
    case "listarUsuarios": //3-get
        usuario::listarUsuarios($archivoUsuarios);
        break;
    case "cargarMensaje":  //4-post - 8 post
        mensaje::cargarMensaje($archivoMensajes,$carpetaFotos);
        break;
    case "mensajesRecibidos": //5-get -
        mensaje::mensajesEnviadosRecibidos($archivoMensajes,"R");//R-Recibidos
        break;
    case "mensajesEnviados": //6-get
        mensaje::mensajesEnviadosRecibidos($archivoMensajes,"E");//E-enviados
        break;
    case "modificarUsuario": //7-post
        usuario::modificarUsuario($archivoUsuarios,$carpetaFotos,$carpetaFotoBkp);
        break;
    case "mensajes": //9-p-post
        mensaje::mensajes($archivoMensajes);//T- Todos
        break;
    default:
        msgInfo( "Debe ingresar un caso válido($caso).");
        break;
}

?>

