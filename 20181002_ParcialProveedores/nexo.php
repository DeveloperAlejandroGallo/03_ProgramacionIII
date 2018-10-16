<?php
include_once "./funciones.php";
include_once "./archivo.php";
include_once "./file.php";
include_once "./proveedor.php";
include_once "./pedido.php";



$caso="";
$archivoProveedores = "proveedores.txt";
$archivoPedidos = "pedidos.txt";


$carpetaFotos = "fotos/";
$carpetaFotoBkp = "backUpFotos/";


if(isset($_GET["caso"]))
    $caso = $_GET["caso"];
else if (isset($_POST["caso"]))
        $caso = $_POST["caso"];


switch($caso)
{
    case "cargarProveedor": //1-post
        proveedor::cargarProveedor($archivoProveedores,$carpetaFotos);
        break;
    case "consultarProveedor": //2-get
        proveedor::consultarProveedor($archivoProveedores);
        break;
    case "proveedores": //3-get
        proveedor::listarProveedores($archivoProveedores);
        break;
    case "hacerPedido": //4-post
        pedido::hacerPedido($archivoPedidos,$archivoProveedores);
        break;
    case "listarPedidos": //5-get
        pedido::listarPedidos($archivoPedidos,$archivoProveedores);
        break;
    case "listarPedidosProveedor": //6-get
        pedido::listarPedidosProveedor($archivoPedidos,$archivoProveedores);
        break;
    case "modificarProveedor": //7-post
        proveedor::modificarProveedor($archivoProveedores,$carpetaFotos,$carpetaFotoBkp);
        break;
    case "fotosBack": //7-post
        proveedor::fotosBack($archivoProveedores,$carpetaFotoBkp);
        break;
            
    default:
        msgInfo( "Debe ingresar un caso válido($caso).");
        break;
}

?>

