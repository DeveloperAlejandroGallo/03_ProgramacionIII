<?php
#creamos la clase persona con la palabra reservada class
class Persona
{#siempre debemos ponerle el nivel de accesibilidad. "var" es public.
    public $nombre;
    public $apellido;

    #constructor
    function __construct($nom,$apell)
    {
        $this->nombre = $nom;
        $this->apellido = $apell;
    }

    # Con $this accedemos a todos los elementos de la clase.

    function Saludar1()
    {
        echo "<br>Hola<br>";
    }

    function Saludar()
    {
        return "<br>Alumno " .$this->nombre .", " .$this->apellido;
    }


}
?>