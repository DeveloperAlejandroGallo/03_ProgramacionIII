<?php
/**
 * La clase debe llevar la misma estructura que la tabla en MySql
 */
class cd 
{

    public $id;
    public $title;
    public $interpreter;
    public $year;

    function __construct($id, $title, $interpreter, $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->interpreter = $interpreter;
        $this->year = $year;
    }

    function getTable()
    {
        return "cds";
    }

    function getValues()
    {
        return "$this->title,$this->interpret,$this->year";
    }

    public static function getCd($id)
    {
        $db = AccesoDatos::getDataAccess();
        $query = "select * from cds where id = " . $id;
        

    }

    


}


?>