<?php

class Helado
{

    public $Sabor;
    public $precio;
    public $Tipo;
    public $cantidad;

    function __construct($unSabor,$unTipo,$unaCantidad,$unPrecio)
    {
        $this->Sabor = $unSabor;
        $this->precio = $unPrecio;
        $this->Tipo = $unTipo;
        $this->cantidad = $unaCantidad;
        
    }

    function toCSV()
    {
        $separador = ";";
        return $this->Sabor . "," .  $this->Tipo . $separador . $this->cantidad . $separador . $this->precio . PHP_EOL;
    }

    static function toArray($nombreArchivo)
    {
        $file = fopen($nombreArchivo,"r");
        $array = array();
        echo "to array: <br>";
        while(!feof($file))
        {
            $linea = fgets($file);
            echo "<br>Linea:". $linea. " <br>";
            $lineaPars = explode(";",$linea);
            if(count($lineaPars) == 3)
            {
                $saborTipo = explode(",",$lineaPars[0]);
                $arrayHelado = array($saborTipo[0],$saborTipo[1],$lineaPars[1],$lineaPars[2]);
                echo "Helado: " . var_dump($arrayHelado);
                array_push($array,$arrayHelado);
            }
        }
        fclose($file);

        return $array;
    }

static function verStock($archivo)
{
    $html = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
        <title>Helados</title>
    </head>
    <body>
        <h3>Stock de Helados</h3>
        <table>
            <thead>
                <tr>
                    <th>Sabor</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>";
    $htmlFin = "        </tbody>
        </table>
    </body>
    </html>";
    $stock = self::toArray($archivo);
    
    if(count($stock)>0)
    {
        foreach($stock as $helado)
        {
            $sabor = $helado[0];
            $tipo  = $helado[1];
            $cant  = $helado[2];
            $precio= $helado[3]; 
            $html .= "<tr><td>" . $sabor . "</td><td>".$tipo."</td><td>".$cant."</td><td>".$precio."</td></tr>";
        }
    }
    else
        $html += "<tr><td rowspan='4'>SIN STOCK</td></tr>";
    
    echo $html . $htmlFin;
}

}

?>