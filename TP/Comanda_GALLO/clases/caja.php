<?php

require_once 'mesas.php';
require_once 'pedidos.php';
require_once 'empleados.php';
require_once 'carta.php';




class caja
{

    public $id;
    public $empleado;
    public $fecha;
    public $mesa;
    public $cliente;
    public $codigoPedido;
    public $importe;
    public $estado;



    public function CerrarPedido(){

        $estadoMesa=  mesas::ConsultarEstado($this->mesa);
        if( $estadoMesa == "con clientes pagando"){

            $pedidos= pedidos::CerrarPedido($this->mesa);
           
           

            if($pedidos != null){
                $this->codigoPedido= $pedidos[0]->codigo;
                $this->cliente= $pedidos[0]->cliente;
                $this->estado= "ok";

                foreach($pedidos as $aux){
                    
                    $this->importe =$aux->importe + $this->importe;
                    //cambio el estado de los pedidos a pagados
                    pedidos::PedidoPagado($aux->id);
                }
                //cierro la mesa
                mesas::ModificarMesa($this->mesa,"cerrada");
                //mesas::CerrarMesa($this->mesa);
                $insertar= $this->InsertarUno();
                if($insertar!=null){
                    $respuesta= $this->GenerarFactura($pedidos);
                }
            }else{
                $respuesta= "La mesa o los pedidos no estan listos para facturar";
            }


        }else{

            $respuesta= "La mesa todavia esta en estado: $estadoMesa";

        }

        return $respuesta;

    }

    public function InsertarUno()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into caja (empleado,fecha,mesa,cliente,codigoPedido,importe,estado)values(:empleado,:fecha,:mesa,:cliente,:codigoPedido,:importe,:estado)");
				$consulta->bindValue(':empleado',$this->empleado, PDO::PARAM_INT);
				$consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
                $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
                $consulta->bindValue(':mesa', $this->mesa, PDO::PARAM_STR);
                $consulta->bindValue(':codigoPedido',$this->codigoPedido, PDO::PARAM_INT);
				$consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
                $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
                $consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }



     public function obtenerTodos(){

        // $retorno;
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
         $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM caja ");
         $consulta->execute(); 
         return $consulta->fetchAll(PDO::FETCH_CLASS, "caja");	
         
     }



}



?>