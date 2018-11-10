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
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	public function ModificarUsuario()
	 {

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			update usuarios 
			set nombre=:nombre,
			clave=:clave,
			sexo=:sexo,
			perfil=:perfil 
			WHERE id=:id");
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);	
		$consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);	
		$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);	
		$consulta->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
		return $consulta->execute();

	 }
	
  
	 public function InsertarElUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre,clave,sexo,perfil)values(:nombre,:clave,:sexo,:perfil)");
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
	 			$this->InsertarElUsuario();
	 		}

	 }


  	public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where id = $id");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			return $usuarioBuscado;				

			
	}

	public static function TraerUnUsuarioAnio($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  nombre as titulo, clave as cantante,sexo as año from usuarios  WHERE id=? AND sexo=?");
			$consulta->execute(array($id, $anio));
			$usuarioBuscado= $consulta->fetchObject('usuario');
      		return $usuarioBuscado;				

			
	}

	public static function TraerUnUsuarioAnioParamNombre($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  nombre as titulo, clave as cantante,sexo as año from usuarios  WHERE id=:id AND sexo=:anio");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
      		return $usuarioBuscado;				

			
	}
	
	public static function TraerUnUsuarioAnioParamNombreArray($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  nombre as titulo, clave as cantante,sexo as año from usuarios  WHERE id=:id AND sexo=:anio");
			$consulta->execute(array(':id'=> $id,':anio'=> $anio));
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
      		return $usuarioBuscado;				

			
	}

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->nombre."  ".$this->clave."  ".$this->sexo;
	}

}