<?PHP
#Ejercicio 1 de Guía
echo "Ejercicio 1: \n";
echo "\n";
$nombre = "Matías";
$apellido = "Paverini";

echo "Nombre: ".$nombre."\n";
echo "Apellido: ".$apellido."\n";
echo "Nombre completo:".$apellido.", ".$nombre."\n";

#Fin ejercicio 1
echo "\n";
echo "\n";
#Ejercicio 2
echo "Ejercicio 2: \n";
echo "\n";
$x = -3;
$y = 15;
$z = $x + $y;

echo "Variable 1: $x\n";
echo "Variable 2: $y\n";
echo "Resultado de suma: $z";
#Fin Ejercicio 2

#Ejercicio 3
echo "Ejercicio 3: \n";
echo "\n";
echo "<h1>Resuelto en ejercicio 2\n</h1>";

#Fin Ejercicio 3

#Ejercicio 4
echo "Ejercicio 4: \n";
echo "\n";
$i;
$valor = 1;
$valorAnterior;

for($i = 0; $valor < 1000; $i++)
{
    $valorAnterior = $valor;
    echo "Números sumados: $valor + $valorAnterior\n";
    $valor += $valorAnterior;
}

echo "Número final: $valor\n";
echo "Total de números sumados: $i\n";
echo "\n";
#Fin Ejercicio 4

#Ejercicio 5
echo "Ejercicio 5";
echo "\n";
$a = 4;
$b = 8;
$c = 10;

if($a < $b && $a > $c || $a > $b && $a < $c)
{
    echo "Intermedio A: $a\n";
}
elseif($b > $a && $b < $c || $b < $a && $b > $c)
{
    echo "Intermedio B: $b\n";
}

elseif($c < $b && $c > $a || $c > $b && $c < $a)
{
    echo "Intermedio C: $c\n";
}
else
{
    echo "No hay números intermedios\n";
}
#Fin Ejercicio 5

?>