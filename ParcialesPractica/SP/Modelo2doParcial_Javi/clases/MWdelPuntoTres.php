<?php
class MWdelPuntoTres
{
    function __invoke ($request, $response, $next)
    {
        $objRespuesta= new stdclass();
        $newResponse = $response;
        $respuestaApuntada = $objRespuesta;

        $body = $newResponse->getBody()->__toString();
        $miJsonReseponse = json_decode($body);

        if (isset($miJsonReseponse))
        {
            //existe algo en el body
            $respuestaApuntada = $miJsonReseponse;
        }

        $headerJWT = $request->getHeader('JWT');
        $miToken = $headerJWT[0];

        $miNombre = AutentificadorJWT::ObtenerNombre($miToken);
        $miUsuario = Usuario::TraerUno($miNombre);

        if ($miUsuario[0]['perfil'] == "usuario")
        {
            $respuestaApuntada->Result = "Hola";
            $newResponse = $newResponse->withJson($respuestaApuntada, 407);
            return $newResponse;
        }
        $newResponse = $next($request, $newResponse);
    

        return $newResponse;
    }
}

?>