<?PHP
include_once "persona.php";
include_once "imaterias.php";
include_once "alumno.php";

#var_dump($_GET);
#var_dump($_POST);
//echo $_POST["nombre"];
echo "<br>";
//echo $_REQUEST["nombre"];
echo "<br>";
echo "<br>";
#var_dump($_SERVER);

//ISSET($_GET("variable"));

switch ($_SERVER["REQUEST_METHOD"])
{
    case "POST":
    {
        if(!ISSET($_POST["nombre"]) || !ISSET($_POST["apellido"]) ||!ISSET($_POST["legajo"]) )
        {   
            echo "FALTAN CONFIGURAR VARIABLES"; 
            break;
        }
        $alumno = new alumno($_POST["nombre"], $_POST["apellido"],$_POST["legajo"]);
        
        $alumno->__SET("nombre","COCO");
        echo $alumno->__GET("nombre");

        echo $alumno->inscribirMaterias("PROGRAMACION 3");
    }
    break;
    case "GET":
    {
        if(!ISSET($_GET["nombre"]) || !ISSET($_GET["apellido"]) ||!ISSET($_GET["legajo"]) )
        {   
            echo "FALTAN CONFIGURAR VARIABLES"; 
            break;
        }
        $alumno = new alumno($_GET["nombre"], $_GET["apellido"],$_GET["legajo"]);
        echo $alumno->inscribirMaterias("PROGRAMACION 3");
    }
    break;
    case "PUT":
    {

    }
    break;   
    case "DELETE":
    {

    }
    break; 
}

?>