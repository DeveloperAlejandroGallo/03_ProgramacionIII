<?php

require_once "clases/accesoDatos.php";
require_once "clases/login.php";
require_once "clases/AutentificadorJWT.php";

class empleados
{

   

public $id;    
public $nombre;
public $tipo;
public $pass;
public $estado;


public function InsertarUno()
	 {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados (nombre,tipo,pass,estado)values(:nombre,:tipo,:pass,:estado)");
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':pass', $this->pass, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();		
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }



public function BorrarId($id){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from empleados 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
				$retorno = $consulta->execute();
				return $consulta->rowCount();
               
  
}

public function Modificar($id,$estado)
{
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update empleados 
           set estado=:estado
           WHERE id=:id");
       $consulta->bindValue(':id',$id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$estado, PDO::PARAM_STR);
       
       return $consulta->execute();
}

public function TraerId($nombre)
{
    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("select id from empleados where nombre=:nombre");
    $consulta->bindValue(":nombre",$nombre, PDO::PARAM_STR);
    $consulta->execute();
    $retorno = $consulta->fetch(PDO::FETCH_OBJ);

    if($retorno != null)
       return $retorno->id;
    else
        return null;
    
}

/*Login*/


public static function obtenerEmpleado($nombre) 
{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from empleados where nombre = :nombre");
        $consulta->bindParam(':nombre',$nombre,PDO::PARAM_STR);
        $consulta->execute();
        $usuarioBuscado= $consulta->fetchObject('empleados');
        return $usuarioBuscado;				
        
}



//Guardar Login 
public function GuardarIngreso($datos,$empleado)
{

    $nombre=$empleado->nombre;
    $id=$empleado->id;
    $tipo=$empleado->tipo;
    $metodo= $datos['metodo'];
	$ruta= $datos['ruta'];

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta(
        "INSERT into login (nombre,idEmpleado,tipo,metodo,ruta)
        values(:nombre,:idEmpleado,:tipo,:metodo,:ruta)");
    $retorno =  $consulta->execute(array($nombre,$id,$tipo,$metodo,$ruta));   
    //return $retorno;

}

//Traer todos los log si sos socios
public function traerLogs()
{

     $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
     $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM login ");
      $consulta->execute(); 
     return $consulta->fetchAll(PDO::FETCH_CLASS, "login");	
     
 
 }


//--TRAER
public function obtenerTodos(){

 
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados ");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_CLASS, "empleados");	
    
}


public function Consultar($tipo){

    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados WHERE  tipo=:tipo  ");
    $consulta->bindParam(":tipo",$tipo,PDO::PARAM_STR);
    $consulta->execute(); 
    $retorno = $consulta->fetchAll(PDO::FETCH_CLASS, "empleados"); 
    if($retorno != null){
        return $retorno;
    }
    else{
        return null;
    }





}


public function TraerCantidadDeLogs()
{

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("select Tipo , count(*) Ingresos from login group by tipo");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_ASSOC);

   
}

public function TraerCantidadDeLogsPorSeparado(){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("select Nombre, count(*) as Ingresos  FROM login GROUP BY nombre");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_ASSOC);

   
}




public function TraerCantidadPorEmpleado($nombre)
{

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("select Nombre, Tipo, count(*) Ingresos FROM login  where nombre=:nombre group by  nombre ,tipo"); 
    $consulta->bindParam(':nombre',$nombre,PDO::PARAM_STR);
    $consulta->execute(); 
    $retorno = $consulta->fetchAll(PDO::FETCH_ASSOC);//fetchAll(PDO::FETCH_CLASS, "empleados"); 
    
    return $retorno;       

}


}


?>