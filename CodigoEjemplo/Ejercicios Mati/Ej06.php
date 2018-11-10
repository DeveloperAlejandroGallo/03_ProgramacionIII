<?php
/*
Aplicación Nº 5 (Obtener el valor del medio)
Dadas tres variables numéricas de tipo entero $a, $b y $c, realizar una aplicación que muestre el 
contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres 
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”
 */

$a = 6;
$b = 5;
$c = 6;

if($a < $b)
{
    if($b < $c)
        echo $b ." es el valor del medio";
    else
        if($c > $b)
            echo $c ." es el valor del medio";
        else
            echo "No existe valor del medio.";
}
else
{
    if($a < $c)
        echo $a ." es el valor del medio";
    else
        if($c > $a)
            echo $c ." es el valor del medio";
    else
        echo "No existe valor del medio.";
}

?>