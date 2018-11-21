<?php
class MWdeJWT
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
             
        
        $miToken = "";

        $headerJWT = $request->getHeader('JWT');
        if(count($headerJWT) > 0)
        {
            $miToken = $headerJWT[0];
        }

        if ($miToken != "")
        {
            try
            {
                AutentificadorJWT::VerificarToken($miToken);
                $payload = AutentificadorJWT::ObtenerPayLoad($miToken);

                if ($payload->exp > time())
                {
                    if (($payload->exp - time()) / 60 < 5.0)
                    {
                        $respuestaApuntada->NuevoJWT = AutentificadorJWT::CrearToken($payload->nombre);
                        $newResponse = $newResponse->withJson($respuestaApuntada, 200);
                    }
                }
                else
                {
                    $respuestaApuntada->Result = "El token se encuentra vencido";
                    return $newResponse = $newResponse->withJson($respuestaApuntada, 403);
                }
            }
            catch (Exception $e)
            {
                $respuestaApuntada->Result = "Error: " . $e->getMessage();
                return $newResponse = $newResponse->withJson($respuestaApuntada, 417);
            }
            $newResponse = $next($request, $newResponse);
        }
        else
        {
            $respuestaApuntada->Result = "No se encuentra el JWT";
            return $newResponse = $newResponse->withJson($respuestaApuntada, 403);
        }

        return $newResponse;
    }
}

?>