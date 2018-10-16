<?php

class proveedor
{
    public $id;
    public $nombre;
    public $email;
    public $foto;

    function __construct($id, $nombre, $email, $foto)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->foto = $foto;
    }

    function clave()
    {
        return $this->id;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->id . $separador . $this->nombre . $separador . $this->email . $separador . $this->foto . $separador . PHP_EOL;
    }

    static function title()
    {
        return "Proveedores";
    }

    static function header()
    {
        return "
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>EMail</th>
            <th>Foto</th>
        </tr>";
    }
    

    function row()
    {
        $foto = $this->foto;
        return "<tr>
                    <td>$this->id</td>
                    <td>$this->nombre</td>
                    <td>$this->email</td>
                    <td><img src='".$foto."' alt='Sin foto' height='30' width='30'/></td>
                </tr>";
    }

    /**1- (2 pt.) caso: cargarProveedor (post): Se deben guardar los siguientes datos: id, nombre, email y foto. 
     * Los datos se guardan en el archivo de texto proveedores.txt, tomando el id como identificador. */

    public static function cargarProveedor($archivoProveedor, $carpetaFotos)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if( isset($_POST["id"]) && isset($_POST["email"]) && isset($_POST["nombre"]) && isset($_FILES["foto"]))
            {
    
                $entidad = "proveedor";    

                $id = $_POST["id"];
                $email = $_POST["email"];
                $nombre = $_POST["nombre"];
                $arrayFoto = $_FILES["foto"];
    
    
                $file = new File($arrayFoto);
                $file->newName = $file->Name;
                $file->newPath = $carpetaFotos;
                $file->moveFile();
                
                $archProveedor = new archivo($archivoProveedor);
                $proveedor = new proveedor($id,$nombre,$email, $file->newPath . $file->newName);
                $listProveedor = CSVtoArrayObj($entidad,$archProveedor);
                
                if(count($listProveedor)>0)
                {    
                    if(existeEnArray($listProveedor,$id) == -1)
                    {
                        $archProveedor->save($proveedor);
                        msgInfo("Proveedor $nombre ($id) dado de alta con exito.");
                    }
                    else
                        msgInfo("El id ($id) ya existe en la base.");
                }   
                else
                {
                    $archProveedor->save($proveedor); 
                    msgInfo("Proveedor $nombre ($id) dado de alta con exito.");
                }
               
               mostrarTodos($entidad,$archProveedor,proveedor::title(),proveedor::header());
    
    
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    }


    /**2- (2pt.) caso: consultarProveedor (get): Se ingresa nombre, si coincide con algún registro del 
     * archivo proveedores.txt se retorna las ocurrencias, si no coincide se debe retornar 
     * “No existe proveedor xxx” (xxx es el nombre que se buscó) La búsqueda tiene que ser case insensitive. */
    public static function consultarProveedor($nombreArchivo)
    {    
        if($_SERVER["REQUEST_METHOD"] == "GET")
        {
            if(isset($_GET["nombre"]) )
            {
                $entidad = "proveedor";
    
                $nombre = $_GET["nombre"];
                $archProveedores = new archivo($nombreArchivo);
                $listProveedores = CSVtoArrayObj($entidad,$archProveedores);
                $busqueda = array(); 
                foreach($listProveedores as $prov)
                {
                    if(strcasecmp($prov->nombre, $nombre)==0)
                        array_push($busqueda,$prov);
                }
    
                if(count($busqueda)>0)
                    listToTable(proveedor::title(),proveedor::header(),$busqueda);
                else
                    msgInfo("No existe proveedor $nombre");
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo GET.");
    }


    public static function listarProveedores($archivoProveedor)
    {
          
            $archProveedor = new archivo($archivoProveedor);
                
            mostrarTodos("proveedor",$archProveedor,proveedor::title(),proveedor::header());
    
    }

    public static function modificarProveedor($archivoProveedores,$carpetaFotos,$carpetaBkp)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["email"]) && isset($_POST["id"]) 
            && isset($_POST["nombre"]) && isset($_FILES["foto"]))
            {
    
                $id = $_POST["id"];
                $email = $_POST["email"];
                $nombre = $_POST["nombre"];
                $arrayFoto = $_FILES["foto"];
                
                $archProveedores = new archivo($archivoProveedores);
                
                $listProveedores = CSVtoArrayObj("proveedor",$archProveedores);
                $i;

                if(count($listProveedores) > 0 && $i = existeEnArray($listProveedores,$id) != -1)
                {
                    $dirFoto = explode(".",($listProveedores[$i])->foto);
                    
                    $ext = array_pop($dirFoto);
                    $nombreBkp = $carpetaBkp . $id . "_" . date("Ymd").".$ext";
                    if(!file_exists($carpetaBkp))
                        mkdir($carpetaBkp);

                    rename(($listProveedores[$i])->foto,$nombreBkp);
                    
                    $file = new File($arrayFoto);
                    $file->newName = $file->Name;
                    $file->newPath = $carpetaFotos;
                    $file->moveFile();
                    
                    ($listProveedores[$i])->email = $email;
                    ($listProveedores[$i])->nombre = $nombre;
                    ($listProveedores[$i])->foto = $file->newPath.$file->newName;
    
                    $archProveedores->arrayToCSV($listProveedores);
                    msgInfo("Proveedor $nombre ($id) - Modificado con Exito");
                }
                else
                    msgInfo("No existe el proveedor $nombre ($id)");
    
                mostrarTodos("proveedor",$archProveedores,proveedor::title(),proveedor::header());
            }
            else
                msgInfo("No configuraron todas las variables.");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    }
    

    public static function fotosBack($archivoProveedores,$carpetaBkp)
    {
        $directorio = opendir($carpetaBkp); 

        $archProveedores = new archivo($archivoProveedores);
        
        $listProveedores = CSVtoArrayObj("proveedor",$archProveedores);

        echo "<h2>Backup Fotos</h2>";
        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (is_dir($archivo))//verificamos si es o no un directorio
            {
                echo "[".$archivo . "]<br /><br /> Es directorio"; //de ser un directorio lo envolvemos entre corchetes
            }
            else
            {
                $nombreArchivo = explode("_",$archivo);
                $idProv = $nombreArchivo[0];
                $fechaArch = $nombreArchivo[1];
                $i = existeEnArray($listProveedores,$idProv);
                
                echo "<br><b>Proveedor: </b> ".($listProveedores[$i])->nombre . "- <b>Fecha: </b> $fechaArch<br />";
            }
         }
    }
}
?>






    }

}


?>