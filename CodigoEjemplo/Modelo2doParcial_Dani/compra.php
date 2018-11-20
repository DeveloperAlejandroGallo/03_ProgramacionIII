<?php
class compra
{
 	public $nombreArticulo;
  	public $fechaCompra;
    public $precio;
    public $usuario;//usar id del usuario
      
    function __construct($nombreArticulo, $fechaCompra, $precio, $usuario)
    {
        $this->nombreArticulo = $nombreArticulo;
        $this->fechaCompra = $fechaCompra;
        $this->precio = $precio;
        $this->usuario = $usuario;
    }

    function InsertarCompra ($compra)
    {
        $response= '';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("insert into `compra_datos`(`nombreArticulo`, `fechaCompra`, `precio`, `usuario`) values ('$compra->nombreArticulo', '$compra->fechaCompra', '$compra->precio', '$compra->usuario')");
        $consulta->execute();

        $idInsertado =$objetoAccesoDato->RetornarUltimoIdInsertado();
        if($idInsertado>0)
        {
            $response=$idInsertado;
        }
        else
        {
            $response=0;
        }
        return $response;
    }

    public static function TraerUnaCompra($nombreArticulo) 
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select `nombreArticulo`, `fechaCompra`, `precio`, `usuario` from `compra_datos` where `nombreArticulo` = '$nombreArticulo'");
        $consulta->execute();
        $miUsuario = $consulta->fetchAll();
        return $miUsuario;				
    }

    public static function TraerTodasLasCompras()//si lo ejecuta un admin, esta funcion
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select `id`,`nombreArticulo`, `fechaCompra`, `precio`, `usuario` from `compra_datos`");
		$consulta->execute();			
        return $consulta->fetchAll();		
    }

    public static function TraerIdArticulo($nombreArticulo) 
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select `id`, `nombreArticulo` from `compra_datos` where `nombreArticulo` = '$nombreArticulo'");
        $consulta->execute();
        $miUsuario = $consulta->fetchAll();
        return $miUsuario;				
    }
    
}