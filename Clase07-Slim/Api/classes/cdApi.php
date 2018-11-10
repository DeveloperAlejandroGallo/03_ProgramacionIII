<?php

class cdApi extends cd implements IApiUsable 
{
    public static  function GetOne($request, $response, $args)
    {
        $id = $args['id'];
        $elCd=cd::getCD($id);
        $newResponse =$response->withJason($elCd, 200); //El 200 es la respuesta del servidor.
        return $newResponse;
    }

    public static  function GetAll($request, $response, $args)
    {
        $id = $args['id'];
        $losCds=cd::getAllCds($id);
        $newResponse =$response->withJason($losCds, 200); //El 200 es la respuesta del servidor.
        return $newResponse;
    }

    public static  function PutOne($request, $response, $args)
    {
        $title = $args['title'];
        $interpreter = $args['interpreter'];
        $year = $args['year'];

        $elCd= cd::insertCd($title, $interpreter, $year);
        $newResponse =$response->withJason($elCd, 200); //El 200 es la respuesta del servidor.
        return $newResponse;
    }

    public static  function DeleteOne($request, $response, $args)
    {
        $id = $args['id'];
        if(cd::deleteCD($id))
            $newResponse =$response->getBody->write("Cd borrado con exito");
        else
            $newResponse =$response->getBody->write("No se borró el cd."); //El 200 es la respuesta del servidor.
        
        
           return $newResponse;
    }

    public static  function ModifyOne($request, $response, $args)
    {
        $id = $args['id'];
        $title = $args['title'];
        $interpreter = $args['interpreter'];
        $year = $args['year'];

        $elCd= cd::modifyCd($id, $title, $interpreter, $year);
        $newResponse =$response->withJason($elCd, 200);
        return $newResponse;
    }

}



?> 