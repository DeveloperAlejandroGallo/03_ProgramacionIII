<?php

class archivoJson
{
    public $nombreArchivo;

    function __construct($name)
    {
        $this->nombreArchivo = $name;
    }

    #guarda en el archivo un nvo json.
    #Recibe un array -> $objeto->toJson();
    function addToJson($datos)
    {
        $fileToJason = fopen($this->name,"a");
        $fileStream = fread($fileToJason,filesize($this->name));
        close($fileToJason);
        $decodeJson = json_decode($fileStream);
        array_push($decodeJson,$datos);
        $encodeJson = json_encode($decodeJson);
        $fileToJason = fopen($this->name,"w");
        fwrite($fileToJason,$encodeJson);
        close($fileToJason);
    }





}


?>