<?php

require_once "clases/accesoDatos.php";

class mesas{

//--------------------------------------------------------------------------------//
//--ATRIBUTOS    

public $id;    
public $codigo;
public $estado;




public function GenerarCodigo($valor){
$cant = strlen($valor);
if($cant <2 ){
    $this->codigo = str_shuffle("XOLT").$valor;
}
elseif(strlen($valor)<3){
    $this->codigo = str_shuffle("MYA").$valor;
}
else{
    $this->codigo = str_shuffle("ZB").$valor;
}

}

public function InsertarUno()
{       
     $dato =mesas::verificarMesa($this->id);     

        if($dato === null){

            mesas::GenerarCodigo($this->id);
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into mesas (id,codigo,estado)values(:id,:codigo,:estado)");
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
            $consulta->bindValue(':codigo',$this->codigo, PDO::PARAM_INT);
            $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
            $consulta->execute();  
            $retorno ="El codigo de la mesa es: $this->codigo" ;
        }
        else{

           $retorno = "El codigo de la mesa es: $dato->codigo";
        }

        return $retorno;

}



public function BorrarId($id){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from mesas 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
				$retorno = $consulta->execute();
				return $consulta->rowCount();
    
 
}


public function Modificarestado()
{
         
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
       update mesas 
       set estado='$this->estado'				
       WHERE id='$this->id'");
       return $consulta->execute();
         
}

public function TraerId($id){
    $retorno=null;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE id=?");
    $consulta->execute(array($id)); 
    $respuesta = $consulta->fetchObject('mesas'); 
    if($respuesta != null){
        //var_dump($retorno);
        $retorno= $respuesta;
    }
    
    return $retorno;
}





public function verificarMesa($id){
   
    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE id=?");
    $consulta->execute(array($id)); 
    $resultado = $consulta->fetchObject('mesas'); 
    if($resultado!=null ){
        
        $retorno= $resultado;
    }
    else{
        $retorno = null;
    }
    
    return $retorno;
}

//--TRAER
public function traerTodos(){

   // $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas ");
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_CLASS, "mesas");	
    
}



//--Consultar segun estado y tipo
public function Consultar($id){

    $retorno= null;
    $miMesa=mesas::verificarMesa($id);
    if($miMesa != null){
       

    }
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE estado='$estado' AND tipo= '$tipo'  ");
    $consulta->execute(); 
    $retorno = $consulta->fetchAll(); 
    if($retorno != null){
        return $retorno;
    }
    else{
        return null;
    }

}


public function ConsultarEstado($id){

    $retorno= null;     

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE id=?  ");
    $consulta->execute(array($id)); 
    $respuesta = $consulta->fetchObject('mesas'); 
    if($respuesta != null){
        $retorno = $respuesta->estado;
    } 
    
    
    return $retorno;
}

public function CerrarMesa($id){
    $estado= "cerrada";
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
    update mesas 
    set estado='$estado'				
    WHERE id='$id'");
    return $consulta->execute();
}

public function ModificarMesa($id,$estado){
    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
    update mesas 
    set estado='$estado'				
    WHERE id='$id'");
    return $consulta->execute();
}



public function GenerarTabla($mesas){
    $tabla;
    if($mesas != null){
        $tabla ="<h3 align='center'>Esado de Las Mesas</h3>";

        $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Mesa</th><th>Estado</th><th>Codigo</th>";    
    foreach($mesas as $aux) {        
       
        $tabla .="<tr align='center'><td>".$aux->id."</td><td>".$aux->estado."</td><td>".$aux->codigo."</td></tr>";
    }
    $tabla .="</table>";
    }
   
    
    
    return $tabla;
    

}


}


?>