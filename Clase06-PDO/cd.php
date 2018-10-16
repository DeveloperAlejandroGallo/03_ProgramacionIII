<?php

class cd 
{

    public $id;
    public $title;
    public $interpret;
    public $year;

    function __construct($id, $title, $interpret, $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->interpret = $interpret;
        $this->year = $year;
    }

    function tabla()
    {
        return "cds";
    }

    function values()
    {
        return "$this->title,$this->interpret,$this->year";
    }

}


?>