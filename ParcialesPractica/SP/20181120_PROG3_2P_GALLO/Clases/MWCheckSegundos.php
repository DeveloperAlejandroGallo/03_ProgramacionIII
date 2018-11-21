<?php

class MWCheckSegundos
{
    public function verificarSegundos($request, $response, $next)
    {
        //Hacer un middleware para todas las rutas que guarde en la BD los siguientes datos: usuario, metodo,ruta y hora.
        $obj = new stdClass();
        
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $obj->hora = date("H:i:s");
        $segundos = substr($obj->hora,6,2);
        $obj->segundos = $segundos;

        if($this->esPar($segundos))
        {
            $response = $response->withJson($obj,200);
            // echo "OK<br>HORA:<br>";
            // var_dump($obj);
            $newResponse = $next($request, $response);
        }
        else
        {
            $obj->respuesta = "Prohibido Pasar";
            // echo "NOT OK<br>HORA:<br>";
            // var_dump($obj);
            $newResponse = $response->withJson($obj,500);
        }
        return $newResponse;
    }

    private function esPar($nro)
    { 
        if($nro % 2 == 0) 
            return true;  
        else 
            return false;
         
    } 
}
?>