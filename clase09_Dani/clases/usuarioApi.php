<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';
require_once 'AutentificadorJWT.php';

class usuarioApi extends usuario implements IApiUsable
{
    public function TraemeElUsuario ($request, $response, $args){
        $output = $response;

        $input = usuario::TraerUnUsuario("javi");//$args['usuario']);
        $unUsuario = new usuario($input[0][0], $input[0][1], $input[0][2], $input[0][3]);
        //echo var_dump($input);
        //echo var_dump($input);
        //echo $input[0][0]; 
        var_dump($unUsuario);
        if ($unUsuario != NULL)
        {
            if ($args['password'] == $unUsuario->password)
            {
                $token = AutentificadorJWT::CrearToken($unUsuario);
                $output = $response->withAddedHeader('token', $token);

                echo " llegue de token";
            }
        }
        return $output;
    }

}

?>