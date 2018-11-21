<?php
/**
* 5- (1pts.) caso: mensajesRecibidos (get): 
* Se recibe email del usuario y se muestran 
* todos los mensajes que recibió.
*6- (1pt.) caso: mensajesEnviados(get): Se recibe email del usuario y se muestran todos los mensajes que mando.
*/
include_once "./archivo.php";
include_once "./funciones.php";
include_once "./Entidades/mensaje.php";

function mensajesEnviadosRecibidos($archivoMensajes, $enviadoRecibido)
{
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if(isset($_GET["email"]))
        {
            $entidad = "mensaje";
            $email = $_GET["email"];
            $archMensajes = new archivo($archivoMensajes);
            $listMensajes = CSVtoArrayObj("mensaje",$archMensajes);
            $busqueda = array(); 

            foreach($listMensajes as $msg)
            {
                $push = false;
                switch($enviadoRecibido)
                {
                    case "E":
                        if(strcasecmp($msg->remitente, $email)==0)
                            $push = true;
                    break;
                    case "R":
                        if(strcasecmp($msg->receptor, $email)==0)
                            $push = true;
                    break;
                    case "T":
                        $push = true;
                    break;
                    default:
                        $push = false;
                    break;
                }
                if($push)
                    array_push($busqueda,$msg);
                 
            }     
                    
            listToTable(mensaje::title(),mensaje::header(),$busqueda);
        }
    }
    else
        msgInfo("ERROR: Se debe llamar con metodo GET.");
}

?>