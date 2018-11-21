<?php
class Usuario
{
  public $nombre;
  public $clave;
  public $sexo;
  public $perfil;

  public function __construct($nom, $cla, $sex, $per)
  {
    $this->nombre = $nom;
    $this->clave = $cla;
    $this->sexo = $sex;
    $this->perfil = $per;
  }
  public static function InsertaUsuarioBase($usuario)
  {
    $output = false;
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $sqltxt = "INSERT into `usuarios`(`nombre`, `clave`, `sexo`, `perfil`) VALUES ('{$usuario->nombre}', '{$usuario->clave}', '{$usuario->sexo}', '{$usuario->perfil}')";
    $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
    $consulta->execute();

    if(gettype(Usuario::ValidarIDUsuario($usuario->nombre)) == "string")
    {
      $output = true;
    }

    return $output;
  }
  
  public static function TraerUno($nombre) 
  {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $sqltxt = "SELECT `nombre`, `clave`, `sexo`, `perfil`, `ROW_ID` FROM `usuarios` where nombre = '{$nombre}'";
    $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
    $consulta->execute();
    return $consulta->fetchAll();
  }

  public static function TraerTodos()
  {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $sqltxt = "SELECT `nombre`, `sexo`, `perfil`, `ROW_ID` FROM `usuarios`";
    $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
    $consulta->execute();
    return $consulta->fetchAll();
  }

  public static function ValidarCredencialBD($nombre, $clave, $sexo) 
  {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $sqltxt = "SELECT `nombre`, `clave`, `sexo` FROM `usuarios` where nombre = '{$nombre}' AND clave = '{$clave}' AND sexo = '{$sexo}'";
    $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
    $consulta->execute();
    return $consulta->fetchColumn();
  }

  public static function ValidarIDUsuario($nombre)
  {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $sqltxt = "SELECT `nombre` FROM `usuarios` where nombre = '{$nombre}'";
    $consulta =$objetoAccesoDato->RetornarConsulta($sqltxt);
    $consulta->execute();
    return $consulta->fetchColumn();
  }
}


?>