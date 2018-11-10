<?php

include_once "AccesoDatos.php";
include_once "cd.php";


echo "Inicio<br>";

$host = "localhost";
$dbName = "utn";
$usr = "root";
$psw = "";


$db = AccesoDatos::getDataAccess($host,$dbName,$usr,$psw);

$consulta = "select * from cds";

$ejecucion = $db->execQuery($consulta);
$ejecucion->execute();



echo "Consulta trajo: " . $ejecucion->rowCount() . " registros.<br>";


$resultado = $ejecucion->FetchAll(); //array de obj
// var_dump(json_encode($resultado));

echo "<h2>For Each Array</h2>";
#Recorrer la devolucion del fetchAll sin convertirlo a json 

foreach($resultado as $reg)
{
    echo "<br>Titulo: ". $reg['title'];//json_decode($reg);
   # echo $reg->title;
}

echo "<h2>For Each Objeto</h2>";
$resultadoJsonStr = json_encode($resultado); //str json para enviar al srv

echo "<br>Reg: ".$resultadoJsonStr ;//json_decode($reg);



echo "<br><br>FIN";


?>