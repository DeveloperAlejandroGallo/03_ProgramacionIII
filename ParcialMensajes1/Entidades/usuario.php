<?php

class usuario
{
    public $nombre;
    public $apellido;
    public $email;
    public $foto;

    function __construct($email, $apellido, $nombre,  $foto)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->foto = $foto;
    }

    function clave()
    {
        return $this->email;
    }

    function descripcion()
    {
        return $this->apellido;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->email . $separador . $this->apellido . $separador . $this->nombre . $separador . $this->foto . $separador . PHP_EOL;
    }

    static function title()
    {
        return "Usuarios";
    }

    static function header()
    {
        return "
        <tr>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>EMail</th>
            <th>Foto</th>
        </tr>";
    }
    

    function row()
    {
        $foto = $this->foto;
        return "<tr>
                    <td>$this->apellido</td>
                    <td>$this->nombre</td>
                    <td>$this->email</td>
                    <td><img src='".$foto."' alt='Sin foto' height='30' width='30'/></td>
                </tr>";
    }



}


?>