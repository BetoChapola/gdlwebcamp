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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Listado de eventos.
      <small>Puedes editar o borrar eventos.</small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Maneja los eventos en esta sección.</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="registros" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Evento</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Invitado</th>
                  <th>Categoría</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                try {
                  $sql = "SELECT id_evento, nombre_evento, fecha_evento, hora_evento, cat_evento, nombre_invitado, apellido_invitado ";
                  $sql .= " FROM eventos ";
                  $sql .= " INNER JOIN categoria_evento ";
                  $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                  $sql .= " INNER JOIN invitados ";
                  $sql .= " ON eventos.id_inv = invitados.id_invitado ";
                  $sql .= " ORDER BY id_evento ";

                  $resultado = $conn->query($sql);
                } catch (Exception $e) {
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($eventos = $resultado->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $eventos['nombre_evento']; ?></td>
                    <td><?php echo $eventos['fecha_evento']; ?></td>
                    <td><?php echo $eventos['hora_evento']; ?></td>
                    <td><?php echo $eventos['nombre_invitado'] . ' ' . $eventos['apellido_invitado']; ?></td>
                    <td><?php echo $eventos['cat_evento']; ?></td>
                    <td>
                      <a href="editar-evento.php?id=<?php echo $eventos['id_evento']; ?>" class="btn bg-orange btm-flat margin">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="#" data-id="<?php echo $eventos['id_evento']; ?>" data-tipo="evento" class="btn bg-maroon btm-flat margin borrar_registro">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Evento</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Invitado</th>
                  <th>Categoría</th>
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