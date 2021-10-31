<?php

//======================================================================
// L  O  G  I  N
//======================================================================
if (isset($_POST['login-admin'])) {
    // die(json_encode($_POST));

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        include_once 'funciones/funciones.php';
        $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        // con bind_result() podemos renombrar los campos que vienen en la consulta para un mejor control.
        // https://www.php.net/manual/es/mysqli-stmt.bind-result.php
        $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin, $editado, $nivel);


        // https://www.php.net/manual/es/function.mysql-affected-rows.php
        if ($stmt->affected_rows) {
            // Si existe el usuario lo guardamos en una variable.(Si al menos hubo una linea afectada)
            $existe = $stmt->fetch();
            // Guardamos esa linea afectada en la variable $existe

            if ($existe) {
                // Si el usuario existe verificar el password:
                if (password_verify($password, $password_admin)) {

                    // Creamos la sesión y sus variables de sesion que podran ser utilizadas en todas las paginas
                    // del proyecto mientras la sesion este abierta.
                    session_start();
                    $_SESSION['usuario'] = $usuario_admin;
                    $_SESSION['nombre'] = $nombre_admin;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['id'] = $id_admin;

                    // Respuesta exitosa
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_admin
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error'
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        }


        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // No se pudo conectar a la BD
        echo "Error: " . $e->getMessage();
    }
    // Mandamos toda la respuesta que la funcion arroje como un json:
    die(json_encode($respuesta));
}