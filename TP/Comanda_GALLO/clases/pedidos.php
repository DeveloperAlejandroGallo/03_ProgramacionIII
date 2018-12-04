<?php

require_once "clases/accesoDatos.php";
require_once "mesas.php";

class pedidos{

//--------------------------------------------------------------------------------//
//--ATRIBUTOS    

public $id;
public $codigo;
public $idMesa;
public $idArticulo;
public $idEmpleado;    
public $cliente;
public $cantidad;
public $importe;
public $foto;
public $estado; //"pendientes", "en preparacion", "listo para servir", "entregado"
public $estimado;
public $horaInicio;
public $horaFin;



    //--------------------------------------------------------------------------------//




public function generarCodigo($longitud) 
{
    $key = '';
    $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = strlen($pattern)-1;
    for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
    
    if($this->existeCodigo($key))
        return $this->generarCodigo($longitud);
    else
        return $key;
}

function existeCodigo($key)
{

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("select codigo from pedidos where codigo = '$key'");
    $consulta->execute();
    $ret = $consulta->fetch(PDO::FETCH_OBJ);
    if($ret)
        return true;
    else
        return false;
}



public function InsertarUno()
{
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "INSERT into pedidos (codigo,idMesa,idArticulo,cliente,cantidad,importe,foto,estado,horaInicio)
            values(:codigo,:idMesa,:idArticulo,:cliente,:cantidad,:importe,:foto,:estado,:horaInicio)");
        $consulta->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $consulta->bindParam(':idMesa', $this->idMesa, PDO::PARAM_STR);
        $consulta->bindParam(':idArticulo',$this->idArticulo, PDO::PARAM_INT);
        // $consulta->bindParam(':idEmpleado',$this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindParam(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindParam(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindParam(':importe', $this->importe, PDO::PARAM_STR);
        $consulta->bindParam(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindParam(':horaInicio', $this->horaInicio, PDO::PARAM_STR);
        $consulta->execute();		
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
}


      
    



public function BorrarId($id){

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from pedidos 				
				WHERE id=:id");	
				$consulta->bindParam(':id',$id, PDO::PARAM_INT);		
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
       $consulta->bindParam(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindParam(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindParam(':estimado', $this->estimado, PDO::PARAM_STR);
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
public function obtenerTodos()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta(
        "select 
        p.id IdPedido,
        m.codigo Mesa,
        c.descripcion Articulo,
        e.nombre Empleado,
        p.cliente Cliente,
        p.importe Importe,
        p.cantidad Cantidad,
        p.foto Foto,
        p.estado Estado,
        p.estimado Estimado,
        p.horaInicio HoraInicio,
        p.horaFin  HoraFin
        from pedidos p 
        inner join carta c on c.id = p.idArticulo
        inner join mesas m on m.id = p.idMesa
        left join empleados e on e.id = p.idEmpleado ");
    
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_OBJ);	
}

public function obtenerFacturadoEntreFechas($fInicio, $fFin)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta(
        "select 
        'Total Facturado' titulo,
        sum(p.importe * p.cantidad) total
        from pedidos p 
        where p.horaFin is not null
        and p.horaInicio >= :fInicio and p.horaFin <= :fFin ");
    $consulta->bindParam(':fInicio',$fInicio, PDO::PARAM_STR);
    $consulta->bindParam(':fFin',$fFin, PDO::PARAM_STR);
    $consulta->execute(); 
    $res =$consulta->fetch(PDO::FETCH_OBJ);	

    return $res;
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

public function ConsultarTipo($codigo,$tipo){

    $retorno=null;

    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("");
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

//Si devuelve nro mayor a cero es que no todos los articulos del pedidos se encuentran listos para servir.
public function ConsultarEstado($codigoPedido, $estado)
{
    $ret=false;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
        select count(p.estado) estado
        from pedidos p
        where p.codigo = ?
        and p.estado != ?");
    $consulta->execute(array($codigoPedido,$estado)); 
    $estados = $consulta->fetch(PDO::FETCH_OBJ); 

    if($estados != null)
        if($estados->estado == 0)
            $ret= true;
    
    return $ret;
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


    public function TraerPedidosSector($sector)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT p.*
            FROM pedidos p 
            inner join carta c on p.idArticulo = c.id
            WHERE c.sector= :sector 
            AND  p.estado = 'pendiente' ");
        $consulta->bindParam(":sector",$sector,PDO::PARAM_STR);
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_CLASS, "pedidos");
    } 


   
    ///Traer codigo mesa
    public function traerMesa($fecha)
    {

   
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id as idpedido, p.mesa as mesa,p.estado as estado,p.cliente as cliente,c.descripcion as articulo,p.cantidad as cant,p.codigo as codigo,p.foto as foto,e.nombre AS empleado ,p.estimado as estimado,p.horaInicio as inicio,p.horaFin as fin FROM pedidos as p ,carta as c, empleados as e WHERE p.idArticulo=c.id AND e.id=p.idEmpleado AND p.horaInicio >= '$fecha 00:00:00' AND p.horaInicio <= '$fecha 23:59:59' ");
        
        $consulta->execute(); 
        return $consulta->fetchAll();	
    }
    
    
    ///Tomar pedido
    public function asignarPedido()
    {
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update pedidos 
            set estado = :estado,
            estimado = :estimado,
            idEmpleado = :idEmpleado
            WHERE codigo = :codigo and idMesa = :idMesa and idArticulo = :idArticulo
            ");
        $consulta->bindParam(':estado',$this->estado, PDO::PARAM_STR);
        $consulta->bindParam(':estimado', $this->estimado, PDO::PARAM_INT);
        $consulta->bindParam(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindParam(':codigo',$this->codigo, PDO::PARAM_STR);
        $consulta->bindParam(':idMesa', $this->idMesa, PDO::PARAM_INT);
        $consulta->bindParam(':idArticulo', $this->idArticulo, PDO::PARAM_INT);

        $consulta->execute();
        return $consulta->rowCount() ;

  
    }


    public function PedidoTerminado()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           horaFin= :horaFin
           WHERE id=:id");
       $consulta->bindParam(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindParam(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindParam(':horaFin', $this->horaFin, PDO::PARAM_STR);
       $consulta->execute();
       return $consulta->rowCount() ;

    }
     
    //Rehacer esto. Deberia tener tabla de 1 pedido -> n Articulos para mantenere el estado del pedido unico.
    //Por ahora upd de todos por codigo.
    public function PedidoEntregado()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado
           WHERE codigo=:codigo");
       $consulta->bindParam(':codigo',$this->codigo, PDO::PARAM_STR);
       $consulta->bindParam(':estado',$this->estado, PDO::PARAM_STR);
    //    $consulta->bindParam(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       $consulta->execute();
       return $consulta->rowCount();

    }

    public function PedidoCancelado(){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado,
           idEmpleado= :idEmpleado
           WHERE id=:id");
       $consulta->bindParam(':id',$this->id, PDO::PARAM_INT);
       $consulta->bindParam(':estado',$this->estado, PDO::PARAM_INT);
       $consulta->bindParam(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
       $consulta->execute();
       return $consulta->rowCount();


    }

    public function CerrarPedido($mesa)
    {

       
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

    public function PedidoPagado($id)
    {
        
        $estado="pagado";
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedidos 
           set estado=:estado           
           WHERE id=:id");
        $consulta->bindParam(':id',$id, PDO::PARAM_INT);
        $consulta->bindParam(':estado',$estado, PDO::PARAM_INT);
        $consulta->execute();
       return $consulta->rowCount();   


    }


    ///tiempo restante pedido
    public function CalcularTiempo($codigoPedido,$codigoMesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "select TIMEDIFF(DATE_ADD( max(p.horaInicio), INTERVAL max(estimado) MINUTE),now()) TiempoRestante 
            from pedidos p 
            inner join mesas m on m.id = p.idMesa
            where p.codigo = :codigoPedido and m.codigo = :codigoMesa");
        $consulta->bindParam(':codigoPedido',$codigoPedido, PDO::PARAM_STR);    
        $consulta->bindParam(':codigoMesa',$codigoMesa, PDO::PARAM_STR);    
        $consulta->execute(); 
        $ret = $consulta->fetch(PDO::FETCH_OBJ);
        if($ret)
            return $ret->TiempoRestante;
        else
            return 0;

    } 



}

?>