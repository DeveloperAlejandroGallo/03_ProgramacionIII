<?php
class compra
{
  	public $fechaCompra;
    public $precio;
    public $modelo;
    public $marca;
      
    function __construct($fechaCompra, $precio, $modelo, $marca)
    {
        $this->fechaCompra = $fechaCompra;
        $this->precio = $precio;
        $this->modelo = $modelo;
        $this->marca = $marca;
    }

    function InsertarCompra ($compra, $email)
    {
        $response= '';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("insert into `compra_datos`(`fechaCompra`, `precio`, `modelo`, `marca`, `email`) values ('$compra->fechaCompra', '$compra->precio', '$compra->modelo', '$compra->marca', '$email')");
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

    public static function TraerUnaCompra($email) 
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select `id`,`fechaCompra`, `precio`, `modelo`, `marca`, `email` from `compra_datos` where `email` = '$email'");
        $consulta->execute();
        $compra = $consulta->fetchAll();
        return $compra;				
    }

    public static function TraerTodasLasCompras()//si lo ejecuta un admin, esta funcion
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select `id`, `fechaCompra`, `precio`,  `modelo`,`marca`, `email` from `compra_datos`");
		$consulta->execute();			
        return $consulta->fetchAll();		
    }
/*
    public static function TraerIdArticulo($nombreArticulo) 
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select `id`, `nombreArticulo` from `compra_datos` where `nombreArticulo` = '$nombreArticulo'");
        $consulta->execute();
        $mimarca = $consulta->fetchAll();
        return $mimarca;				
    }*/

    public static function TraerModelosMarcas()//si lo ejecuta un admin, esta funcion
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select distinct `modelo`, `marca` FROM `compra_datos`");
		$consulta->execute();			
        return $consulta->fetchAll();		
    }
    
}