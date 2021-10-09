<?php
if (isset($_POST['submit'])) :

    // Agregar las variables que usaremos:
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $regalo = $_POST['regalo'];
    $total = $_POST['total_pedido'];
    $fecha = date('Y-m-d H:i:s');

    //boletos
    $boletos = $_POST['boletos'];
    // $numero_boletos = $boletos;
    $camisas = $_POST['pedido_camisas'];
    $etiquetas = $_POST['pedido_etiquetas'];

    include_once 'includes/funciones/funciones.php';
    //Siempre que se usa una funcion que retorna valores se debe aignar a una variable:
    // Funcion para unir 2 arrays, ubicada en includes/funciones/funciones.php
    $pedido = productos_json($boletos, $camisas, $etiquetas);

    //eventos
    $eventos = $_POST['registro'];
    // funcion para crear un array de eventos, ubicada en includes/funciones/funciones.php
    $registro = eventos_json($eventos);

    // ##################### PREPARE STATEMENTS ########################
    // https://dev.mysql.com/doc/refman/8.0/en/prepare.html
    // https://www.php.net/manual/es/mysqli.quickstart.prepared-statements.php

    try {
        require_once('includes/funciones/bdconexion.php');
        $stmt = $conn->prepare("INSERT INTO registrados 
    (nombre_registrado, apellido_registrado, email_registrado,fecha_registro, 
    pases_articulos, talleres_registrados, regalo, total_pagado) 
    VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
        $stmt->execute();
        $ID_registro = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        //Para evitar que los datos se queden en memoria y se vuelvan a insertar en la tabla con F5
        //Usaremos la redirecion con header(); al final estaremos enviando a la misma pagina pero con
        //un valor diferente al final (?exitoso=1)
        header('Location: pagar.php?exitoso=1');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
<?php endif; ?>

<?php include_once 'includes/templates/header.php'; ?>

<section class="seccion contenedor">
    <h2>Resumen de Registro</h2>

</section>

<?php include_once 'includes/templates/footer.php'; ?>