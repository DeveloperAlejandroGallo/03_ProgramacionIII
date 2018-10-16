<?php
class alumno extends persona implements iMaterias 
{
    public $legajo;
    public $materia;

    function __construct($nom, $apell, $leg)
    {
        parent::__construct($nom, $apell);
        $this->legajo = $leg;
    }

    function Saludar()
    {
        return parent::Saludar() ." - Legajo: " .$this->legajo;
    }

    function inscribirMaterias($materia)
    {
        if($this->legajo > 2000)
            return "<strong>NO HAY LUGAR!</strong>";
        else
            return "<h1>INSCRIPCION<h1>" .$this->Saludar() ."<strong><br><br>INSCRIPTO A" .$materia ."!</strong>";
    }

    function toJson()
    {
        return json_encode($this);
    }
}

?>