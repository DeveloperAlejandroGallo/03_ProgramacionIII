<?php
class usuario
{
 	public $email;
  	public $clave;
  	public $perfil;



  
	 public function InsertarUsuario()
	 {
		 try
		 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios(email,clave,perfil)values(:email,:clave,:perfil)");
				$consulta->bindValue(':email',$this->email, PDO::PARAM_STR);	
				$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
				$consulta->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);	
				$consulta->execute();
				
				return true;
		}
		catch( PDOException $Exception ) 
		{
			echo "<br>Error: ".$Exception->getMessage();
			return false;		
		}
	 }



  	public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select email, '*****' clave, perfil from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function TraerUnUsuario($email) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select email, clave, perfil from usuarios where email = '$email'");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			return $usuarioBuscado;				

			
	}




}