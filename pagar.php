<?php
if (!isset($_POST['submit'])) {
    exit("Hubo un error.");

}

// Hacemos el llamado a las clases (namespace) que usaremos en el proyecto:
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

// Claves de perfil de compra: alberto-compras@gmail.com pass: 12345678

require 'includes/paypal.php';


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
    $numero_boletos = $boletos;
        // $numero_boletos es un array:
            /*    array (size=3)
                    'un_dia' => 
                        array (size=2)
                            'cantidad' => string '' (length=1)
                            'precio' => string '30' (length=2)
                    'pase_completo' => 
                        array (size=2)
                            'cantidad' => string '' (length=0)
                            'precio' => string '50' (length=2)
                    'dos_dias' => 
                        array (size=2)
                            'cantidad' => string '' (length=0)
                            'precio' => string '45' (length=2) 
            */

    // Pedidos extra
    $pedido_extra = $_POST['pedido_extra'];
    // $pedido_extra es un array
            /*   array (size=2)
                    'camisas' => 
                        array (size=2)
                            'cantidad' => string '1' (length=1)
                            'precio' => string '10' (length=2)
                    'etiquetas' => 
                        array (size=2)
                            'cantidad' => string '1' (length=1)
                            'precio' => string '2' (length=1)
            */


    $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
    $precioCamisa = $_POST['pedido_extra']['camisas']['precio'];
    $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
    $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];

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
        // header('Location: pagar.php?exitoso=1'); ------ lo eliminamos en el modulo de paypal, porque la pagina será redireccionada a una pagina de paypal.
    } catch (Exception $e) {
        echo $e->getMessage();
    }
endif;


// ##################### P A Y P A L ########################
// Instanciamos la clase Payer();
$compra = new Payer();
$compra->setPaymentMethod('paypal');

$i=0;
// Creamos el arreglo_pedido para poder guardar los arreglos de los boletos y de los pedidos extra. (Un arreglo de 2 arreglos)
$arreglo_pedido = array();
foreach ($numero_boletos as $key => $value) {
    // Ver los valores del array para entender las referencias.
    if ((int) $value['cantidad'] > 0) {
        ${"articulo$i"} = new Item();
        $arreglo_pedido[] = ${"articulo$i"};
        ${"articulo$i"}->setName('Pase: '.$key)
                        ->setCurrency('USD')
                        ->setQuantity((int) $value['cantidad'])
                        ->setPrice((int) $value['precio']);
        $i++;
    }
}

foreach ($pedido_extra as $key => $value) {
    // Ver los valores del array para entender las referencias.
    if ((int) $value['cantidad'] > 0) {

        if ($key == 'camisas') {
            $precio = (float) $value['precio'] * .93;
        }else{
            $precio = (int) $value['precio'];
        }

        ${"articulo$i"} = new Item();
        $arreglo_pedido[] = ${"articulo$i"};
        ${"articulo$i"}->setName('Extras: '.$key)
                        ->setCurrency('USD')
                        ->setQuantity((int) $value['cantidad'])
                        ->setPrice($precio);
        $i++;
    }
}

// Lista de todos los artículos que le vamos a cobrar al cliente guardados en un array();
$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido);
// $arreglo_pedido es un super arreglo:
/*array (size=3)
  0 => 
    object(PayPal\Api\Item)[8]
      private '_propMap' (PayPal\Common\PayPalModel) => 
        array (size=4)
          'name' => string 'Pase: un_dia' (length=12)
          'currency' => string 'USD' (length=3)
          'quantity' => int 1
          'price' => string '30' (length=2)
  1 => 
    object(PayPal\Api\Item)[9]
      private '_propMap' (PayPal\Common\PayPalModel) => 
        array (size=4)
          'name' => string 'Extras: camisas' (length=15)
          'currency' => string 'USD' (length=3)
          'quantity' => int 1
          'price' => string '9.30' (length=4)
  2 => 
    object(PayPal\Api\Item)[10]
      private '_propMap' (PayPal\Common\PayPalModel) => 
        array (size=4)
          'name' => string 'Extras: etiquetas' (length=17)
          'currency' => string 'USD' (length=3)
          'quantity' => int 1
          'price' => string '2' (length=1)
*/


$cantidad = new Amount();
$cantidad->setCurrency('USD')
         ->setTotal($total) // Se deben incluir todos los conceptos de cobro (tax, gasto de envío, comisión etc)
         ->setDetails($detalles);

$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
            ->setItemList($listaArticulos)
            ->setDescription('Pago GdlWebCamp ')
            ->setInvoiceNumber($ID_registro);

$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO."/pago_finalizado.php?exito=true&id_pago={$ID_registro}")
              ->setCancelUrl(URL_SITIO."/pago_finalizado.php?exito=falseid_pago={$ID_registro}");




$pago = new Payment();
$pago->setIntent("sale")
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));

try {
    $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
    echo "<pre>";
    print_r(json_decode($pce->getData()));
    exit;
    echo "</pre>";
}

// Enlace de aprobación:
$aprobado = $pago->getApprovalLink();

header("Location: {$aprobado}");

