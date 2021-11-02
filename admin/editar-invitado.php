<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("Error");
    }
}
include_once 'funciones/sesiones.php';
/**  NOTA: Para que una redirección PHP 
 (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún  código antes.
 En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
 Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
*/
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>

<div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->

    <section class="content-header">
        <!-- Content Header (Page header) -->
        <h1>Edita los datos de un Invitados<small>Llena los campos para editar un invitado</small></h1>
    </section>

    <div class="row">
        <div class="col-md-8">
            <section class="content">
                <!-- Main content -->

                <div class="box">
                    <!-- .box -->

                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Invitado</h3>
                    </div>

                    <div class="box-body">
                        <!-- .box-body -->
                        <?php 
                            $sql = "SELECT * FROM invitados WHERE id_invitado = $id";
                            $resultado = $conn->query($sql);
                            $invitado = $resultado->fetch_assoc();
                        ?>
                        <form role="form" name="guardar-registro" id="guardar-registro-archivo" method="POST" action="modelo-invitado.php" enctype="multipart/form-data">
                            <!-- .form -->

                            <div class="box-body">
                                <!--.box-body -->
                                <div class="form-group">
                                    <label for="nombre_invitado">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre del invitado" value="<?php echo $invitado['nombre_invitado'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_invitado">Apellido:</label>
                                    <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido del invitado" value="<?php echo $invitado['apellido_invitado'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="biografia_invitado">Biografía:</label>
                                    <textarea name="biografia_invitado" id="biografia_invitado" cols="30" class="form-control" placeholder="Biografía del invitado"><?php echo $invitado['descripcion'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen_invitado">Imagen del invitado:</label>
                                    <br>
                                    <img src="../img/invitados/<?php echo $invitado['url_imagen'] ?>" width="200rem">
                                </div>
                                <div class="form-group">
                                    <label for="imagen_invitado">File input</label>
                                    <input type="file" id="imagen_invitado" name="archivo_imagen">

                                    <p class="help-block">Añada la imagen del invitado.</p>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?php echo $invitado['id_invitado']; ?>">
                                <button type="submit" class="btn btn-primary" id="crear_registro">Actualizar</button>
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