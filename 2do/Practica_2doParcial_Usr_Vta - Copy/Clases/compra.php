<?php
class compra
{
 	public $id;
  	public $usuarioNombre;
    public $articulo;
	public $fecha;
	public $precio;
    


	 public function InsertarCompra()
	 {
		 try
		 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta(
					"INSERT into compras(usuarioNombre,articulo,precio,fecha)
					values(:usuarioNombre,:articulo,:precio,:fecha)");
				$consulta->bindValue(':usuarioNombre',$this->usuarioNombre, PDO::PARAM_INT);	
				$consulta->bindValue(':articulo',$this->articulo, PDO::PARAM_STR);	
				$consulta->bindValue(':precio',$this->precio, PDO::PARAM_STR);	
				$consulta->bindValue(':fecha',$this->fecha, PDO::PARAM_STR);	
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

    public static function TraerTodasLasComprasUnUsr($usuarioNombre)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from compras where usuarioNombre = :usuarioNombre");
            $consulta->bindParam(":usuarioNombre",$usuarioNombre,PDO::PARAM_STR);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "compra");		
	}


	public static function TraerModelosArticulo($articulo) 
	{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            
            $consulta =$objetoAccesoDato->RetornarConsulta("select distinct modelo from compras where articulo = :articulo");
            $consulta->bindParam(':articulo',$articulo,PDO::PARAM_STR);
			$consulta->execute();
			$compraBuscado= $consulta->fetchAll(PDO::FETCH_ASSOC);

			return $compraBuscado;				
		
	}

	public static function TraerProdVendidos() 
	{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            
            $consulta =$objetoAccesoDato->RetornarConsulta("select distinct articulo from compras order by articulo");
			$consulta->execute();
			$compraBuscado= $consulta->fetchAll(PDO::FETCH_ASSOC);

			return $compraBuscado;				
		
	}


}