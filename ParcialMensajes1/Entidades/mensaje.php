<?php

class mensaje
{
    public $remitente;
    public $destinatario;
    public $mensaje;
    public $foto;

    function __construct($remitente, $destinatario, $mensaje,  $foto)
    {
        $this->remitente = $remitente;
        $this->destinatario = $destinatario;
        $this->mensaje   = $mensaje;
        $this->foto   = $foto;
    }

    function clave()
    {
        return $this->remitente;
    }

    function clave2()
    {
        return $this->destinatario;
    }

    function descripcion()
    {
        return $this->nombre;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->remitente . $separador . $this->destinatario . $separador . 
        $this->mensaje . $separador . $this->foto . $separador . PHP_EOL;
    }


    static function title()
    {
        return "Mensajes";
    }

    static function header()
    {
        return "
        <tr>
            <th>Remitente</th>
            <th>Destinatario</th>
            <th>Mensaje</th>
            <th>Foto</th>
        </tr>";
    }
    

    function row()
    {
        return "<tr>
                    <td>$this->remitente</td>
                    <td>$this->destinatario</td>
                    <td>$this->mensaje</td>
                    <td>$this->foto</td>
                </tr>";
    }
}


?>