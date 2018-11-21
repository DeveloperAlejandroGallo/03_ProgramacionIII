<?php

class usuario
{
    public $nombre;
    public $apellido;
    public $email;
    public $foto;

    function __construct($email, $apellido, $nombre,  $foto)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->foto = $foto;
    }

    function clave()
    {
        return $this->email;
    }

    function descripcion()
    {
        return $this->apellido;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->email . $separador . $this->apellido . $separador . $this->nombre . $separador . $this->foto . $separador . PHP_EOL;
    }

    static function title()
    {
        return "Usuarios";
    }

    static function header()
    {
        return "
        <tr>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>EMail</th>
            <th>Foto</th>
        </tr>";
    }
    

    function row()
    {
        $foto = $this->foto;
        return "<tr>
                    <td>$this->apellido</td>
                    <td>$this->nombre</td>
                    <td>$this->email</td>
                    <td><img src='".$foto."' alt='Sin foto' height='30' width='30'/></td>
                </tr>";
    }


    public static function buscarUsuario($nombreArchivo)
    {    
        if($_SERVER["REQUEST_METHOD"] == "GET")
        {
            if(isset($_GET["apellido"]) )
            {
                $entidad = "usuario";
    
                $apellido = $_GET["apellido"];
                $archUsuarios = new archivo($nombreArchivo);
                $listUsuarios = CSVtoArrayObj($entidad,$archUsuarios);
                $busqueda = array(); 
                foreach($listUsuarios as $usr)
                {
                    if(strcasecmp($usr->apellido, $apellido)==0)
                        array_push($busqueda,$usr);
                }
    
                if(count($busqueda)>0)
                    listToTable(usuario::title(),usuario::header(),$busqueda);
                else
                    msgInfo("No existe usuario con apellido $apellido");
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo GET.");
    }


    public static function crearUsuario($archivoUsuario, $carpetaFotos)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["email"]) && isset($_POST["apellido"]) && isset($_POST["nombre"]) && isset($_FILES["foto"]))
            {
    
                $entidad = "usuario";            
                $email = $_POST["email"];
                $apellido = $_POST["apellido"];
                $nombre = $_POST["nombre"];
                $arrayFoto = $_FILES["foto"];
    
    
                $file = new File($arrayFoto);
                $file->newName = $email.$file->Ext;
                $file->newPath = $carpetaFotos;
                $file->moveFile();
                
                $archUsuario = new archivo($archivoUsuario);
                $usuario = new usuario($email,$apellido,$nombre, $file->newPath . $file->newName);
                $listUsuario = CSVtoArrayObj($entidad,$archUsuario);
                
                if(count($listUsuario)>0)
                {    
                    if(existeEnArray($listUsuario,$email) == -1)
                        $archUsuario->save($usuario);
                    else
                        msgInfo("El mail ($email) ya existe en la base.");
                }   
                else
                    $archUsuario->save($usuario); 

               mostrarTodos($entidad,$archUsuario,usuario::title(),usuario::header());
    
    
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    }


    public static function listarUsuarios($archivoUsuario)
    {
          
            $archUsuario = new archivo($archivoUsuario);
                
            mostrarTodos("usuario",$archUsuario,usuario::title(),usuario::header());
    
    }

    public static function modificarUsuario($archivoUsuarios,$carpetaFotos,$carpetaBkp)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["email"]) && isset($_POST["apellido"]) 
            && isset($_POST["nombre"]) && isset($_FILES["foto"]))
            {
    
                $email = $_POST["email"];
                $apellido = $_POST["apellido"];
                $nombre = $_POST["nombre"];
                $arrayFoto = $_FILES["foto"];
                
                $archUsuarios = new archivo($archivoUsuarios);
                
                $listUsuarios = CSVtoArrayObj("usuario",$archUsuarios);
                $i;

                if(count($listUsuarios) > 0 && $i = existeEnArray($listUsuarios,$email) != -1)
                {
                    $dirFoto = explode(".",($listUsuarios[$i])->foto);
                    
                    $ext = array_pop($dirFoto);
                    $nombreBkp = $carpetaBkp . $apellido . "_" . date("Ymd").".$ext";
                    if(!file_exists($carpetaBkp))
                        mkdir($carpetaBkp);
                    rename(($listUsuarios[$i])->foto,$nombreBkp);
                    
                    $file = new File($arrayFoto);
                    $file->newName = $email.$file->Ext;
                    $file->newPath = $carpetaFotos;
                    $file->moveFile();
                    
                    ($listUsuarios[$i])->apellido = $apellido;
                    ($listUsuarios[$i])->nombre = $nombre;
                    ($listUsuarios[$i])->foto = $file->newPath.$file->newName;
    
                    $archUsuarios->arrayToCSV($listUsuarios);
                    msgInfo("Usuario $apellido, $nombre ($email) - Modificado con Exito");
                }
                else
                    msgInfo("No existe el usuario $apellido, $nombre ($email)");
    
                mostrarTodos("usuario",$archUsuarios,usuario::title(),usuario::header());
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    }
    

}


?>