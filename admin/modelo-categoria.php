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
    !isset($_POST['nombre_categoria']) ?: 
    $nombre_categoria = $_POST['nombre_categoria'];

    // Icono
    !isset($_POST['icono']) ?: 
    $icono  = $_POST['icono'];

    //registro = nuevo/actualizar
    $registro = $_POST['registro'];

    //======================================================================
    // INSERTAR NUEVO CATEGORIA
    //======================================================================

    if ($registro == 'nuevo') {
        // die(json_encode($_POST));
        $stmt = $conn->prepare('INSERT INTO categoria_evento (cat_evento, icono) VALUES (?, ?)');
        try {
            $stmt->bind_param('ss', $nombre_categoria, $icono);
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
    // MODIFICAR CATEGORIA
    //======================================================================

    if ($registro == 'actualizar') {
        // die(json_encode($_POST));
        $id_registro = $_POST['id_registro'];

        try {
            //En este bloque si me funciono la función NOW() 👍
            $stmt = $conn->prepare('UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW() WHERE id_categoria = ?');
            $stmt->bind_param("ssi", $nombre_categoria, $icono, $id_registro);
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
    // ELIMINAR CATEGORIA
    //======================================================================
    // En esta sección, debemos poner especial atención con las relaciones de la tabla;
    // ya que la tabla "categoria_evento" es una tabla de la cual dependen otras tablas (eventos).
    // Su campo "id_categoria" es una llave foranea en otras tablas (eventos). Entonces NO SE PUEDE ELIMINAR sin antes
    // "deshacer" o eliminar sus relaciones con las otras tablas, en las cuales tambien se tendrán
    // que eliminar los registros relacionados.

    // Tambien se debe considerar que 

    if ($registro == 'eliminar') {
        // die(json_encode($_POST));
        $id_borrar = $_POST['id'];

        try {
                // 1) Revisar que existan eventos relacionados con la categoría:
                $sql = "SELECT * FROM eventos WHERE id_cat_evento = $id_borrar";
                $resultado = $conn->query($sql);
                $eventos = $resultado->num_rows;
                // die(json_encode($eventos));

                if($eventos > 0){
                    // Si la categoría ya tiene eventos asignados, primero borramos los eventos.
                    $stmt = $conn->prepare('DELETE FROM eventos WHERE id_cat_evento = ?');
                    $stmt->bind_param("i", $id_borrar);
                    $stmt->execute();

                    if($stmt->affected_rows){
                        $stmt = $conn->prepare('DELETE FROM categoria_evento WHERE id_categoria = ?');
                        $stmt->bind_param("i", $id_borrar);
                        $stmt->execute();
                    }
                } else {
                    //La categoría no tiene eventos relacionados.
                    $stmt = $conn->prepare('DELETE FROM categoria_evento WHERE id_categoria = ?');
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


