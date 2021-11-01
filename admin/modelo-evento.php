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

    /**Recuerda, si declaramos una VARIABLE SIN DEFINIR el programa se detendrá justamente ahí.*/

    /**
     
        NOTA: https://www.it-swarm-es.com/es/php/uso-del-operador-ternario-sin-la-instruccion-else-php/1052567831/
     */
    // Titulo del evento
    !isset($_POST['titulo_evento']) ?: 
    $titulo = $_POST['titulo_evento'];
    // Nombre de la categoría del evento
    !isset($_POST['categoria_evento']) ?: 
    $categoria_id = $_POST['categoria_evento'];
     //F E C H A del evento
    !isset($_POST['fecha_evento']) ?: 
    $fecha = $_POST['fecha_evento'];
    !isset($fecha) ?: 
    $fecha_formateada = date('Y-m-d', strtotime($fecha));
     //H O R A del evento
    !isset($_POST['hora_evento']) ?: 
    $hora = $_POST['hora_evento'];
    !isset($hora) ?: 
    $hora_formateada = date('H:i', strtotime($hora));
    // Id del invitado
    !isset($_POST['invitado']) ?: 
    $invitado_id = $_POST['invitado'];
    
    //registro = nuevo/actualizar/eliminar
    $registro = $_POST['registro'];

    //======================================================================
    // INSERTAR NUEVO EVENTO
    //======================================================================

    if ($registro == 'nuevo') {
        $stmt = $conn->prepare('INSERT INTO eventos (nombre_evento, fecha_evento, hora_evento, id_cat_evento, id_inv) VALUES (?, ?, ?, ?, ?)');
        try {
            $stmt->bind_param('sssii', $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;
            if ($stmt->affected_rows) {
                $respuesta = array (
                'respuesta' => 'exito',
                'id_insertado' => $id_insertado
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
    // MODIFICAR EVENTO
    //======================================================================

    if ($registro == 'actualizar') {
        $id_registro = $_POST['id_registro'];

        try {
            //En este bloque si me funciono la función NOW() 👍
            $stmt = $conn->prepare('UPDATE eventos SET nombre_evento = ?, fecha_evento = ?, hora_evento = ?, id_cat_evento = ?, id_inv = ?, editado = NOW() WHERE id_evento = ?');
            $stmt->bind_param("sssiii", $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id, $id_registro);
            $stmt->execute();
            if ($stmt->affected_rows) {
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
    // ELIMINAR EVENTO
    //======================================================================

    if ($registro == 'eliminar') {
        // die(json_encode($_POST));
        $id_borrar = $_POST['id'];

        try {
            $stmt = $conn->prepare('DELETE FROM eventos WHERE id_evento = ?');
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


