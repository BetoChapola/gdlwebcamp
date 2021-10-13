<?php include_once 'includes/templates/header.php';
// Verificar la autenticidad del pago mediante la API y no por una validación TRUE:

use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payment;

require 'includes/paypal.php';

?>
<section class="seccion contenedor">
    <h2>Resumen de Registros</h2>

    <?php
    // Video 734, retiramos la respuesta 'exito' ya que vamos a hacer la validación del pago 
    // mediante la REST APi. La cuál trae en la URL los datos necesarios.
    // $resultado = $_GET['exito'];

    // Datos en la respuesta URL después de pagar
    $paymentId = $_GET['paymentId'];
    $Id_pago = (int) $_GET['id_pago'];

    // Petición a REST API para validación de pago:
    $pago = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    // resultado tiene la información de la transacción
    $resultado = $pago->execute($execution, $apiContext);

    $respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;

    

    if ($respuesta == "completed") {
        

        // Mensaje
        echo "<div class='resultado correcto'>";
        echo "El pago se realizo correctamente. <br>";
        echo "El ID es: {$paymentId}";
        echo "</div>";

        // Insertamos a la BD si el pago fue correcto.
        require_once 'includes/funciones/bdconexion.php';
        $stmt = $conn->prepare('UPDATE registrados SET pagado = ? WHERE ID_Registrado = ?');
        $pagado = 1;
        $stmt->bind_param('ii', $pagado, $Id_pago);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } else {
        echo "<div class='resultado error'>";
        echo "El pago no se realizó.";
        echo "</div>";
    }

    ?>

</section>


<?php include_once 'includes/templates/footer.php'; ?>