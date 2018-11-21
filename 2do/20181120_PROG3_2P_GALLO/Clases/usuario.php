<?php
class usuario
{
 	public $nombre;
  	public $clave;
	public $tipo;



  
	 public function InsertarUsuario()
	 {
		 try
		 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios(nombre,clave,tipo)values(:nombre,:clave,:tipo)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);	
				$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
				$consulta->bindValue(':tipo',$this->tipo, PDO::PARAM_STR);	
				$consulta->execute();
				
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
		}
		catch( PDOException $Exception ) 
		{
			echo "Error: ".$Exception->getMessage();
			return false;		
		}
	 }



  	public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, '*****' clave, tipo, tipo from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function TraerUnUsuario($nombre) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, clave, tipo from usuarios where nombre = :nombre");
			$consulta->bindParam(':nombre',$nombre,PDO::PARAM_STR);
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			return $usuarioBuscado;				

			
	}




}