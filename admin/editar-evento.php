<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Validamos que lo que recibimos por $_GET sea un entero. Se lee: "SI NO es un ENTERO VALIDO"
    // https://www.php.net/manual/es/function.filter-var.php
    // https://www.php.net/manual/es/filter.filters.php
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("error");
    }
}

?>


<div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->

    <section class="content-header">
        <!-- Content Header (Page header) -->
        <h1>Crear Evento<small>Llena los campos para crear un Evento</small></h1>
    </section>

    <div class="row">
        <div class="col-md-8">
            <section class="content">
                <!-- Main content -->

                <div class="box">
                    <!-- .box -->

                    <div class="box-header with-border">
                        <h3 class="box-title">Crear Evento</h3>
                    </div>

                    <div class="box-body">
                        <!-- .box-body -->
                        <?php 
                            $sql = "SELECT id_cat_evento, id_inv, nombre_evento, fecha_evento, hora_evento FROM eventos WHERE id_evento = $id";
                            $resultado = $conn->query($sql);
                            $evento = $resultado->fetch_assoc();
                        ?>
                        <!-- Al momento de presionar el boton "Añadir" (evento "submit") se envian los datos del formulario
                            "guardar-registro" al archivo "admin-ajax.js. Donde se creara un array (de objetos) para enviar los datos de
                            forma mas segura al archivo "modelo-evento.php". Este archivo php se encarga de hacer las validaciones
                            para poder insertar los datos a la BD. Dando como retorno un json que puede ser utilizado por JS
                            para crear efectos como las ventanas de SweetAlert2.
                        -->
                        <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-evento.php">
                            <!-- .form -->

                            <div class="box-body">
                                <!--.box-body -->
                                <div class="form-group">
                                    <label for="usuario">Título del Evento</label>
                                    <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" placeholder="Título del Evento" value="<?php echo $evento['nombre_evento'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>

                                    <select name="categoria_evento" id="" class="form-control seleccionar" style="width: 100%;">
                                        <option value="0">- Selecciona una categoría -</option>

                                        <?php
                                        try {
                                            $categoria_actual = $evento['id_cat_evento'];
                                            $sql = "SELECT * FROM categoria_evento";
                                            $resultado = $conn->query($sql);

                                            while ($cat_evento = $resultado->fetch_assoc()) { 

                                                if ($cat_evento['id_categoria'] == $categoria_actual) { ?>

                                                <option value="<?php echo $cat_evento['id_categoria']; ?>" selected>
                                                    <?php echo $cat_evento['cat_evento']; ?>
                                                </option>


                                              <?php  } else { ?>

                                                <option value="<?php echo $cat_evento['id_categoria']; ?>">
                                                    <?php echo $cat_evento['cat_evento']; ?>
                                                </option>

                                              <?php } ?>
                                                
                                      <?php }

                                        } catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();
                                        } ?>

                                    </select>
                                </div>

                                <!-- Date Picker -->
                                <div class="form-group">
                                    <label>Fecha Evento:</label>
                                    <?php 
                                        $fecha = $evento['fecha_evento'];
                                        $fecha_formateada = date('m/d/Y', strtotime($fecha));
                                    ?>
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control pull-right" id="fecha_evento" name="fecha_evento" value="<?php echo $fecha_formateada ?>">
                                    </div>
                                </div>
                                <!-- time Picker -->
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora:</label>
                                        <?php 
                                            $hora = $evento['hora_evento'];
                                            $hora_formateada = date('h:i a', strtotime($hora));
                                        ?>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="hora_evento" value="<?php echo $hora_formateada ?>">

                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Invitado o Ponente:</label>

                                    <select name="invitado" id="" class="form-control seleccionar" style="width: 100%;">
                                        <option value="0">- Selecciona un Invitado -</option>
                                        <?php
                                        try {
                                            $invitado_actual = $evento['id_inv'];
                                            $sql = "SELECT id_invitado, nombre_invitado, apellido_invitado FROM invitados";
                                            $resultado = $conn->query($sql);

                                            while ($invitados = $resultado->fetch_assoc()) {

                                                if ($invitados['id_invitado'] == $invitado_actual) { ?>
                                                   
                                                   <option value="<?php echo $invitados['id_invitado']; ?>" selected>
                                                        <?php echo $invitados['nombre_invitado'] . ' ' . $invitados['apellido_invitado']; ?>
                                                   </option>

                                                <?php } else { ?>

                                                   <option value="<?php echo $invitados['id_invitado']; ?>">
                                                        <?php echo $invitados['nombre_invitado'] . ' ' . $invitados['apellido_invitado']; ?>
                                                   </option>

                                               <?php } ?>

                                    <?php }
                                        } catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>

                                </div>

                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?php echo $id ?>">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>

                        </form><!-- /.form -->

                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </section><!-- /.content -->
        </div>
    </div>

</div><!-- /.content-wrapper -->

<?php
include_once 'templates/footer.php';
?>