<?php

class Files
{
    public $Name;
    public $Ext;
    public $Path;
    public $Size;
    public $error;
    public $data;

    function __construct($file)
    {
        $this->Name=  $file["name"];
        $explode = explode("/", $file["type"]);
        $this->Type=  $explode[0];
        $this->Ext=   "." .$explode[1];
        $this->Path=  $file["tmp_name"];
        $this->Size=  $file["size"];
        $this->Error= $file["error"];
           
    }

    function validarTamanio($maxSize)
    {
        return $this->Size <= $maxSize;
    }

    function validarTipo($vType)
    {
        return $this->Type == $tipo;
    }

    function save()
    {
        $file = fopen($nameFile,"a");
        fwrite($file,$data);
        fclose($file);
    }


    function readLine()
    {
        $file = fopen($nombreArchivo,"a");
        $ret = fread($file);
        close($file);
        return $ret;
    }

    function moveFile($pathOutput)
    {
        return move_uploaded_file($this->Path,$pathOutput);
    }

    function Exist()
    {
        return file_exists($this->Name);
    }

 
}

?>