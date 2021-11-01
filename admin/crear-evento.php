<?php
// *** NOTA***
// Para que una redirección PHP (include_once 'funciones/sesiones.php';) pueda funcionar NO DEBE HABER ningún código antes.
// En el archivo sesiones.php viene la lógica del acceso a áreas protegidas (no se podrá acceder si el usuario no esta logueado). Esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/sesiones.php';
include_once 'funciones/funciones.php'; //Tiene la conexion a la BD
include_once 'templates/header.php'; // Carga todos los archivos de estilos.
include_once 'templates/barra.php'; // Carga la barra principal que esta en todas las paginas.
include_once 'templates/navegacion.php'; // Carga el panel lateral de navegación del proyecto.
?>

<!-- RECORDAR: que en este nivel ya existen todas las variables de sesion que creamos en el archivo de validacion "login-admin.php": 
  session_start();
  $_SESSION['usuario'] = $usuario_admin;
  $_SESSION['nombre'] = $nombre_admin;
  $_SESSION['nivel'] = $nivel;
  $_SESSION['id'] = $id_admin;

-->


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
                                    <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" placeholder="Título del Evento">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <select name="categoria_evento" id="" class="form-control seleccionar" style="width: 100%;">
                                        <option value="0">- Selecciona una categoría -</option>
                                        <?php
                                        try {
                                            $sql = "SELECT * FROM categoria_evento";
                                            $resultado = $conn->query($sql);
                                            while ($cat_evento = $resultado->fetch_assoc()) { ?>
                                                <option value="<?php echo $cat_evento['id_categoria']; ?>">
                                                    <?php echo $cat_evento['cat_evento']; ?>
                                                </option>
                                        <?php   }
                                        } catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Date Picker -->
                                <div class="form-group">
                                    <label>Fecha Evento:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control pull-right" id="fecha_evento" name="fecha_evento">
                                    </div>
                                </div>
                                <!-- time Picker -->
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Hora:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="hora_evento">

                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Invitado o Ponente:</label>
                                    <select name="invitado" id="" class="form-control seleccionar" style="width: 100%;">
                                        <option value="0">- Selecciona un Invitado -</option>
                                        <?php
                                        try {
                                            $sql = "SELECT id_invitado, nombre_invitado, apellido_invitado FROM invitados";
                                            $resultado = $conn->query($sql);
                                            while ($invitados = $resultado->fetch_assoc()) { ?>
                                                <option value="<?php echo $invitados['id_invitado']; ?>">
                                                    <?php echo $invitados['nombre_invitado'] . ' ' . $invitados['apellido_invitado']; ?>
                                                </option>
                                        <?php   }
                                        } catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="registro" value="nuevo">
                                <button type="submit" class="btn btn-primary">Añadir</button>
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