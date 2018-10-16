<?php

class Venta
{
    public $email;
    public $saborTipo;
    public $cantidad;

    function __construct($email,$saborTipo,$cantidad)
    {
        
        $this->email = $email;     
        $this->saborTipo = $saborTipo;
        $this->cantidad = $cantidad;

    }

    function toCSV()
    {
        $separador = ";";
        return $this->email .$separador .  $this->saborTipo . $separador . $this->cantidad . PHP_EOL;
    }
}

?>