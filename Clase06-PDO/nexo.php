<?php

include_once "cd.php";
include_once "AccesoDatos.php";


echo "Inicio<br>";


$db = AccesoDatos::dameUnObjetoAcceso();

$consulta = "select * from cds";

$ejecucion = $db->RetornarConsulta($consulta);
$ejecucion->execute();



echo "Consulta trajo: " . $ejecucion->rowCount() . " registros.<br>";


$resultado = $ejecucion->FetchAll(); //array de obj
// var_dump(json_encode($resultado));

echo "<h2>For Each Array</h2>";
#Recorrer la devolucion del fetchAll sin convertirlo a json 

foreach($resultado as $reg)
{
    echo "<br>Titulo: ". $reg['title'];//json_decode($reg);
}

echo "<h2>For Each Objeto</h2>";
$resultadoJson = json_encode($resultado); //str json

foreach($resultadoJson as $reg)
{
    echo "<br>Reg: ". $reg->title;//json_decode($reg);
}



echo "<br><br>FIN";

?>