<?php
class usuario
{
	public $id = '';
 	public $usuario = '';
  	public $password = '';
    public $puesto = '';
      
      function __construct($id, $usuario, $password, $puesto)
      {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->puesto = $puesto;
      }


      public static function TraerUnUsuario($idUsuario) 
      {
              $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
              $consulta =$objetoAccesoDato->RetornarConsulta("select id, usuario, password, puesto from usuarios where usuario = :idUsuario ");
              $consulta->bindparam(":idUsuario",$idUsuario);
              $consulta->execute();
              $miUsuario = $consulta->fetchAll();
              return $miUsuario;				
      }
}
?>