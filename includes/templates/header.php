<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="stylesheet" href="css/normalize.css">
 <!-- FONT AWESOME (https://cdnjs.com/), extraido de este link -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
  <!-- FONT AWESOME (en local) -->
  <link rel="stylesheet" href="css/fontawesome-all.min.css">
  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Oswald:wght@200;300;400;500;600;700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <!-- MAIN -->
  <link rel="stylesheet" href="css/main.css">
  <!-- CARGA EL CSS DPENDIENDO DE LA PAGINA -->
  <?php
    $archivo = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace(".php", "", $archivo);
    if ($pagina == 'index' || $pagina == 'invitados') {
      // ColorBox
      echo '<link rel="stylesheet" href="css/colorbox.css">';
    }if ($pagina == 'index') {
      //Mapa
      echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />';
    }if ($pagina == 'conferencia') {
      // LightBox
      echo '<link rel="stylesheet" href="css/lightbox.css">';
    }
  ?>

  <meta name="theme-color" content="#fafafa">
</head>

<body class="<?php echo $pagina; ?>">

  <div class="site-header">
    <div class="hero">
      <div class="contenido-header">

        <nav class="redes-sociales">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-pinterest-p"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </nav>

        <div class="informacion-evento">
          <div class="clearfix">
            <p class="fecha"><i class="fas fa-calendar-alt"></i>10 - 12 dic</p>
            <p class="ciudad"><i class="fas fa-map-marker-alt"></i>Cancun, Mx</p>
          </div>

          <h1 class="nombre-sitio">CcWebCamp</h1>
          <p class="slogan">La mejor conferencia de <span>Diseño Web</span></p>
        </div>

      </div>
    </div>
  </div> <!-- /HEADER -->

  <div class="barra">
    <div class="contenedor clearfix">
      <div class="logo">
        <a href="index.php">
          <img src="img/logo.svg">
        </a>
      </div>

      <div class="menu-movil">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <nav class="navegacion-principal">
        <a href="conferencia.php">Conferencia</a>
        <a href="calendario.php">Calendario</a>
        <a href="invitados.php">Invitados</a>
        <a href="registro.php">Reservaciones</a>

      </nav>
    </div><!-- .contenedor -->
  </div><!-- .barra -->