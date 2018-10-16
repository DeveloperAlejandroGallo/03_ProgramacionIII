<?PHP
include_once "persona.php";
include_once "imaterias.php";
include_once "alumno.php";

$archivoOrigen = "alumnos.csv";
$archivoJson = "alumnosJSon.dat";

    $file = fopen($archivoOrigen,"a+");
    $archivoJson = fopen($archivoJson,"a");

    $i = 0;
    $arrayAlumno[0]=null;
    while(!feof($file))
    {
        $linea = fgets($file);
        echo "<br>Linea: " .$linea;
        $arrayLinea = explode(";",$linea);
        $alumno = new alumno($arrayLinea[0],$arrayLinea[1],$arrayLinea[2]);
        $arrayAlumno[$i] = $alumno;
        $i++;
    }
    $alumnosJson = json_encode($arrayAlumno);

    fwrite($archivoJson, $alumnosJson);
    echo "Datos escritos en el archivo " .$alumnosJson;







?>