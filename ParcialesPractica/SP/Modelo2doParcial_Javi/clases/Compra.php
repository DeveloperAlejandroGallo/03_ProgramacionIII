<?php
class Compra
{
    public $id;
    public $articulo;
    public $fecha;
    public $precio;

    public function __construct($art, $fec, $pre)
    {
        if (Compra::TraerNuevoID() === false)
        {
            $this->id = 1;
        }
        else
        {
            $this->id = Compra::TraerNuevoID() + 1;
        }
        $this->articulo = $art;
        $this->fecha = $fec;
        $this->precio = $pre;
    }

    public static function InsertaCompraBase($compra, $userID)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sqltxt = "INSERT into `compras`(`ROW_ID`, `articulo`, `fecha`, `precio`, `USER_ID`) VALUES ('{$compra->id}', '{$compra->articulo}', '{$compra->fecha}', '{$compra->precio}', '{$userID}')";
        $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
        $consulta->execute();
    }

    public static function TraerNuevoID()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sqltxt = "SELECT `ROW_ID` FROM `compras` ORDER BY ROW_ID DESC";
        $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
        $consulta->execute();
        return $consulta->fetchColumn();
    }

    public static function TraerCompras($usuario)
    {
        $sqltxt = "";
        if($usuario[0]["perfil"] == "admin")
        {
            $sqltxt = "SELECT T1.ROW_ID, T1.articulo, T1.precio, T2.nombre FROM `compras` as T1 INNER JOIN `usuarios` as T2 ON T1.USER_ID = T2.ROW_ID";
        }
        else if($usuario[0]["perfil"] == "usuario")
        {
            $sqltxt = "SELECT T1.ROW_ID, T1.articulo, T1.precio, T2.nombre FROM `compras` as T1 INNER JOIN `usuarios` as T2 ON T1.USER_ID = T2.ROW_ID WHERE T2.nombre = '{$usuario[0]["nombre"]}'";
        }
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta($sqltxt);
        $consulta->execute();
        return $consulta->fetchAll();
    }
}
?>