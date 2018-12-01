<?php

require_once 'mesas.php';
require_once 'pedidos.php';
require_once 'empleados.php';
require_once 'carta.php';




class encuesta
{

    public $id;
    public $codigoMesa;
    public $codigoPedido;
    public $mesa;
    public $restaurante;
    public $mozo;
    public $cocinero;
    public $experiencia;



    public function InsertarUno()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into encuesta (codigoMesa,codigoPedido,mesa,restaurante,mozo,cocinero,experiencia)values(:codigoMesa,:codigoPedido,:mesa,:restaurante,:mozo,:cocinero,:experiencia)");
				$consulta->bindValue(':codigoMesa',$this->codigoMesa, PDO::PARAM_INT);
				$consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
                $consulta->bindValue(':mesa', $this->mesa, PDO::PARAM_STR);
                $consulta->bindValue(':restaurante', $this->restaurante, PDO::PARAM_STR);
                $consulta->bindValue(':mozo',$this->mozo, PDO::PARAM_INT);
				$consulta->bindValue(':cocinero', $this->cocinero, PDO::PARAM_STR);
                $consulta->bindValue(':experiencia', $this->experiencia, PDO::PARAM_STR);
               	$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public function TraerTodos(){

        // $retorno;
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
         $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM encuesta ");
         $consulta->execute(); 
         return $consulta->fetchAll(PDO::FETCH_CLASS, "encuesta");	
         
     }

     public function GenerarTabla($encuestas){
        $tabla;
        if($encuestas != null){
            $tabla ="<h3 align='center'>Encuestas</h3>";
    
            $tabla .= "<table width='70%' border='1px' align='center'><tr align='center'><th>CodigoMesa</th><th>CodigoPedido</th><th>mesa</th><th>restaurante</th><th>Mozo</th><th>Cocinero</th><th>Experiencia</th>";    
        foreach($encuestas as $aux) {        
           
            $tabla .="<tr align='center'><td>".$aux->codigoMesa."</td><td>".$aux->codigoPedido."</td><td>".$aux->mesa."</td><td>".$aux->restaurante."</td><td>".$aux->mozo."</td><td>".$aux->cocinero."</td><td>".$aux->experiencia."</td></tr>";
        }
        $tabla .="</table>";
        }
       
        
        
        return $tabla;
        
    
    }

}


?>