<?php

    $conn = new mysqli('localhost','root','','gdlwebcamp'); //No tenemos clave

    if($conn->connect_error){
        echo $error->$conn->connect_error;
    }

?>