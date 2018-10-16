<?php
//Patron Singleton - Nos mantiene una sola instancia del objeto.
//Se implementa con una variable ststic y una privada
//El cosntructor provado genera la coneccion

// try
// {
    $usuario = 'root';
    $clave = '';

    $parametros = array(PDO::ATTR_EMULATE_PREPARES=>false); //ayuda a tirar errores significativos

    $db = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8, $usuario, $clave');

    $db->query('select title as titulo, interpret as interprete from cds');

    $resultado = $db->fetchAll(); //Ejecución. 

    //fetchObject('cd'), nos convierte cada iteracion a un objeto del tipo parametro
    //*************************** */
    $sentencia = $pdo->prepare('Select * from cds where id = :id');
    $sentencia->execute(array("id" => $id));
    $sentencia = $pdo->prepare('Select * from cds where id = ?'); //otra forma
    $sentencia->execute(array($id));

    while($fila = $sentencia->fetch())
    {

    }

    $sentencia = $pdo->prepare('Select * from cds where id = ?'); //otra forma
    $sentencia->bindParam(1, $id, PDO::PARAM_INT);  //indica que el parametro debe ser integer

    $sentencia->execute();

// }
// catch(PDOException ex)
// {

// }
?>