<?php
class archivo
{
    public $nombre;
    public $nombreJson;

    function __construct($name)
    {
        $this->nombre = $name;
        $this->nombreJson = (explode(".",$name)[0]).".json";
    }

    function save($objeto)
    {

        $file = fopen($this->nombre,"a+");
        $linea = $objeto->toCSV();

        fwrite($file,$linea);
        fclose($file);

    }


    function buscarEnArchivo($buscado,$nroCampo)
    {
        $posicion = -1;
        $file = fopen($this->nombre,"r");
        $i=0;
        while(!feof($file) && $posicion == -1)
        {
            $linea = fgets($file);
            $lineaPars = explode(";",$linea);
            if(count($lineaPars)>1)
            {        
                if($lineaPars[$nroCampo] == $buscado)
                {
                    $posicion = $i;
                    break;
                }
            }  
            $i++;      
        }
        fclose($file);
        return $posicion;
    }

    function read()
    {
        $file = fopen($this->nombre,"r");
        $ret = fread($file);
        close($file);
        return $ret;
    }

    function createNew()
    {
        $file = fopen($this->nombre,"w+");
        fclose($file);
    }

    function CSVtoArray()
    {
        $lista = array();
        $file = fopen($this->nombre,"r");
        while(!feof($file))
        {
            $linea = fgets($file);
            $lineaPars = explode(";",$linea);
            if(count($lineaPars)>1)
                array_push($lista,$lineaPars);
            
        }
        fclose($file);

        return $lista;
    }

    function arrayToCSV($array)
    {
        $this->createNew();
        foreach($array as $obj)
            $this->save($obj);
            
    }

}

?>