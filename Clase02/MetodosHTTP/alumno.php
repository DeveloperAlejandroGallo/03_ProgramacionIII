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

    #Getter para todas las propiedades
    function __GET($prop)
    {
        if(property_exists($this,$prop))
            return $this->$prop;
    }

    #Setter para todas las propiedades
    function __SET($prop, $value)
    {
        if(property_exists($this,$prop))
            $this->$prop = $value;
    }


}

?>