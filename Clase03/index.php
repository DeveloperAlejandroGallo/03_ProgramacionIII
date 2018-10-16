<?php
/*



*/
$texto = "Hola mundo!!!";
echo "Apertura de archivo<br>";
$archivo = fopen("archivo.txt","a+");
echo "Ecribo<br>";
fwrite($archivo,$texto .PHP_EOL);
echo "<br>Fin";
echo "<br>Lectura del archivo: ";
 fclose($archivo);
 $archivo = fopen("archivo.txt","a+");
//echo fread($archivo,1000); // Muestra todo el contenido del archivo
$nro = 0;
echo "<br><br>";
while(!feof($archivo))
{
    $nro++;
    echo fgets($archivo) ."Linea Nro:" .$nro ."<br>";
}

/*
mkdir("Carpetira"); //crea directorio
copy("archivo.txt","copia.txt");
copy("archivo.txt","copia1.txt");
copy("archivo.txt","copia2.txt");
unlink("copia1.txt"); //borra archivo
*/


?>