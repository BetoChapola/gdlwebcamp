<?php
// *** NOTA***
// Para que una redirección PHP (include_once 'funciones/sesiones.php';) pueda funcionar NO DEBE HABER ningún código antes.
// En el archivo sesiones.php viene la lógica del acceso a áreas protegidas (no se podrá acceder si el usuario no esta logueado). Esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
include_once 'funciones/sesiones.php';
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>


<div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->

    <section class="content-header">
        <!-- Content Header (Page header) -->
        <h1>Crear Administrador<small>Llena los campos para crear un administrador</small></h1>
    </section>

    <div class="row">
        <div class="col-md-8">
            <section class="content">
                <!-- Main content -->

                <div class="box">
                    <!-- .box -->

                    <div class="box-header with-border">
                        <h3 class="box-title">Crear admin</h3>
                    </div>

                    <div class="box-body">
                        <!-- .box-body -->
                        <!-- Al momento de presionar el boton "Añadir" (evento "submit") se envian los datos del formulario
              "guardar-registro" al archivo "admin-ajax.js. Donde se creara un array (de objetos) para enviar los datos de
              forma mas segura al archivo "modelo-admin.php". Este archivo php se encarga de hacer las validaciones
              para poder insertar los datos a la BD. Dando como retorno un json que puede ser utilizado por JS
              para crear efectos como las ventanas de SweetAlert2.
             -->
                        <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-admin.php">
                            <!-- .form -->

                            <div class="box-body">
                                <!--.box-body -->
                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password para Iniciar Sesión">
                                </div>
                                <div class="form-group">
                                    <!-- comprobación del password -->
                                    <label for="password">Repetir Password</label>
                                    <input type="password" class="form-control" id="repetir_password" name="repetir_password" placeholder="Password para Iniciar Sesión">
                                    <span id="resultado_password" class="help-block"></span>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="registro" value="nuevo">
                                <button type="submit" class="btn btn-primary" id="crear_registro_admin">Añadir</button>
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