<?php 

require 'paypal/autoload.php';

define ('URL_SITIO', 'http://localhost/udemy/gdlwebcamp');

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Abrlg-IRCxe0qauObv3BlGTe8jIRyVmGbuJtvdSmlWk0tbnkT7Gnk1qTCpGD_ZmWQW32G_XB5jBweaSt', // ClienteID
        'EJRXGW5FRv_WxXvNPyOu0nypTeVV6ru51k_WeJxyfWK_f8PhHWVTNNMmvlvbplvi8EjUXRFwzATX2J6V' // Secret
    )
    );
