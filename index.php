<?PHP
$foo = "asd";//Declaracion de variable
$foob = "gfhgAsdfSDHN";
echo "Concat 1: Hola PHP!".$foo;//Método de concatenación 1
echo "\nConcat 2: Hola PHP! $foo 1";//Método de concatenación 2
echo "\n".'Cadena Literal: Hola PHP! $smth'."\n";//Método de muestra literal

echo "Str Length: ".strlen($foo);
echo "\n";
echo "STR Compare: ".strcmp($foo, $foob);
echo "\n";
echo "To Lower: ".strtolower($foob);
echo "\n";
echo "Primer letra Mayúscula: ".ucfirst($foo);
echo "\n";
echo "SubString: ".substr($foob, 4, strlen($foob))."\n";

//Creación de Arrays

$vec = array(4, 5, 6);//array indexado

var_dump($vec);
$tam = count($vec);

echo "\nFor común: ";
for($i = 0; $i < $tam; $i++)
{
    echo "\n".$vec[$i];
}

$vector = array("A" => 1, "B" => 2, "C" => 3); //Array asociativo

echo "\nArray normal, foreach: ";
foreach($vec as $valor)//por cada valor en el vector
{
    echo "$valor\n";
}

echo "\nArray Asociativo, foreach: ";
foreach($vector as $i => $valor)//por cada valor en el indice del vector
{
    echo "$valor\n";
}

?>

