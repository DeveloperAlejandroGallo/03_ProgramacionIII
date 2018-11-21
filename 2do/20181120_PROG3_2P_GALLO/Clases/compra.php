<?php
class compra
{
 	public $id;
  	public $idUsuario;
    public $marca;
	public $modelo;
	public $fecha;
	public $kilometros;
    


	 public function InsertarCompra()
	 {
		 try
		 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta(
					"INSERT into compras(idUsuario,marca,modelo,fecha,kilometros)
					values(:idUsuario,:marca,:modelo,:fecha,:kilometros)");
				$consulta->bindValue(':idUsuario',$this->idUsuario, PDO::PARAM_INT);	
				$consulta->bindValue(':marca',$this->marca, PDO::PARAM_STR);	
				$consulta->bindValue(':modelo',$this->modelo, PDO::PARAM_STR);	
				$consulta->bindValue(':fecha',$this->fecha, PDO::PARAM_STR);	
				$consulta->bindValue(':kilometros',$this->kilometros, PDO::PARAM_STR);	
				$consulta->execute();
				$this->id = $objetoAccesoDato->RetornarUltimoIdInsertado();
				return $this->id;
		}
		catch( PDOException $Exception ) 
		{
			throw new Exception($Exception->getMessage()); 		
		}
	 }



  	public static function TraerTodasLasCompras()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from compras");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "compra");		
	}

    public static function TraerTodasLasComprasUnUsr($idUsuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from compras where idUsuario = :idUsuario");
            $consulta->bindParam(":idUsuario",$idUsuario,PDO::PARAM_STR);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "compra");		
	}


	public static function TraerModelosmarca($marca) 
	{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            
            $consulta =$objetoAccesoDato->RetornarConsulta("select distinct modelo from compras where marca = :marca");
            $consulta->bindParam(':marca',$marca,PDO::PARAM_STR);
			$consulta->execute();
			$compraBuscado= $consulta->fetchAll(PDO::FETCH_ASSOC);

			return $compraBuscado;				
		
	}

	public static function TraerProdVendidos() 
	{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            
            $consulta =$objetoAccesoDato->RetornarConsulta("select distinct marca, modelo from compras order by marca,modelo");
			$consulta->execute();
			$compraBuscado= $consulta->fetchAll(PDO::FETCH_ASSOC);

			return $compraBuscado;				
		
	}


}