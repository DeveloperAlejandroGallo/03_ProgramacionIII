<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;

class AutentificadorJWT
{
    private static $claveSecreta = 'M1Clav3Sup3rS3cr3t4@'; //Calve unica para codificación y decodificacion
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;
    
    public static function CrearToken($data)
    {
        $ahora = time();
        /*
         parametros del payload
         https://tools.ietf.org/html/rfc7519#section-4.1
         + los que quieras ej="'app'=> "API REST CD 2017" 
        */
        $payload = array(
        	'iat'=>$ahora,  //hora actual
            'exp' => $ahora + (60*120), //2 min - Tiempo en el que expira el token
            'aud' => self::Aud(), //Ambiente en el que se encuentra
            'data' => $data,  //datos que queremos guardar codificados.
            'app'=> "API REST TP Alejandro Gallo" 
        );
        return JWT::encode($payload, self::$claveSecreta);
    }
    
    public static function VerificarToken($token)
    {
        if(empty($token) || $token == "")
        {
            echo "El token esta vacio.";
            throw new Exception("El token esta vacio.");
        } 
        // las siguientes lineas lanzan una excepcion, de no ser correcto o de haberse terminado el tiempo       
        try
        {
            $decodificado = JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
            );
        } 
        catch (ExpiredException $e)
        {
            echo "Clave fuera de tiempo";
           throw new Exception("Clave fuera de tiempo");
        }
        
        // si no da error,  verifico los datos de AUD que uso para saber de que lugar viene  
        if($decodificado->aud !== self::Aud())
        {
            echo "No es el usuario valido";
            throw new Exception("No es el usuario valido");
        }
        return true;
    }
    
   
     public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }
     public static function ObtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;
    }
    private static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }
}