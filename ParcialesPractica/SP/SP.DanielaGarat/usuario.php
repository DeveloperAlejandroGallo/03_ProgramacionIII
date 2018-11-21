<?php
class usuario
{
 	public $email;
  	public $clave;
    public $perfil;
      
      function __construct($email, $clave, $perfil)
      {
        $this->email = $email;
        $this->clave = $clave;
        $this->perfil = $perfil;
      }

      function InsertaUsuarioBase($usuario)
      {
          $response= '';
          $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
          $consulta =$objetoAccesoDato->RetornarConsulta("insert into `usuario_datos`(`email`, `clave`, `perfil`) values ('$usuario->email', '$usuario->clave', '$usuario->perfil')");
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

      public static function TraerUnUsuario($email) 
      {
              $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
              $consulta =$objetoAccesoDato->RetornarConsulta("select `email`, `clave`, `perfil` from `usuario_datos` where `email` = '$email'");
              $consulta->execute();
              $miUsuario = $consulta->fetchAll();
              return $miUsuario;				
      }

      public static function TraerTodoLosUsuarios()//si lo ejecuta un admin, esta funcion
	    {
			  $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			  $consulta =$objetoAccesoDato->RetornarConsulta("select `email`, `clave`, `perfil` from `usuario_datos`");
			  $consulta->execute();			
        return $consulta->fetchAll();		
      }
}
?>