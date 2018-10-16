<?PHP
include_once "persona.php";
include_once "imaterias.php";
include_once "alumno.php";
//creamos una objeto per1 
#$per1 = new stdclass();
//al obj inicializado puedo asignarle propiedades
#para accede a la propiedad del objeto ->
/*
$per1->nombre = "Pepe";

echo "Persona creada con stdclass:<br>";
echo $per1->nombre;

echo "<br>Persona creada con el objeto persona:<br>";

$per2 = new Persona;
$per2->nombre = "Alejandro";
$per2->apellido = "Gallo";

echo $per2->nombre;

var_dump($per2->Saludar());
echo "<br> Saludar 2 <br>";
var_dump($per2->Saludar2());
*/
$alumno1 = new alumno("Alejandro", "Gallo", 1000);

echo $alumno1->inscribirMaterias("PROGRAMACION 3");



?>