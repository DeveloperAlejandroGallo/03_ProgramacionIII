<?php
class usuario
{
	public $id;
 	public $nombre;
  	public $clave;
  	public $sexo;
  	public $perfil;


  	public function BorrarUsuario()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from usuarios				
				WHERE nombre=:nombre");	
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	public function ModificarUsuario()
	 {

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			update usuarios
			set 
			clave=:clave,
			sexo=:sexo,
			perfil=:perfil 
			WHERE nombre=:nombre");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);	
		$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
		$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);	
		$consulta->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
		return $consulta->execute();

	 }
	
  
	 public function InsertarUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios(nombre,clave,sexo,perfil)values(:nombre,:clave,:sexo,:perfil)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);	
				$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
				$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);	
				$consulta->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);	
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

	 }



	 public function GuardarUsuario()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuario();
	 		}else {
	 			$this->InsertarUsuario();
	 		}

	 }


  	public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function TraerUnUsuario($nombre) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where nombre = '$nombre'");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			echo "<br>Resultado de la consulta: ";
			var_dump($usuarioBuscado);
			return $usuarioBuscado;				

			
	}


	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->nombre."  ".$this->clave."  ".$this->sexo;
	}

}