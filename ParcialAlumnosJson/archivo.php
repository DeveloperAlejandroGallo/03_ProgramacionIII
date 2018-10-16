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
///////////CSV
    function save($objeto,$tipoArchivo)
    {
        if($tipoArchivo=="json")
            $this->saveJson($objeto);
        else
            $this->saveCSV($objeto);

    }

    function toArrayObj($entidad,$tipoArchivo)
    {
        if($tipoArchivo=="json")
            $listaObj = $this->jsonToArrayObj($entidad);
        else
            $listaObj=$this->CSVtoArrayObj($entidad);
        
        return $listaObj;
    }

    function saveCSV($objeto)
    {
        $file = fopen($this->nombre,"a+");
        $linea = $objeto->toCSV();

        fwrite($file,$linea);
        fclose($file);
    }

    function saveJson($objeto)
    {
        $lista=array();
        if(file_exists($this->nombreJson))
        {

            $contArchivo = file_get_contents($this->nombreJson);
            
            if(is_null($contArchivo))
            {
                $lista= array($objeto);
    
            }
            else
            {
                $lista = json_decode($contArchivo);
                array_push($lista, $objeto);
            }
        }
        else
        {
            $lista= array($objeto);
        }
        
        $listaJson = json_encode($lista);
        
        $file = fopen($this->nombreJson,"w");

        fwrite($file,$listaJson);
        fclose($file);


    }

    function CSVtoArrayObj($entidad)
    {
        $lista = array();
        $file = fopen($this->nombre,"r");
        while(!feof($file))
        {
            $linea = fgets($file);
            $lineaPars = explode(";",$linea);
            $obj;
            if(count($lineaPars)>1)
            {
                switch ($entidad)
                {
                    case "alumno":
                        $obj = crearAlumno($lineaPars);
                        break;
                    case "materia":
                        $obj = crearMateria($lineaPars);
                        break;
                    case "inscripcion":
                        $obj = crearInscripcion($lineaPars);
                        break;
                        
                }
                array_push($lista,$obj);
            }
        }
        fclose($file);

        return $lista;
    }


    function createNew($tipoArchivo)
    {
        if($tipoArchivo=="json")
            $file = fopen($this->nombreJson,"w");
        else
            $file = fopen($this->nombre,"w");
        
        fclose($file);
    }

    function arrayToFile($array, $tipoArchivo)
    {
        $this->createNew($tipoArchivo);
        foreach($array as $obj)
        {    
            if($tipoArchivo=="json")
                $this->saveJson($obj);
            else
                $this->saveCSV($obj);  
        }
    }


    

    // function addToJson($datos)
    // {
    //     $fileToJason = fopen($this->nombreJson,"a");
    //     $fileStream = fread($fileToJason,filesize($this->nombreJson));
    //     close($fileToJason);
    //     $decodeJson = json_decode($fileStream);
    //     array_push($decodeJson,$datos);
    //     $encodeJson = json_encode($decodeJson);
    //     $fileToJason = fopen($this->nombreJson,"w");
    //     fwrite($fileToJason,$encodeJson);
    //     fclose($fileToJason);
    // }


    function jsonToArrayObj($entidad)
    {
        $lista= array();
        $listaObj = array();
        if(file_exists($this->nombreJson))
        {    
            $contArchivo = file_get_contents($this->nombreJson);

            if(!is_null($contArchivo))
            {

                $lista = json_decode($contArchivo, true);
                
                //echo "Entidad: $entidad<br>Lista:<br>";
                //var_dump($lista);        
                foreach($lista as $key => $lineaPars)
                {
                    $obj;
                    switch ($entidad)
                    {
                        case "alumno":
                        //$email, $apellido, $nombre,  $foto
                        $obj = crearAlumno(array($lineaPars["email"],$lineaPars["apellido"],$lineaPars["nombre"],$lineaPars["foto"]));
                        break;
                        case "materia":
                        //$codigo, $nombre, $cupo,  $aula
                        $obj = crearMateria(array($lineaPars["codigo"],$lineaPars["nombre"],$lineaPars["cupo"],$lineaPars["aula"]));
                        break;
                        case "inscripcion":
                        //$email, $apellido, $nombre,  $codigo, $materia
                        $obj = crearInscripcion(array($lineaPars["email"],$lineaPars["apellido"],$lineaPars["nombre"],$lineaPars["codigo"],$lineaPars["materia"]));
                        break;
                        
                    }
                    array_push($listaObj,$obj);
                    
                }
            }
        }
        return $listaObj;

    }



}

?>