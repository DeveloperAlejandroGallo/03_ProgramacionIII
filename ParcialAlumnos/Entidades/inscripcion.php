<?php
#nombre de la materia, código de materia, el cupo de alumnos y el aula
class inscripcion
{
    public $email;
    public $apellido;
    public $nombre;
    public $codigo;
    public $materia;
 
    function __construct($email, $apellido, $nombre, $codigo, $materia)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->codigo = $codigo;
        $this->materia = $materia;
    }

    function clave()
    {
        return "$this->email-$this->codigo";
    }

    function descripcion()
    {
        return "$this->apellido, $this->nombre-$this->materia";
    }

    function toCSV()
    {
        $separador = ";";
        return $this->email . $separador . $this->apellido . $separador . $this->nombre . $separador .
        $this->codigo . $separador . $this->materia . $separador . PHP_EOL;
    }

    function toJson()
    {
        return json_encode($this);
    }

    static function title()
    {
        return "Inscripciones";
    }

    static function header()
    {
        return "
        <tr>
            <th>Email</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Materia</th>
        </tr>";
    }
    

    function row()
    {
        return "<tr>
                    <td>$this->email</td>
                    <td>$this->apellido</td>
                    <td>$this->nombre</td>
                    <td>$this->codigo</td>
                    <td>$this->materia</td>
                </tr>";
    }
}


?>