<?php
class producto
{
    public $nombre;
    public $codigoBarra;
    public $imagen;

    function __construct($nom, $codBarra,$img)
    {
        $this->nombre = $nom;
        $this->codigoBarra = $codBarra;
        $this->imagen = $img;
    }

    function toJson()
    {
        return json_encode($this);
    }

    
}

?>