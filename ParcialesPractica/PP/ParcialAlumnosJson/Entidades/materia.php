<?php
#nombre de la materia, código de materia, el cupo de alumnos y el aula
class materia
{
    public $nombre;
    public $codigo;
    public $cupo;
    public $aula;

    function __construct($codigo, $nombre, $cupo,  $aula)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->cupo   = $cupo;
        $this->aula   = $aula;
    }

    function clave()
    {
        return $this->codigo;
    }

    function descripcion()
    {
        return $this->nombre;
    }

    function toCSV()
    {
        $separador = ";";
        return $this->codigo . $separador . $this->nombre . $separador . $this->cupo . $separador . $this->aula . $separador . PHP_EOL;
    }

    function toJson()
    {
        return json_encode($this);
    }

    static function title()
    {
        return "Materias";
    }

    static function header()
    {
        return "
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Cupo</th>
            <th>Aula</th>
        </tr>";
    }
    

    function row()
    {
        return "<tr>
                    <td>$this->codigo</td>
                    <td>$this->nombre</td>
                    <td>$this->cupo</td>
                    <td>$this->aula</td>
                </tr>";
    }
}


?>