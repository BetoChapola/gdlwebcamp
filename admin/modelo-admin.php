<?php
include_once 'funciones/funciones.php';

//======================================================================
// C  R  U  D
//======================================================================

if (isset($_POST['registro'])) {

    /** Recibimos en este documento la estructura de datos que se envía desde admin-ajax.js.
         Mediante "die (json_encode($_POST));" podemos detener la ejecución y ver lo que genera:
         Object { usuario: "_dato_", nombre: "_dato_", password: "_dato_", "agregar-admin": "_dato_" }

         die (json_encode($_POST));
     */

    /**Recuerda, si declaramos una variable sin definir el programa se detendrá justamente ahí.*/

    /**
        Los 2 formularios tienen los mismos campos y mandan los mismos datos a excepción de uno extra:
        (name="id_registro") que esta en editar-admin.php.

        DATOS ENVIADOS DESDE crear-admin.php/editar-admin.php A admin-ajax.js
        name="nombre"
        name="password"
        name="registro" TIPO de registro = nuevo/actualizar
        name="usuario"

        DATOS ENVIADOS DESDE editar-admin.php A admin-ajax.js
        name="id_registro" ### EXTRA ### solo estará disponible en editar-admin.php

        NOTA: https://www.it-swarm-es.com/es/php/uso-del-operador-ternario-sin-la-instruccion-else-php/1052567831/
     */
    
    !isset($_POST['usuario']) ?: $usuario = $_POST['usuario'];
    !isset($_POST['nombre']) ?: $nombre = $_POST['nombre'];
    !isset($_POST['password']) ?: $password = $_POST['password'];

    $registro = $_POST['registro']; //registro = nuevo/actualizar

    // Hasheamos el password (encriptación):
    // "costo" de iteraciones para crear un hash. Mientras más alto (más seguro) más consumos de recurso en el servidor.
    $opciones = array('cost' => 10);
    // $hashed = password_hash($password, tipo_de_encriptado, array_de opciones);
    !isset($password) ?: $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones) ;


    //======================================================================
    // INSERTAR NUEVO ADMINISTRADOR
    //======================================================================

    if ($registro == 'nuevo') {

        try {
            $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $usuario, $nombre, $password_hashed);
            $stmt->execute();
            
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_admin' => $id_registro
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        die(json_encode($respuesta));
    }


    //======================================================================
    // MODIFICAR ADMINISTRADOR
    //======================================================================

    /**
     * NOTA:Podemos guardar el registro de "editado" de dos maneras:
     * 1) Se agrega en la tabla de admins el campo "editado", con el tipo DATETIME.
     * !Con este tipo de dato sera necesario agregar en el query UPDATE en el campo "editado = NOW()".
     * NOTA: https://mariadb.com/kb/en/now/
     * 
     * 2) Se agrega en la tabla de admins el campo "editado", con el tipo TIMESTAMP.
     * !Con este tipo de dato NO sera necesario agregar en el query UPDATE el campo "editado = NOW()", funcionara sin agregar nada mas.
     */

    if ($registro == 'actualizar') {
        $id_registro = $_POST['id_registro'];

        //Verificamos el contenido del campo password antes de actualizarlo
        if (empty($_POST['password'])) {
            //Viene vacío, NO actualizamos el password. 
            // NOTA: https://mariadb.com/kb/en/now/
            // https://stackoverflow.com/questions/68780036/how-to-update-field-using-bind-param-and-mysql-now-function-in-structured-php
            $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, editado = NOW()  WHERE id_admin = ?');
            $stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
        } else {
            //Viene con datos, SI actualizamos el password.
            $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ?');
            $stmt->bind_param("sssi", $usuario, $nombre, $password_hashed, $id_registro);
        }

        try {
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    //'id_actualizado' => $stmt->insert_id ---- En el video pone esta opción, pero devuelve 0.
                    'id_actualizado' => $id_registro #Este si devuelve el id actualizado.
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        die(json_encode($respuesta));
    }

    //======================================================================
    // ELIMINAR ADMINISTRADOR
    //======================================================================

    if ($registro == 'eliminar') {
        $id_borrar = $_POST['id'];

        try {
            $stmt = $conn->prepare('DELETE FROM admins WHERE id_admin = ?');
            $stmt->bind_param("i", $id_borrar);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_eliminado' => $id_borrar
                );
            }else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        die(json_encode($respuesta));
    }
}


