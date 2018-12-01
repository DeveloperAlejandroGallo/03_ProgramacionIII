<?php

require_once "clases/accesoDatos.php";
require_once "mesas.php";

class pedidos{

//--------------------------------------------------------------------------------//
//--ATRIBUTOS    

public $id;
public $idEmpleado;    
public $estado;
public $cliente;
public $mesa;
public $idArticulo;
public $cantidad;
public $importe;
public $codigo;
public $foto;
public $estimado;
public $horaInicio;
public $horaFin;



    //--------------------------------------------------------------------------------//




public function GenerarCodigo($valor){

$cant = strlen($valor);
if($cant <2 ){
    $cod = $valor.str_shuffle("PBWU");
}
elseif(strlen($valor)<3){
    $cod =$valor.str_shuffle("JOS");
}
else{
    $cod =$valor.str_shuffle("RQ");
}

return $cod;

}



public function setestado($valor){
    $estados = array("pendientes", "en preparacion", "listo para servir", "entregado");
    if (in_array($valor, $estados)) {
        $this->estado = $valor;
        return true;
    } else {
        return false;
    }
}



//--------------------------------------------------------------------------------//
//--METODOS	

//--GUARDAR

public function InsertarUno()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedidos (idEmpleado,estado,cliente,mesa,idArticulo,cantidad,importe,codigo,foto,horaInicio)values(:idEmpleado,:estado,:cliente,:mesa,:idArticulo,:cantidad,:importe,:codigo,:foto,:horaInicio)");
				$consulta->bindValue(':idEmpleado',$this->idEmpleado, PDO::PARAM_INT);
				$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
                $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
                $consulta->bindValue(':mesa', $this->mesa, PDO::PARAM_STR);
                $consulta->bindValue(':idArticulo',$this->idArticulo, PDO::PARAM_INT);
				$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
                $consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
                $consulta->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
                $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
                $consulta->bindValue(':horaInicio', $this->horaInicio, PDO::PARAM_STR);
                $consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }


      
    



public function BorrarId($id){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from pedidos 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
				$retorno = $consulta->execute();
				return $consulta->rowCount();
    
 
}


public function Modificarestado()
{
        
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           estimado= :estimado
           WHERE id=:id");
       $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindValue(':estimado', $this->estimado, PDO::PARAM_STR);
       return $consulta->execute();   
     
}

public function TraerId($id){
    $retorno;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos WHERE id='$id'");
    $consulta->execute(); 
    $retorno = $consulta->fetchObject('pedidos'); 
    if($retorno != null){
        //var_dump($retorno);
        return $retorno;
    }
    else{
        return null;
    }
}





public function verificarPedido($mesa){
   
    $retorno;
    $estado="pendiente";
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos WHERE mesa=? AND estado=?");
    $consulta->execute(array($mesa,$estado)); 
    $resultado = $consulta->fetchObject('pedidos'); 
    if($resultado ){
        
        return $resultado->codigo;
    }
    else{
        $retorno = null;
    }
    
    return $retorno;
}

//--TRAER
public function traerTodos($fecha){

   
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id as idpedido, p.mesa as mesa,p.estado as estado,p.cliente as cliente,c.descripcion as articulo,p.cantidad as cant,p.codigo as codigo,p.foto as foto,e.nombre AS empleado ,p.estimado as estimado,p.horaInicio as inicio,p.horaFin as fin FROM pedidos as p ,carta as c, empleados as e WHERE p.idArticulo=c.id AND e.id=p.idEmpleado AND p.horaInicio >= '$fecha 00:00:00' AND p.horaInicio <= '$fecha 23:59:59' ");
    
    $consulta->execute(); 
    return $consulta->fetchAll();	
}



//--Consultar segun estado y estado
public function Consultar($id,$tipo){

    $retorno=null;

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos,carta WHERE pedidos.idArticulo=carta.id AND sector=? AND pedidos.id=?");
    $consulta->execute(array($tipo,$id)); 
    $pedido = $consulta->fetchObject('pedidos'); 
    if($pedido != null){

        if($pedido->estado =="pendiente")
        {
            $retorno= true;
        }

    }
    return $retorno;
}

