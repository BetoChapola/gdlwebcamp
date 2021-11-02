<?php
include_once 'funciones/funciones.php';

//======================================================================
// C  R  U  D
//======================================================================

if (isset($_POST['registro'])) {

    /**Recuerda, si declaramos una VARIABLE SIN DEFINIR el programa se detendrá justamente ahí.*/
    /** NOTA: https://www.it-swarm-es.com/es/php/uso-del-operador-ternario-sin-la-instruccion-else-php/1052567831/ */

    // Nombre del invitado
    !isset($_POST['nombre_invitado']) ?: 
    $nombre_invitado = $_POST['nombre_invitado'];

    // Apellido del invitado
    !isset($_POST['apellido_invitado']) ?: 
    $apellido_invitado  = $_POST['apellido_invitado'];

    // Biografía del invitado
    !isset($_POST['biografia_invitado']) ?: 
    $biografia_invitado  = $_POST['biografia_invitado'];

    //registro = nuevo/actualizar/eliminar
    $registro = $_POST['registro'];



    //======================================================================
    // INSERTAR NUEVO INVITADO
    //======================================================================

    if ($registro == 'nuevo') {
        /** podemos visualizar que estemos enviando correctamente nuestros archivos
            $respuesta = array(
                'post' => $_POST,
                'file' => $_FILES
            );
            die(json_encode($respuesta)); 
        */

        $directorio = '../img/invitados/';

        if (!is_dir($directorio)) {
            // https://www.php.net/manual/es/function.mkdir.php
            // modo 0755 (carpetas visibles por los usuarios, pero no pueden modificarlos)
            mkdir($directorio, 0755, true);
        }

        if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])){
            $imagen_url = $_FILES['archivo_imagen']['name'];
            $imagen_resultado = 'La imagen se subió correctamente.';
        } else {
            $respuesta = array (
                'respuesta' => error_get_last()
            );
        }

        $stmt = $conn->prepare('INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?, ?, ?, ?)');
        try {
            $stmt->bind_param('ssss', $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array (
                'respuesta' => 'exito',
                'id_insertado' => $id_insertado,
                'resultado_imagen' => $imagen_resultado
            );
            }else {
            $respuesta = array (
                'respuesta' => 'error'
            );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array (
                'respuesta' => $e->getMessage()
            );
        }
        die(json_encode($respuesta));
    }


    //======================================================================
    // MODIFICAR INVITADO
    //======================================================================

    if ($registro == 'actualizar') {

        $directorio = '../img/invitados/';

        if (!is_dir($directorio)) {
            // https://www.php.net/manual/es/function.mkdir.php
            // modo 0755 (carpetas visibles por los usuarios, pero no pueden modificarlos)
            mkdir($directorio, 0755, true);
        }

        if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])){
            $imagen_url = $_FILES['archivo_imagen']['name'];
            $imagen_resultado = 'La imagen se subió correctamente.';
        } else {
            $respuesta = array (
                'respuesta' => error_get_last()
            );
        }


        $id_registro = $_POST['id_registro'];

        try {
            if ($_FILES['archivo_imagen']['size'] > 0) {
                // Si se cambio la imagen
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url_imagen = ?, editado = NOW() WHERE id_invitado = ?');
                $stmt->bind_param("ssssi", $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url, $id_registro);
            } else {
                // No se cambio la imagen
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE id_invitado = ?');
                $stmt->bind_param("sssi", $nombre_invitado, $apellido_invitado, $biografia_invitado, $id_registro);
            }

            // https://www.php.net/manual/es/mysqli-stmt.execute.php
            // Ejecuta una consulta que ha sido previamente preparada usando la función mysqli_prepare(). 
            // Cuando se ejecutó cualquier marcador de parámetro que existe, será automáticamente reemplazado con los datos apropiados.
            // Devuelve true en caso de éxito o false en caso de error. 
            $estado = $stmt->execute();

            if ($estado == true) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $id_registro
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
    // ELIMINAR INVITADO
    //======================================================================

    if ($registro == 'eliminar') {
        // die(json_encode($_POST));
        $id_borrar = $_POST['id'];

        try {
                // 1) Revisar que existan eventos relacionados con el invitado:
                $sql = "SELECT * FROM eventos WHERE id_inv = $id_borrar";
                $resultado = $conn->query($sql);
                $invitados = $resultado->num_rows;
                // die(json_encode($invitados));

                if($invitados > 0){
                    // Si el invitado ya tiene eventos asignados, primero borramos los eventos.
                    $stmt = $conn->prepare('DELETE FROM eventos WHERE id_inv = ?');
                    $stmt->bind_param("i", $id_borrar);
                    $stmt->execute();

                    if($stmt->affected_rows){
                        $stmt = $conn->prepare('DELETE FROM invitados WHERE id_invitado = ?');
                        $stmt->bind_param("i", $id_borrar);
                        $stmt->execute();
                    }
                } else {
                    //El invitado no tiene eventos relacionados.
                    $stmt = $conn->prepare('DELETE FROM invitados WHERE id_invitado = ?');
                    $stmt->bind_param("i", $id_borrar);
                    $stmt->execute();
                }
                
                if($stmt->affected_rows){
                    $respuesta = array (
                        'respuesta' => 'exito',
                        'id_eliminado' => $id_borrar
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
}


