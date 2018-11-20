<?php 

interface IApiUsable{
    public function AltaDeUsuario($request, $response, $args);
    public function CrearTokenParaUsuario($request, $response, $args);
    public function ArmaListaUsuarios($request, $response, $args);
}
?>