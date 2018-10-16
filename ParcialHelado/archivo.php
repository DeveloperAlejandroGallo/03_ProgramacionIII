<?php
class archivo
{
    public $nombreArchivo;
    public $datos;

    function __construct($name)
    {
        $this->nombreArchivo = $name;
    }

    function save($objeto)
    {
        $file = fopen($this->nombreArchivo,"a+");
        $linea = $objeto->toCSV();

        fwrite($file,$linea);
        fclose($file);
        //echo "<h4>Archivo: " . $this->nombreArchivo . " - Valores: " . $linea . "</h4>";
    }


    function buscar($buscado)
    {
        $encontrado = false;
        $file = fopen($this->nombreArchivo,"r");
        while(!feof($file) && !$encontrado)
        {
            $linea = fgets($file);
            $lineaPars = explode(";",$linea);
            if($lineaPars[0] == $buscado)
                $encontrado = true;
        }
        fclose($file);
        return $encontrado;
    }

    function read()
    {
        $file = fopen($this->nombreArchivo,"r");
        $ret = fread($file);
        close($file);
        return $ret;
    }

    function createNew()
    {
        $file = fopen($this->nombreArchivo,"w+");
        fclose($file);
    }

    function moveFile($pathOutput)
    {
        if(move_uploaded_file($this->Path,$pathOutput))
            return true;
        else
            return false;
    }


}

?>