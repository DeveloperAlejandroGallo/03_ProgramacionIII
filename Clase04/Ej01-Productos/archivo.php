<?php
class archivo
{
    public $nombreArchivo;
    public $datos;

    function __construct($name)
    {
        $this->nombreArchivo = $name;
    }

    function save()
    {
        $file = fopen($nombreArchivo,"a");
        fwrite($file,$datos);
        fclose($file);
    }


    function read()
    {
        $file = fopen($nombreArchivo,"a");
        $ret = fread($file);
        close($file);
        return $ret;
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