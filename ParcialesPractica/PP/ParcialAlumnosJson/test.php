
<?php

class alumno
{
    public $nombre;
    public $apellido;

    function __construct($nombre,$apellido)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }
}
$lista=array();
for ($i=0;$i<20;$i++)
{
    $clase = new alumno("Nombre $i", "Apellido $i");
    echo "<b>VAR_DUMP CLASE:</b> <br>";
    var_dump($clase);
    echo "<br><br>";
    array_push($lista,$clase); //lista de obj
    $claseJson = json_encode($clase);
    echo "<b>OBJETO JSON: $claseJson</b><br><br>";
    $listaJson = json_encode($lista);
}


$jsonAClase = json_decode($claseJson);
$listaJsonAClase = json_decode($listaJson);
echo "<b>LISTA JSON:</b> <br>$listaJson";
echo "<br>";
echo "<br>";
echo "JSON A CLASE - ATRIBUTO".$jsonAClase->nombre;
echo "<br>";
echo "<br>";

echo "<b>LISTA JSON A CLASE RECORRIDA: </b><br><br>";

foreach($listaJsonAClase as $obj)
    echo "nombre: $obj->nombre y apellido: $obj->apellido<br>";


?>