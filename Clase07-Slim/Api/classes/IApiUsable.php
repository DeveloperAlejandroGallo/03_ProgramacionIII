<?php
interface IApiUsable 
{
    public function GetOne($request, $response, $args);
    public function GetAll($request, $response, $args);
    public function PutOne($request, $response, $args);
    public function DeleteOne($request, $response, $args);
    public function ModifyOne($request, $response, $args);
}

?>

