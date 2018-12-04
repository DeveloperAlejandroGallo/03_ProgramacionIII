<?php

require_once 'pedidos.php';
require_once 'mesas.php';
require_once 'empleados.php';
require_once 'carta.php';

class pedidosApi extends pedidos
{


    public function CargarUno($request, $response, $args)
    {
        $body = json_decode(json_encode($request->getParsedBody()));
        $res = new stdClass();
        $resNro = 500;
        if (isset($body->cliente, $body->mesa, $body->pedido)) //el pedido viene array json
        {
            $idMesa = mesas::TraerIdDesocupado($body->mesa);
            if($idMesa != null)
            {
                $pedido = json_decode($body->pedido, true);
                $mens = "";
                $esValido = $this->validoCodigos($pedido, $mens);

                if($esValido)
                {
                    $todoElPedido = array();

                    $key = pedidos::generarCodigo(5);
                    $titulo = $idMesa .'_'.$key ;
                    $fotoMens = "";
                    $this->guardarArchivoSubido($request,$titulo,$fotoMens);
                    foreach ($pedido as $articulo)
                    {
                        $miPedido = new pedidos();
                        $miPedido->codigo = $key;
                        $miPedido->idMesa = $idMesa;
                        $miPedido->idArticulo = $articulo['id'];
                        //$miPedido->idEmpleado 
                        $miPedido->cliente = $body->cliente;
                        $miPedido->cantidad = $articulo['cantidad'];
                        $miPedido->importe  = carta::obtenerPrecio($articulo['id']);
                        
                        
                        
                        $miPedido->foto = $fotoMens;
                        $miPedido->estado = "pendiente";
                        //$miPedido->estimado;
                        $miPedido->horaInicio = date("Y-m-d H:i:s");
                        //$miPedido->horaFin;
    
                        
                        $id =$miPedido->InsertarUno();
                        if($id)
                        {
                            $miPedido->$id = $id;
                            array_push($todoElPedido, $miPedido);                        
                        }
                        else
                        {
                            $res->error = "Error al insertar el pedido";
                            break;
                        }
                    }
                    $res->mensaje = "Pedido dado de alta";
                    $res->codigo = $key;
                    $res->pedido = $todoElPedido;

                    $mesa = new mesas();
                    $mesa->id = $idMesa;
                    $mesa->estado = "con cliente esperando pedido";
                    $mesa->codigo = $body->mesa;
                    $mesa->ModificarEstado();


                    $resNro = 200;
                }
                else
                    $res->error = $mens;
            }
            else
                $res->error = "Debe informar una mesa válida o desocupada";
                        
        }
        
        return $response->withJson($res,$resNro);
    }

    public function validoCodigos($pedido,$mens)
    {
        foreach($pedido as $articulo)
        {
            $mens = "Articulo ".$articulo['id']." no pertenece a la carta";
            if(!carta::verificarArticulo($articulo['id']))
                return false;
        }
        $mens = "";
        return true;
    }

