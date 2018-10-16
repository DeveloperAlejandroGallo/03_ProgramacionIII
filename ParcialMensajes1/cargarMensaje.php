<?php
/**
 *  4- (1 pts.) caso: cargarMensaje (post): Se recibe el email del remitente, email del destinatario 
 *  y mensaje y se guardan los datos en el archivo mensajes.txt.
 * 
 * 8-(2 pts.) caso: cargarMensaje (post): Se deberá permitir cargar una foto en el mensaje.
* */


include_once "./Entidades/mensaje.php";
include_once "./archivo.php";
include_once "./funciones.php";


function cargarMensaje($archivoMensajes,$altaModif)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
  
        if(isset($_POST["remitente"]) && isset($_POST["destinatario"]) 
        && isset($_POST["mensaje"]) )
        {

            //$fileMensajesJson = new archivoJson($archivoMensajesJson);
            $entidad = "mensaje";    

            $remitente= $_POST["remitente"];
            $destinatario= $_POST["destinatario"];
            $mensaje= $_POST["mensaje"];

            $archMensajes = new archivo($archivoMensajes);

            $mensaje = new mensaje($remitente,$destinatario,$mensaje);
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
?>