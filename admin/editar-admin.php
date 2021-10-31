<?php
include_once 'funciones/sesiones.php';
// *** NOTA***
// Para que una redirección PHP (include_once 'funciones/sesiones.php';) pueda funcionar NO DEBE HABER ningún código antes.
include_once 'funciones/funciones.php';
include_once 'templates/header.php';

// Validamos la existencia de la variable "id", que es enviada por la url y la podemos recuperar por $_GET.
// De esa forma podemos hacer la consulta para recuperar los datos desde la BD ese usuario.
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  // Validamos que lo que recibimos por $_GET sea un entero. Se lee: "SI NO es un ENTERO VALIDO"
  // https://www.php.net/manual/es/function.filter-var.php
  // https://www.php.net/manual/es/filter.filters.php
  if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("error");
  }
}

include_once 'templates/barra.php';
include_once 'templates/navegacion.php';
?>

<div class="content-wrapper">
  <!-- Content Wrapper. Contains page content -->

  <section class="content-header">
    <!-- Content Header (Page header) -->
    <h1>Editar Administrador<small>Puedes editar los datos del administrador</small></h1>
  </section>

  <div class="row">
    <div class="col-md-8">
      <section class="content">
        <!-- Main content -->

        <div class="box">
          <!-- .box -->

          <div class="box-header with-border">
            <h3 class="box-title">Editar admin</h3>
          </div>

          <div class="box-body">
            <!-- .box-body -->
            <?php
            $sql = "SELECT * FROM admins where id_admin = $id";
            $resultado = $conn->query($sql);
            $admin = $resultado->fetch_assoc();
            ?>

            <!-- Al momento de presionar el boton "Actualizar" (evento "submit") se envian los datos del formulario
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
                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo $admin['usuario']; ?>">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" value="<?php echo $admin['nombre']; ?>">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password para Iniciar Sesión">
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="registro" value="actualizar">
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
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