    public function guardarArchivoSubido($request,$titulo,&$dir)
    {
        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        // $res->variableArchivo = json_decode(json_encode($archivos));
        // $res->rutaDestino = "";       

        if(isset($archivos['foto']))
        {
            $idAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $idAnterior)  ;
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
            $dir = $destino.$titulo.".".$extension[0];
        } 
    }



    /** Recibo por parametro
     * idPedido: ya que estamos dentro del sistema, nos manejamos con el id.
     * token: en el header para identificar el tipo de usuario.
     */
    public function ModificarUno($request, $response, $args)
    {
        $resNro = 500;
        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $user = new empleados();
        $user = $payload->data;

        $res = new stdclass();
        $body = json_decode(json_encode($request->getParsedBody()));

        if (isset($body->idPedido)) 
        {
            
            if ($user->tipo == "bartender" || $user->tipo == "cerveceros" || $user->tipo == "cocineros") 
            {      
                $miPedido = new pedidos();
                $miPedido->estado = "listo para servir";
                $miPedido->id = $body->idPedido;
                // $miPedido->idEmpleado = $user->id;
                $miPedido->horaFin = date("Y-m-d H:i:s");

                if ($miPedido->PedidoTerminado() == 1) 
                {
                    $res->mensaje = "El pedido se modifico correctamente";
                    $resNro = 200;
                } 
                else 
                {
                    $res->error = "Error al cambiar el pedido";
                }

            } 
            else
            if ($user->tipo == "mozos") 
            {

                $miPedido = new pedidos();
                $miPedido = pedidos::TraerId($body->idPedido);
                $miPedido->estado = "entregado";

                if (pedidos::ConsultarEstado($miPedido->codigo, "listo para servir")) //Consulto si todos los articulos estan listos.
                {
                    if ($miPedido->PedidoEntregado()!=0) 
                    {

                        if(mesas::ModificarMesa($miPedido->idMesa, "con clientes comiendo") == 1)
                        {
                            $res->mensaje = "El pedido $miPedido->codigo se entrego correctamente.";
                            $resNro = 200;
                        }
                        else
                            $res->error = "No se pudo modificar la mesa.";
                    } 
                    else 
                    {
                        $res->error = "Error al cambiar el pedido";
                    }

                } else 
                {
                    $res->error = "El pedido no esta listo";
                }

            }

        } else {
            $res->error = "Faltan Parametros";
        }

        return $response->withJson($res, $resNro);

    }


    public function TraerTodos($request, $response, $args)
    {
        $res = new stdClass();
        $token = $request->getHeader('token')[0];

        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        $res->usuario = $nuevoUser->nombre;
        
        if ($nuevoUser->tipo == "socios" || $nuevoUser->tipo == "mozos") 
        {
            $fecha = date("Y-m-d");
            $res->todosLosPedidos = pedidos::obtenerTodos();
        } 
        else 
        {
            $fecha = date("Y-m-d");
            $res->sector = $nuevoUser->tipo;
            $res->pedidosPendientes = pedidos::TraerPedidosSector($nuevoUser->tipo);
        }

        return $response->withJson($res,200);

    }


    public function facturadoEntreFechas($request, $response, $args)
    {
        $res = new stdClass();
        $resNro = 500;
        $token = $request->getHeader('token')[0];

        $payload = AutentificadorJWT::ObtenerPayLoad($token);
        $body = json_decode(json_encode($request->getParsedBody()));

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;
        
        if ($nuevoUser->tipo == "socios" ) 
        {
            if(isset($body->fechaYHoraInicio,$body->fechaYHoraFin))
            {
                $res->fechaYHora->desde = $body->fechaYHoraInicio;
                $res->fechaYHora->hasta = $body->fechaYHoraFin;
                $facturado = pedidos::obtenerFacturadoEntreFechas($body->fechaYHoraInicio,$body->fechaYHoraFin);
                $res->total = $facturado->total;
            } 
            else 
            {
                $res->error = "Faltan parametros";
            }
        }
        else
            $res->error = "Solo los socios pueden visualizar este reporte.";

        return $response->withJson($res,200);

    }

    public function TraerUno($request, $response, $args)
    {

        $id = $args['id'];
        $elPedido = pedidos::TraerId($id);

        $newResponse = $response->withJson($elPedido, 200);
        return $newResponse;
    }


    public function BorrarUno($request, $response, $args)
    {

        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);

        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;

        $body = json_decode(json_encode($request->getParsedBody()));
        $id = $body->id;

        $miPedido = new pedidos();
        $miPedido->estado = "cancelado";
        $miPedido->id = $id;
        $miPedido->idEmpleado = $nuevoUser->id;

        if ($miPedido->PedidoCancelado()) {
            $respuesta = "El pedido se cancelo correctamente";

        } else {
            $respuesta = "Error al cancelar el pedido";
        }

        $res = new stdclass();
        $res->resultado = $respuesta;
        $newResponse = $response->withJson($res, 200);

        return $newResponse;
    }

///Consulto el tiempo que falta para el pedido

    public function tiempoPedido($request, $response, $args)
    {
        $body = json_decode(json_encode($request->getParsedBody()));
        $resNro = 500;
        $res = new stdClass();
        if (isset($body->codigoPedido, $body->codigoMesa)) 
        {
            $minutos = pedidos::CalcularTiempo($body->codigoPedido, $body->codigoMesa);

            $res->mensaje = "Al pedido $body->codigoPedido le faltan " . $minutos . " minutos";
            $resNro = 200;
        } 
        else 
        {
            $res->error = "Faltan Parametros";

        }
        
        return $response->withJson($res,$resNro);


    }

    public function atenderPedido($request, $response, $args)
    {
        //El pedido es tomado por un tipo de empleado de la lista de pedidos pendientes, el cual ingresa el tiempo.
        //recibo la mesa, el codigo,  el idArticulo
        $body = json_decode(json_encode($request->getParsedBody()));
        $resNro = 500;
        $token = $request->getHeader('token')[0];
        $payload = AutentificadorJWT::ObtenerPayLoad($token);
        $res = new stdClass();
        $nuevoUser = new empleados();
        $nuevoUser = $payload->data;

        $nvoPedido = new pedidos();
         
        if(isset($body->codigo, $body->mesa, $body->articulo, $body->tiempo))
        {
            $nvoPedido->codigo = $body->codigo;
            $nvoPedido->idMesa = mesas::TraerId($body->mesa)['id'];
            $nvoPedido->idArticulo = $body->articulo;
            $nvoPedido->estimado = $body->tiempo;
            $nvoPedido->idEmpleado = $nuevoUser->id;
            $nvoPedido->estado = "en preparacion";

           
            if($nvoPedido->asignarPedido() > 0)
            {
                $res->mensaje = "Pedido $body->codigo asignado a $nuevoUser->nombre";
                $resNro = 200;
            }
            else
                $res->error = "No se pudo asignar el pedido.";

        }
        else
            $res->error = "Faltan informar parametros";

        return $response->withJson($res,$resNro);

    }

}




?>