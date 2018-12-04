<?php

require_once "clases/accesoDatos.php";

class mesas
{

//--------------------------------------------------------------------------------//
//--ATRIBUTOS    

    public $id;
    public $codigo;
    public $estado;



    public function InsertarUno()
    {


        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesas (codigo,estado)values(:codigo,:estado)");
        $consulta->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $consulta->bindParam(':estado', $this->estado, PDO::PARAM_STR);
        try
        {
            $consulta->execute();
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        catch (Exception $ex)
        {
            throw new Exception("Registro duplicado");
        }
    }



    public function BorrarCodigo($codigo)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
				delete 
				from mesas 				
				WHERE codigo=:codigo");
        $consulta->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $retorno = $consulta->execute();
        return $consulta->rowCount();


    }


    public function Modificarestado()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        update mesas 
        set estado='$this->estado'				
        WHERE codigo='$this->codigo'");

        $consulta->execute();
        return $consulta->rowCount();
    }

    public function TraerId($codigo)
    {
        $retorno = null;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id FROM mesas WHERE codigo=?");
        $consulta->execute(array($codigo));
        $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($respuesta != null) {
        //var_dump($retorno);
            $retorno = $respuesta;
        }

        return $retorno;
    }

    public function TraerIdDesocupado($codigo)
    {
        $retorno = null;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id FROM mesas WHERE codigo=? and estado='cerrada'");
        $consulta->execute(array($codigo));
        $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($respuesta != null) {
        //var_dump($retorno);
            $retorno = $respuesta['id'];
        }

        return $retorno;
    }

//--TRAER
    public function obtenerTodos()
    {

   // $retorno;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "mesas");

    }

//--Consultar segun estado y tipo
    public function Consultar($id)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE estado='$estado' AND tipo= '$tipo'  ");
        $consulta->execute();
        $retorno = $consulta->fetchAll(PDO::FETCH_CLASS, "mesas");
        if ($retorno != null) {
            return $retorno;
        } else {
            return null;
        }

    }


    public function ConsultarEstado($codigo)
    {

        $retorno = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE codigo=?  ");
        $consulta->execute(array($codigo));
        $respuesta = $consulta->fetchObject('mesas');
        if ($respuesta != null) {
            $retorno = $respuesta->estado;
        }


        return $retorno;
    }

    public function traerUnaMesa($codigo)
    {

        $retorno = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas WHERE codigo=?  ");
        $consulta->execute(array($codigo));
        $respuesta = $consulta->fetchObject('mesas');
        
        return $respuesta;
    }



    public function CerrarMesa($codigo)
    {
        $estado = "cerrada";
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        update mesas 
        set estado= :estado				
        WHERE codigo=:codigo");
        $consulta->bindParam(':codigo',$codigo, PDO::PARAM_INT);
        $consulta->bindParam(':estado',$estado, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarMesa($id, $estado)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        update mesas 
        set estado = :estado			
        WHERE id = :id");
        $consulta->bindParam(':id',$id, PDO::PARAM_INT);
        $consulta->bindParam(':estado',$estado, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }




}


?>