<?php
/*
Aplicación Nº 4 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras 
la suma no supere a 1000. Mostrar los números sumados y al finalizar el proceso 
indicar cuantos números se sumaron.
*/

$suma = 0;
$i=0;
while($suma < 1000)
{
    $i++;
    $suma += $i;
}

echo "La suma de 1 hasta " .$i ." es " .$suma;
?>