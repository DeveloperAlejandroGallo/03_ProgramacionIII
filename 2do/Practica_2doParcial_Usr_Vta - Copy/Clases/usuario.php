<?php
class usuario
{
 	public $nombre;
  	public $clave;
	public $sexo;
	public $perfil;



  
	 public function InsertarUsuario()
	 {
		 try
		 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios(nombre,clave,sexo)values(:nombre,:clave,:sexo)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);	
				$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
				$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);	
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
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, '*****' clave, sexo, perfil from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function TraerUnUsuario($nombre) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, clave, sexo, perfil from usuarios where nombre = :nombre");
			$consulta->bindParam(':nombre',$nombre,PDO::PARAM_STR);
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			return $usuarioBuscado;				

			
	}




}