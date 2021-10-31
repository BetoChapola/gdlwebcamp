<?php
// Cerramos una sesión obteniendo una variable desde el boton "cerrar sesión".
// Primero debe existir una sesión para cerrar:
session_start();
if (isset($_GET['cerrar_sesion'])) {
  $cerrar_sesion = $_GET['cerrar_sesion']; //Guardamos la respuesta en una variable
  if ($cerrar_sesion) { //Si existe la variable
    session_destroy();  //destruimos la sesión
  }
}
// funciones.php solo tiene la conexion a la BD
include_once 'funciones/funciones.php';
include_once 'templates/header.php';
?>

<body class="hold-transition login-page"> <!-- el body se copia de la barra para que el fondo se vea gris (aqui estan los estilos de las paginas) -->
  <div class="login-box">
    <div class="login-logo">
      <a href="../index.php"><b>Gdl</b>WebCamp</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Inicia Sesión para comenzar</p>

      <!-- Mandamos los datos del usuario a un archivo php para su validación: login-admin.php -->
      <form name="login-admin-form" id="login-admin" method="POST" action="login-admin.php">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12" style="margin: 20px auto">
            <input type="hidden" name="login-admin" value="1">
            <button type="submit" class="btn btn-success btn-block btn-flat">Iniciar Sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- <a href="#" style="margin-top: 2rem;">Olvidé mi Password</a><br>
    <a href="register.html" class="text-center">Registrar un nuevo Usuario</a> -->

    </div>
    <!-- /.login-box-body -->
  </div>

  <?php
  include_once 'templates/footer.php';
  ?>