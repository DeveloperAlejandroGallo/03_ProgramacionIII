<?php
class usuario
{
 	public $nombre;
  	public $clave;
    public $sexo;
    public $perfil;
      
      function __construct($nombre, $clave, $sexo, $perfil)
      {
        $this->nombre = $nombre;
        $this->sexo = $sexo;
        $this->clave = $clave;
        $this->perfil = $perfil;
      }

      function InsertaUsuarioBase($usuario)
      {
          $response= '';
          $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
          $consulta =$objetoAccesoDato->RetornarConsulta("insert into `usuario_datos`(`nombre`, `clave`, `sexo`, `perfil`) values ('$usuario->nombre', '$usuario->clave', '$usuario->sexo', '$usuario->perfil')");
          $consulta->execute();
          $idInsertado =$objetoAccesoDato->RetornarUltimoIdInsertado();
          if($idInsertado>0)
          {
            $response=true;
          }
          else
          {
            $response=false;
          }

          return $response;
      }

      public static function TraerUnUsuario($nombre) 
      {
              $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
              $consulta =$objetoAccesoDato->RetornarConsulta("select `nombre`, `clave`, `sexo`, `perfil` from `usuario_datos` where `nombre` = '$nombre'");
              $consulta->execute();
              $miUsuario = $consulta->fetchAll();
              return $miUsuario;				
      }

      public static function TraerTodoLosUsuarios()//si lo ejecuta un admin, esta funcion
	    {
			  $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			  $consulta =$objetoAccesoDato->RetornarConsulta("select `nombre`, `clave`, `sexo`, `perfil` from `usuario_datos`");
			  $consulta->execute();			
        return $consulta->fetchAll();		
      }
      
    

}
?>