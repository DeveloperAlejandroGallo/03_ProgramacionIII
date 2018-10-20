<?php

class AccesoDatos
{
    private static $ObjetoAccesoDatos;
    private $objetoPDO;
 
    private function __construct($host,$dbName,$usr,$psw)
    {
        try { 
            $this->objetoPDO = new PDO('mysql:host='.$host.';dbname='.$dbName.';charset=utf8', $usr, $psw); //, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            $this->objetoPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->objetoPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
            } 
        catch (PDOException $e) 
        { 
            print "Error!: " . $e->getMessage(); 
            die();
        }
    }
 
    public function execQuery($sql)
    { 
        return $this->objetoPDO->prepare($sql); 
    }
     public function getLastId()
    { 
        return $this->objetoPDO->lastInsertId(); 
    }
 
    public static function getDataAccess()
    { 
        if (!isset(self::$ObjetoAccesoDatos)) {          
            self::$ObjetoAccesoDatos = new AccesoDatos(); 
        } 
        return self::$ObjetoAccesoDatos;        
    }
 
 
     // Evita que el objeto se pueda clonar
    public function __clone()
    { 
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 
    }

/**TRAER TODOS */
    public function selectAll($table)
    {
        $consulta = "select * from $tabla";
        $exec = $this->RetornarConsulta($consulta);
        $exec->execute();
        return $exec->FetchAll();
    }

    public function insertObject($obj)
    {
        try
        {
            $script  ="insert into ".$obj->table()." values (".$obj->getValues()." )";
            $this->$objetoPDO->exec($script);
            return $this->$objetoPDO->lastInsertId();
        }
        catch (PDOException $ex)
        {
            print "Error!: " . $ex->getMessage(); 
            die();
        }
        
    }

    


}
?>