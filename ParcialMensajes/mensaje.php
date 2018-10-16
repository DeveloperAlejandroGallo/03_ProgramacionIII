<?php

class mensaje
{
    public $remitente;
    public $destinatario;
    public $mensaje;
    public $foto;

    function __construct($remitente, $destinatario, $mensaje,  $foto)
    {
        $this->remitente = $remitente;
        $this->destinatario = $destinatario;
        $this->mensaje   = $mensaje;
        $this->foto   = $foto;
    }

    function clave()
    {
        return $this->remitente;
    }

    function clave2()
    {
        return $this->destinatario;
    }

    function descripcion()
    {
        return $this->nombre;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->remitente . $separador . $this->destinatario . $separador . 
        $this->mensaje . $separador . $this->foto . $separador . PHP_EOL;
    }


    static function title()
    {
        return "Mensajes";
    }

    static function header()
    {
        return "
        <tr>
            <th>Remitente</th>
            <th>Destinatario</th>
            <th>Mensaje</th>
            <th>Foto</th>
        </tr>";
    }
    

    function row()
    {
        return "<tr>
                    <td>$this->remitente</td>
                    <td>$this->destinatario</td>
                    <td>$this->mensaje</td>
                    <td><img src='".$this->foto."' alt='Sin foto' height='30' width='30'/></td>
                </tr>";
    }

    /**
     * 4- (1 pts.) caso: cargarMensaje (post): Se recibe el email del remitente, 
     * email del destinatario y mensaje y se guardan los datos en el archivo mensajes.txt.
     * ----
     * 8- (2 pts.) caso: cargarMensaje (post): Se deberá permitir cargar una foto en el mensaje.
     */

    public static function cargarMensaje($archivoMensajes,$carpetaFotos)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
    
            if(isset($_POST["remitente"]) && isset($_POST["destinatario"]) 
            && isset($_POST["mensaje"]) )
            {

                $entidad = "mensaje";    

                $remitente= $_POST["remitente"];
                $destinatario= $_POST["destinatario"];
                $mensaje= $_POST["mensaje"];

                $archMensajes = new archivo($archivoMensajes);

                $mensaje = new mensaje($remitente,$destinatario,$mensaje,null);
                $listMensajes = CSVtoArrayObj($entidad,$archMensajes);

                

                if(isset($_FILE["foto"]))
                {
                    $file = new File($_FILE["foto"]);
                    $file->newName = $_POST["remitente"].$File->Ext;
                    $file->newPath = "//fotomens//";
                    $file->moveFile();
                    $mensaje->foto = $file->newName . $file->newPath;
                }
                $archMensajes->save($mensaje);

                mostrarTodos($entidad,$archMensajes,mensaje::title(),mensaje::header());
                
            }        
            else
                msgInfo("No configuraron todas las variables.");
            
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    } 
    
    
    public static function mensajesEnviadosRecibidos($archivoMensajes, $enviadoRecibido)
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
                $tipoMsg ="";
                foreach($listMensajes as $msg)
                {
                    $push = false;
                    switch($enviadoRecibido)
                    {
                        case "E":
                            $tipoMsg = " Enviados";
                            if(strcasecmp($msg->remitente, $email)==0)
                                $push = true;
                        break;
                        case "R":
                            $tipoMsg = " Recibidos";
                            if(strcasecmp($msg->destinatario, $email)==0)
                                $push = true;
                        break;
                        default:
                            $push = false;
                        break;
                    }
                    if($push)
                        array_push($busqueda,$msg);
                     
                }     
                        
                listToTable(mensaje::title() . $tipoMsg,mensaje::header(),$busqueda);
            }
            else
                msgInfo("Faltan configurar parametros");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo GET.");
    }

    public static function mensajes($archivoMensajes)
    {
        $archMensajes = new archivo($archivoMensajes);
        mostrarTodos("usuario",$archMensajes,mensaje::title(),mensaje::header());
    }

}
?>