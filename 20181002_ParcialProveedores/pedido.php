<?php

class pedido
{
    public $idProveedor;
    public $producto;
    public $cantidad;


    function __construct($idProveedor, $producto, $cantidad)
    {
        $this->idProveedor = $idProveedor;
        $this->producto = $producto;
        $this->cantidad   = $cantidad;

    }

    function clave()
    {
        return $this->idProveedor;
    }


    function toCSV()
    {
        $separador = ";";
        return $this->idProveedor . $separador . $this->producto . $separador . 
        $this->cantidad . $separador . PHP_EOL;
    }


    static function title()
    {
        return "Pedidos";
    }

    static function header()
    {
        return "
        <tr>
            <th>IdProveedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
        </tr>";
    }
    

    function row()
    {
        return "<tr>
                    <td>$this->idProveedor</td>
                    <td>$this->producto</td>
                    <td>$this->cantidad</td>
                </tr>";
    }

    /**4- (2pts.) caso: hacerPedido (post): Se recibe producto, cantidad y id de proveedor y 
     * se guarda en el archivo pedidos.txt. Verificar que exista el id del proveedor.     
     */

    public static function hacerPedido($archivoPedidos, $archivoProveedores)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
    
            if(isset($_POST["idProveedor"]) && isset($_POST["producto"]) 
            && isset($_POST["cantidad"]) )
            {

                $entidad = "pedido";    

                $idProveedor= $_POST["idProveedor"];
                $producto= $_POST["producto"];
                $cantidad= $_POST["cantidad"];

                $archProveedores = new archivo($archivoProveedores);
                
                $listProveedores = CSVtoArrayObj("proveedor",$archProveedores);
        
                if(count($listProveedores) > 0 && existeEnArray($listProveedores,$idProveedor) != -1)
                {
                    $archPedidos = new archivo($archivoPedidos);

                    $pedido = new pedido($idProveedor,$producto,$cantidad);
                    $listPedidos = CSVtoArrayObj($entidad,$archPedidos);

                    $archPedidos->save($pedido);

                    mostrarTodos($entidad,$archPedidos,pedido::title(),pedido::header());
                }
                else
                    msgInfo("No existe el proveedor $idProveedor");
            }        
            else
                msgInfo("No configuraron todas las variables.");
            
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo POST.");
    } 
    
    
    public static function listarPedidos($archivoPedidos, $archivoProveedores)
    {
        if($_SERVER["REQUEST_METHOD"] == "GET")
        {
            $busqueda = array(); 

            $archPedidos = new archivo($archivoPedidos);
            $listPedidos = CSVtoArrayObj("pedido",$archPedidos);
            
            $tipoMsg ="";
            $archProveedores = new archivo($archivoProveedores);
                
            $listProveedores = CSVtoArrayObj("proveedor",$archProveedores);
            echo "<h1>Pedidos</h1>";
            foreach($listPedidos as $pedido)
            {
                $i = existeEnArray($listProveedores,$pedido->idProveedor);
                $nombre = ($listProveedores[$i])->nombre;
                // array_push($busqueda,$pedido);
                echo "<br>Producto: $pedido->producto Cantidad: $pedido->cantidad IdProveedor: $pedido->idProveedor Nombre: $nombre";
            }    
                    
        
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo GET.");
    }



    public static function listarPedidosProveedor($archivoPedidos, $archivoProveedores)
    {
        if($_SERVER["REQUEST_METHOD"] == "GET")
        {
            if(isset($_GET["idProveedor"]))
            {
                $idProveedor = $_GET["idProveedor"];
                $busqueda = array(); 

                $archProveedores = new archivo($archivoProveedores);
                
                $listProveedores = CSVtoArrayObj("proveedor",$archProveedores);
                $i;
                if(count($listProveedores) > 0 && $i = existeEnArray($listProveedores,$idProveedor) != -1)
                {

                    $archPedidos = new archivo($archivoPedidos);
                    $listPedidos = CSVtoArrayObj("pedido",$archPedidos);
                   
                    $tipoMsg ="";
                    foreach($listPedidos as $pedido)
                    {
                        if($pedido->idProveedor == $idProveedor)
                            array_push($busqueda,$pedido);
                         
                    }    
                }
                else
                    msgInfo("No existe el proveedor $idProveedor");

                       
                listToTable(pedido::title(),pedido::header(),$busqueda);
            }
            else
                msgInfo("Faltan configurar parametros");
        }
        else
            msgInfo("ERROR: Se debe llamar con metodo GET.");
    }


}
?>