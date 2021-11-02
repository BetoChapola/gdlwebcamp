<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>

<div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->

    <section class="content-header">
        <!-- Content Header (Page header) -->
        <h1>Crea Invitados para los Eventos<small>Llena los campos para agregar un invitado</small></h1>
    </section>

    <div class="row">
        <div class="col-md-8">
            <section class="content">
                <!-- Main content -->

                <div class="box">
                    <!-- .box -->

                    <div class="box-header with-border">
                        <h3 class="box-title">Crear Invitado</h3>
                    </div>

                    <div class="box-body">
                        <!-- .box-body -->
                        <!-- Al momento de presionar el boton "Añadir" (evento "submit") se envian los datos del formulario
                            "guardar-registro" al archivo "admin-ajax.js. Donde se creara un array (de objetos) para enviar los datos de
                            forma mas segura al archivo "modelo-invitado.php". Este archivo php se encarga de hacer las validaciones
                            para poder insertar los datos a la BD. Dando como retorno un json que puede ser utilizado por JS
                            para crear efectos como las ventanas de SweetAlert2.
                        -->
                        <form role="form" name="guardar-registro" id="guardar-registro-archivo" method="POST" action="modelo-invitado.php" enctype="multipart/form-data">
                            <!-- .form -->

                            <div class="box-body">
                                <!--.box-body -->
                                <div class="form-group">
                                    <label for="nombre_invitado">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre del invitado">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_invitado">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido del invitado">
                                </div>
                                <div class="form-group">
                                    <label for="biografia_invitado">Biografía:</label>
                                    <textarea name="biografia_invitado" id="biografia_invitado" cols="30" class="form-control" placeholder="Biografía del invitado"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen_invitado">File input</label>
                                    <input type="file" id="imagen_invitado" name="archivo_imagen">

                                    <p class="help-block">Añada la imagen del invitado.</p>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="registro" value="nuevo">
                                <button type="submit" class="btn btn-primary" id="crear_registro">Añadir</button>
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