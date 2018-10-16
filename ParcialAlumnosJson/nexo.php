<?php
include_once "./cargarAlumno.php";
include_once "./cargarMateria.php";
include_once "./consultarAlumno.php";
include_once "./inscribirAlumno.php";
include_once "./inscripciones.php";
include_once "./modificarAlumno.php";
include_once "./alumnos.php";



$caso="";
$archivoAlumnos = "alumnos.txt";
$archivoMaterias = "materias.txt";
$archivoInscripciones = "inscripciones.txt";
$carpetaFotos = "fotos/";
$carpetaFotoBkp = "fotos/backUpFotos/";

$tipoArchivo = "json";

if(isset($_GET["caso"]))
    $caso = $_GET["caso"];
else if (isset($_POST["caso"]))
        $caso = $_POST["caso"];


switch($caso)
{
    case "cargarAlumno": 
        cargarAlumno($archivoAlumnos,$carpetaFotos,$tipoArchivo,$tipoArchivo);
        break;
    case "consultarAlumno": 
        consultarAlumno($archivoAlumnos,$tipoArchivo);
        break;
    case "cargarMateria": 
        cargarMateria($archivoMaterias,$tipoArchivo);
        break;
    case "inscribirAlumno": 
        inscribirAlumno($archivoMaterias,$archivoInscripciones, $archivoAlumnos, $tipoArchivo);
        break;
    case "inscripciones":
        consultarInscripciones($archivoInscripciones,$tipoArchivo);
        break;
    case "modificarAlumno":
        modificarAlumno($archivoAlumnos,$carpetaFotos,$carpetaFotoBkp,$tipoArchivo);
        break;
    case "alumnos":
        listarAlumnos($archivoAlumnos,$carpetaFotos, $carpetaFotoBkp,$tipoArchivo);
        break;
    default:
        msgInfo( "Debe ingresar un caso válido($caso).");
        break;
}

?>

