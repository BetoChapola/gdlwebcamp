<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (ubicada en: include_once 'funciones/sesiones.php') pueda funcionar NO DEBE HABER ningún código antes. En ese archivo existe una validacion para que no se pueda entrar a esta zona si no esta logueado.
// Pero esa validacion tiene una REDIRECCION, por eso se pone hasta el principio para no generar ningun error.
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de categorías de los eventos.
            <small></small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Maneja las categorías en esta sección.</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="registros" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Ícono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $sql = ("SELECT * FROM categoria_evento");
                                    $resultado = $conn->query($sql);
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                                while ($categoria = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $categoria['cat_evento']; ?></td>
                                        <td><i class="fa <?php echo $categoria['icono']; ?>"></i></td>
                                        <td>
                                            <a href="editar-categoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="btn bg-orange btm-flat margin">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" data-id="<?php echo $categoria['id_categoria']; ?>" data-tipo="categoria" class="btn bg-maroon btm-flat margin borrar_registro">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Ícono</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


</div>
<!-- /.content-wrapper -->

<?php include_once 'templates/footer.php';
?>