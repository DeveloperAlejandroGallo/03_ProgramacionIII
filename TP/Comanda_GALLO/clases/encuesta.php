<?php

require_once 'mesas.php';
require_once 'pedidos.php';
require_once 'empleados.php';
require_once 'carta.php';




class encuesta
{

    public $id;
    public $codigoMesa;
    public $codigoPedido;
    public $mesa;
    public $restaurante;
    public $mozo;
    public $cocinero;
    public $experiencia;



    public function InsertarUno()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into encuesta (codigoMesa,codigoPedido,mesa,restaurante,mozo,cocinero,experiencia)values(:codigoMesa,:codigoPedido,:mesa,:restaurante,:mozo,:cocinero,:experiencia)");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':mesa', $this->mesa, PDO::PARAM_STR);
        $consulta->bindValue(':restaurante', $this->restaurante, PDO::PARAM_STR);
        $consulta->bindValue(':mozo', $this->mozo, PDO::PARAM_INT);
        $consulta->bindValue(':cocinero', $this->cocinero, PDO::PARAM_STR);
        $consulta->bindValue(':experiencia', $this->experiencia, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function obtenerTodos()
    {

        // $retorno;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM encuesta ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "encuesta");

    }

}


?>