<?php

require_once "clases/accesoDatos.php";
require_once "clases/login.php";

class empleados{

//--------------------------------------------------------------------------------//
//--ATRIBUTOS    

public $id;    
public $nombre;
public $tipo;
private $pass;
public $estado;





    //--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS

public function getid(){
    return $this->id;
}
public function setid($valor){
$this->id = $valor;
}


public function getnombre(){
    return $this->nombre;
}
public function setnombre($valor){
$this->nombre = $valor;
}



public function gettipo(){
    return $this->tipo;
    }
    
public function settipo($valor){
    $tipos = array("bartender", "cerveceros", "cocineros","mozos", "socios");
    if (in_array($valor, $tipos)) {
        $this->tipo = $valor;
        return true;
    } else {
        return false;
    }
}

public function getpass(){
    return $this->pass;
    }
    
public function setpass($valor){
    $this->pass = $valor;
}





//--------------------------------------------------------------------------------//


//--GUARDAR


public function InsertarUno()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados (nombre,tipo,pass,estado)values(:nombre,:tipo,:pass,:estado)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
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



public function ModificarUno($id)
{
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update empleados 
           set estado=:estado
           WHERE id=:id");
       $consulta->bindValue(':id',$id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       
       return $consulta->execute();
}

public function TraerId($id){
    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados WHERE id=?");
    $consulta->execute(array($id)); 
    $retorno = $consulta->fetchObject('empleados'); 
    if($retorno != null){
        //var_dump($retorno);
        return $retorno;
    }
    else{
        return null;
    }
}

//---------Login-----------//




//verificar  tipo de usuario
public function verificarlogin($nombre,$pass){
   
    $retorno = null;

    $estado= "activo";
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados WHERE nombre=? AND pass=? AND estado=?");
    $consulta->execute(array($nombre,$pass,$estado));
    $resultado = $consulta->fetchObject('empleados'); 
    
    if($resultado != null){
        $dato = array(
            'id'=>$resultado->id,
            'nombre'=>$resultado->nombre,
            'tipo' =>$resultado->tipo            				
        );
                
        $retorno= login::NuevoToken($dato);
    }
    else{
        $retorno= "Usuario o pass incorrectos";
    }
       

    return $retorno;

}


//Guardar Login 
public function GuardarIngreso($datos,$empleado){

    $nombre=$empleado->nombre;
    $id=$empleado->id;
    $tipo=$empleado->tipo;
    $metodo= $datos['metodo'];
	$ruta= $datos['ruta'];

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into login (nombre,idEmpleado,tipo,metodo,ruta)values(:nombre,:idEmpleado,:tipo,:metodo,:ruta)");
    $retorno =  $consulta->execute(array($nombre,$id,$tipo,$metodo,$ruta));   
    //return $retorno;

}

//Traer todos los log si sos socios
public function traerLogs(){

     $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
     $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM login ");
      $consulta->execute(); 
     return $consulta->fetchAll(PDO::FETCH_CLASS, "empleados");	
     
 
 }







//--TRAER
public function traerTodos(){

 
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados ");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_CLASS, "empleados");	
    
}


//--Consultar segun turno y tipo
public function Consultar($tipo){

    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados WHERE  tipo=?  ");
    $consulta->execute(array($tipo)); 
    $retorno = $consulta->fetchAll(); 
    if($retorno != null){
        return $retorno;
    }
    else{
        return null;
    }





}

public function GenerarTabla($empleados){
    $tabla;
    if($empleados != null){
        $tabla ="<h3 align='center'>Listado de  Empleados</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Id</th><th>Nombre</th><th>Tipo</th><th>Estado</th>";    
    foreach($empleados as $aux) {        
       
        $tabla .="<tr align='center'><td>".$aux->id."</td><td>".$aux->nombre."</td><td>".$aux->tipo."</td><td>".$aux->estado."</td></tr>";
    }
    $tabla .="</table>";
    }
   
    
    
    return $tabla;
    

}


public function GenerarTablaLogs($empleados){
    $tabla;
    if($empleados != null){
        $tabla ="<h3 align='center'>Listado de  Empleados</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>IdEmpleado</th><th>Nombre</th><th>Tipo</th><th>Metodo</th><th>Ruta</th><th>Fecha</th><th>Hora  </th>";    
    foreach($empleados as $aux) {        
       
        $tabla .="<tr align='center'><td>".$aux->idEmpleado."</td><td>".$aux->nombre."</td><td>".$aux->tipo."</td><td>".$aux->metodo."</td><td>".$aux->ruta."</td><td>".$aux->fecha."</td><td>".$aux->hora."</td></tr>";
    }
    $tabla .="</table>";
    }
   
    
    
    return $tabla;
    

}
    

public function GenerarTablaCantidadDeLogs($empleados){
    $tabla;
    if($empleados != null){
        $tabla ="<h3 align='center'>Cantidad de operaciones de todos por sector</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Tipo</th><th>Cantidad</th>";    
    foreach($empleados as $aux) {        
       
        $tabla .="<tr align='center'><td>".$aux->tipo."</td><td>".$aux->cant."</td></tr>";
    }
    $tabla .="</table>";
    }
   return $tabla;
}


public function GenerarTablaPorEmpleado($empleados){
    $tabla;
    if($empleados != null){
        $tabla ="<h3 align='center'>Cantidad de operaciones de todos por Empleado</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Id</th><th>Nombre</th><th>Tipo</th><th>Cantidad</th>";    
               
        $tabla .="<tr align='center'><td>".$empleados->idEmpleado."</td><td>".$empleados->nombre."</td><td>".$empleados->tipo."</td><td>".$empleados->cant."</td></tr>";
    
    $tabla .="</table>";
    }
   
    
    
    return $tabla;
    

}

public function GenerarTablaCantidadDeLogsPorSeparado($empleados){
    $tabla;
    if($empleados != null){
        $tabla ="<h3 align='center'>Cantidad de operaciones de todos  listada por cada empleado</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Nombre</th><th>Cantidad</th>";    
    foreach($empleados as $aux) {        
       
        $tabla .="<tr align='center'><td>".$aux->nombre."</td><td>".$aux->cant."</td></tr>";
    }
    $tabla .="</table>";
    }
   return $tabla;
}


public function TraerCantidadDeLogs(){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo as tipo, count(*) as cant FROM `login` WHERE tipo='socios' 
    UNION SELECT tipo as tipo, count(*) as cant FROM `login` WHERE tipo='mozos'UNION
    SELECT tipo as tipo, count(*) as cant FROM `login` WHERE tipo='cocineros'
    UNION   SELECT tipo as tipo, count(*) as cant FROM `login` WHERE tipo='cerveceros'
    UNION SELECT tipo as tipo, count(*) as cant FROM `login` WHERE tipo='bartender'");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_CLASS, "empleados");

   
}

public function TraerCantidadDeLogsPorSeparado(){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT  nombre as nombre ,COUNT(*) as cant  FROM `login` GROUP BY nombre");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_CLASS, "empleados");

   
}




public function TraerCantidadPorEmpleado($id){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT idEmpleado as idEmpleado, nombre as nombre,tipo as tipo, count(*) as cant FROM `login` WHERE idEmpleado=$id");  //("SELECT nombre as nombre, tipo as tipo, COUNT(*) as cant FROM `login` WHERE idEmpleado=$id");
    $consulta->execute(); 
    $retorno = $consulta->fetchObject('empleados');//fetchAll(PDO::FETCH_CLASS, "empleados"); 
    return $retorno;       

}


}


?>