public function ConsultarTipo($id,$tipo){

    $retorno=null;

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos,carta WHERE pedidos.idArticulo=carta.id AND sector=? AND pedidos.id=?");
    $consulta->execute(array($tipo,$id)); 
    $pedido = $consulta->fetchObject('pedidos'); 
    if($pedido != null){

        if($pedido->estado =="pendiente" ||$pedido->estado =="en preparacion" )
        {
            $retorno= true;
        }

    }
    return $retorno;
}

public function ConsultarEstado($id,$estado){

    $retorno=null;

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos WHERE pedidos.id=? AND pedidos.estado=?");
    $consulta->execute(array($id,$estado)); 
    $pedido = $consulta->fetchObject('pedidos'); 
    if($pedido != null){
        $retorno= true;
    }
    return $retorno;
}

public function TraerIdMesa($codigo,$estado){
    $retorno=null;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT mesa FROM pedidos WHERE codigo=? and estado!= ? ");
    $consulta->execute(array($codigo,$estado)); 
    $respuesta =$consulta->fetchObject(); 
    if($respuesta != null){
        //var_dump($retorno);
        $retorno=$respuesta;
    }
    return $retorno;
}


    public function TraerPedidosSector($tipo,$fecha){

        $estado="pendiente";
        $estado1="en preparacion";

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id as idpedido,p.cliente as cliente,p.mesa as mesa,c.descripcion as articulo,p.cantidad as cant,p.estado as estado FROM pedidos as p ,carta as c WHERE p.idArticulo=c.id AND c.sector=? AND  (p.estado=? OR p.estado=?)AND p.horaInicio >= '$fecha 00:00:00' AND p.horaInicio <= '$fecha 23:59:59' ");
        $consulta->execute(array($tipo,$estado,$estado1)); 
        return $consulta->fetchAll(); 
        


    } 

    public function GenerarTabla($pedidos,$tipo){
        $tabla;
        if($tipo == 'socios'){
            $tabla ="<h3 align='center'>Todos Los Pedidos</h3>";

            $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Mesa</th><th>Estado</th><th>Cliente</th><th>Articulo</th><th>cantidad</th><th>codigo</th><th>foto</th><th>empleado</th><th>estimado</th><th>Inicio</th><th>Fin</th>";    
        foreach($pedidos as $aux) {
            
           if($aux['foto'] == "sin foto"){
            $tabla .="<tr align='center'><td>".$aux['mesa']."</td><td>".$aux['estado']."</td><td>".$aux['cliente']."</td><td>".$aux['articulo']."</td><td>".$aux['cant']."</td><td>".$aux['codigo']."</td><td>".$aux['foto']."</td><td>".$aux['empleado']."</td><td>".$aux['estimado']."</td><td>".$aux['inicio']."</td><td>".$aux['fin']."</td></tr>";
           }else{
            $tabla .="<tr align='center'><td>".$aux['mesa']."</td><td>".$aux['estado']."</td><td>".$aux['cliente']."</td><td>".$aux['articulo']."</td><td>".$aux['cant']."</td><td>".$aux['codigo']."</td><td><img src='/comanda1/fotos/".$aux['foto']." 'width='100px' height='100px' ></td><td>".$aux['empleado']."</td><td>".$aux['estimado']."</td><td>".$aux['inicio']."</td><td>".$aux['fin']."</td></tr>";
           }
           
                  
        } 

        $tabla .="</table>";
        }else{
        
            $tabla ="<h3 align='center'>Pedidos $tipo</h3>";

            $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>idPedido</th><th>Cliente</th><th>mesa</th><th>Articulo</th><th>cantidad</th><th>estado</th>";    
        foreach($pedidos as $aux ) {
            
           
           $tabla .="<tr align='center'><td>".$aux['idpedido']."</td><td>".$aux['cliente']."</td><td>".$aux['mesa']."</td><td>".$aux['articulo']."</td><td>".$aux['cant']."</td><td>".$aux['estado']."</td></tr>";
                  
        } 

        $tabla .="</table>";
        }
        
        return $tabla;


    }

    ///Traer codigo mesa
    public function traerMesa($fecha){

   
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id as idpedido, p.mesa as mesa,p.estado as estado,p.cliente as cliente,c.descripcion as articulo,p.cantidad as cant,p.codigo as codigo,p.foto as foto,e.nombre AS empleado ,p.estimado as estimado,p.horaInicio as inicio,p.horaFin as fin FROM pedidos as p ,carta as c, empleados as e WHERE p.idArticulo=c.id AND e.id=p.idEmpleado AND p.horaInicio >= '$fecha 00:00:00' AND p.horaInicio <= '$fecha 23:59:59' ");
        
        $consulta->execute(); 
        return $consulta->fetchAll();	
    }
    




    
    ///Tomar pedido
    public function TomarPedido(){

       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           estimado= :estimado,
           idEmpleado= :idEmpleado
           WHERE id=:id");
       $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindValue(':estimado', $this->estimado, PDO::PARAM_STR);
       $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       return $consulta->execute();



    }


    public function PedidoTerminado(){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           horaFin= :horaFin,
           idEmpleado= :idEmpleado
           WHERE id=:id");
       $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindValue(':horaFin', $this->horaFin, PDO::PARAM_STR);
       $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       return $consulta->execute();


    }
     
    public function PedidoEntregado(){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           idEmpleado= :idEmpleado
           WHERE id=:id");
       $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       return $consulta->execute();


    }

    public function PedidoCancelado(){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           idEmpleado= :idEmpleado
           WHERE id=:id");
       $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindValue(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       return $consulta->execute();


    }

    public function CerrarPedido($mesa){

       
        $retorno=  null;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM pedidos WHERE mesa=? AND estado!='pagado' AND estado !='cancelado' ");
        $consulta->execute(array($mesa)); 
        $pedidos= $consulta->fetchAll(PDO::FETCH_CLASS, "pedidos"); 
        //$retorno= $pedidos;
        if($pedidos != null){
            foreach($pedidos as $aux){

                if($aux->estado != "entregado"){
                    $retorno= null;
                    break;
                }
                $retorno= $pedidos;
            }
            
        }
        return $retorno;

    }

    public function PedidoPagado($id){
        
        $estado="pagado";
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado           
           WHERE id=:id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->bindValue(':estado',$estado, PDO::PARAM_INT);
        return $consulta->execute();   


    }


    public function GenerarTablaTiempo($pedidos){
        $tabla;
        if($pedidos != null){
            $tabla ="<h3 align='center'>Tiempo estimado del pedido</h3>";
            
            $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>Id</th><th>Articulo</th><th>Estimado</th><th>HoraInicio</th><th>HoraEntrega</th>";    
        foreach($pedidos as $aux) {        
           
            $tabla .="<tr align='center'><td>".$aux->id."</td><td>".$aux->articulo."</td><td>".$aux->estimado."</td><td>".$aux->horaInicio."</td><td>".$aux->horaEntrega."</td></tr>";
        }
        $tabla .="</table>";
        }       
        return $tabla;       
    
    }



    ///tiempo restante pedido
    public function CalcularTiempo($codigoPedido,$codigoMesa){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id as id ,carta.descripcion as articulo,(sec_to_time(timestampdiff(SECOND,now(), DATE_ADD(p.horaInicio, INTERVAL p.estimado MINUTE) ))) as estimado, p.horaInicio as horaInicio,DATE_ADD(p.horaInicio, INTERVAL p.estimado MINUTE) as horaEntrega FROM pedidos as p, mesas as m,carta WHERE p.mesa=m.id and p.codigo='$codigoPedido' and m.codigo='$codigoMesa' AND carta.id=p.idArticulo ");
        $consulta->execute(); 
        $pedidos= $consulta->fetchAll(PDO::FETCH_CLASS, "pedidos"); 
    
        return $pedidos;
    } 

   // SELECT carta.descripcion as articulo,p.estimado as estimado, p.horaInicio as horaInicio FROM pedidos as p, mesas as m,carta  WHERE p.mesa=m.id and p.codigo= '2BWUP' and m.codigo='LTOX2' AND carta.id=p.idArticulo
/*SELECT carta.descripcion as articulo,(sec_to_time(timestampdiff(SECOND,now(), DATE_ADD(p.horaInicio, INTERVAL p.estimado MINUTE)  ))) as estimado, p.horaInicio as horaInicio FROM pedidos as p, mesas as m,carta  WHERE p.mesa=m.id and p.codigo= '2BWUP' and m.codigo='LTOX2' AND carta.id=p.idArticulo*/






}

?>