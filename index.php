<?php include_once 'includes/templates/header.php';?>

  <section class="seccion contenedor">
    <h2>La mejor conferencia de Diseño Web en Español</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore tenetur animi sequi accusantium quidem ipsam,
      numquam reiciendis, ratione unde architecto doloremque illo! Doloremque praesentium accusamus expedita,
      perferendis neque consectetur perspiciatis, minus dicta animi similique rerum.</p>
  </section><!-- seccion -->

  <section class="programa">
    <div class="contenedor-video">
      <video autoplay loop poster="img/bg-talleres.jpg" muted>
        <source src="video/video.mp4" type="video/mp4">
        <source src="video/video.webm" type="video/webm">
        <source src="video/video.ogv" type="video/ogg">
      </video>
    </div>
    <!--.contenedor-video-->
    <div class="contenido-programa">
        <div class="contenedor">
            <div class="programa-evento">
                <h2>programa del evento</h2>

                <?php
                try {
                    require_once('includes/funciones/bdconexion.php');
                    $sql = " SELECT * FROM categoria_evento ";
                    $resultado = $conn->query($sql);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                ?>

                <nav class="menu-programa">
                    <?php
                    while ($cat = $resultado->fetch_assoc()) {
                        $categoria = $cat['cat_evento'];
                        $icono = $cat['icono']; ?>
                        <a href="#<?php echo strtolower($categoria) ?>">
                            <i class="fas <?php echo $icono ?>"></i>
                            <?php echo $categoria ?>
                        </a>
                    <?php } ?>
                </nav>

                <?php
                try {
                    require_once('includes/funciones/bdconexion.php');
                    $sql = " SELECT id_evento, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.id_invitado ";
                    $sql .= " AND eventos.id_cat_evento = 1 ";
                    $sql .= " ORDER BY id_evento LIMIT 2;";
                    $sql .= " SELECT id_evento, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.id_invitado ";
                    $sql .= " AND eventos.id_cat_evento = 2 ";
                    $sql .= " ORDER BY id_evento LIMIT 2;";
                    $sql .= " SELECT id_evento, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
                    $sql .= " FROM eventos ";
                    $sql .= " INNER JOIN categoria_evento ";
                    $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                    $sql .= " INNER JOIN invitados ";
                    $sql .= " ON eventos.id_inv = invitados.id_invitado ";
                    $sql .= " AND eventos.id_cat_evento = 3 ";
                    $sql .= " ORDER BY id_evento LIMIT 2;";
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                ?>

                <?php $conn->multi_query($sql); ?>
                <?php
                do {
                    $resultado = $conn->store_result();
                    $row = $resultado->fetch_all(MYSQLI_ASSOC); ?>

                    <?php $i = 0; ?>
                    <?php foreach ($row as $evento) : ?>
                        <?php if ($i % 2 == 0) { ?>
                            <div id="<?php echo strtolower($evento['cat_evento']) ?>" class="info-curso ocultar clearfix">
                            <?php } ?>

                            <div class="detalle-evento">
                                <h3><?php echo $evento['nombre_evento'] ?></h3>
                                <p><i class="fas fa-clock"></i><?php echo $evento['hora_evento'] ?></p>
                                <p><i class="fas fa-calendar-alt"></i><?php echo $evento['fecha_evento'] ?></p>
                                <p><i class="fas fa-user"></i><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado'] ?></p>
                            </div>

                            <?php if ($i % 2 == 1) : ?>
                                <a href="calendario.php" class="button float-right">Ver Todos</a>
                            </div><!-- #talleres .info-curso -->
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <?php $resultado->free(); ?>

                <?php
                } while ($conn->more_results() && $conn->next_result());
                ?>



            </div><!-- .programa-evento -->
        </div><!-- .contenedor -->
    </div><!-- .contenido-programa -->
  </section>
  <!--.programa-->

  <?php include_once 'includes/templates/invitados.php'; ?>
  <!-- END .invitados -->

  <div class="contador parallax">
    <div class="contenedor">
      <ul class="resumen-evento clearfix">
        <li>
          <p class="numero"></p> Invitados
        </li>
        <li>
          <p class="numero"></p> Talleres
        </li>
        <li>
          <p class="numero"></p> Días
        </li>
        <li>
          <p class="numero"></p> Conferencias
        </li>
      </ul>
    </div>
  </div><!-- CONTADOR -->

  <section class="precios seccion">
    <h2>Precios</h2>
    <div class="contenedor">
      <ul class="lista-precios clearfix">
        <li>
          <div class="tabla-precio">
            <h3>Pase por día</h3>
            <p class="numero">$30</p>
            <ul>
              <li>Bocadillos Gratis</li>
              <li>Todas las conferencias</li>
              <li>Todos los talleres</li>
            </ul>
            <a href="#" class="button hollow">Comprar</a>
          </div>
        </li>
        <li>
          <div class="tabla-precio">
            <h3>Todos los días</h3>
            <p class="numero">$50</p>
            <ul>
              <li>Bocadillos Gratis</li>
              <li>Todas las conferencias</li>
              <li>Todos los talleres</li>
            </ul>
            <a href="#" class="button">Comprar</a>
          </div>
        </li>

        <li>
          <div class="tabla-precio">
            <h3>Pase por 2 días</h3>
            <p class="numero">$45</p>
            <ul>
              <li>Bocadillos Gratis</li>
              <li>Todas las conferencias</li>
              <li>Todos los talleres</li>
            </ul>
            <a href="#" class="button hollow">Comprar</a>
          </div>
        </li>
      </ul>
    </div>
  </section> <!-- PRECIOS -->

  <section class="seccion">
    <div class="contenedor">
      <div id="mapa" class="mapa">MAPA</div>
    </div>
  </section>
  <!--MAPA-->

  <section class="seccion">
    <h2>Testimoniales</h2>
    <div class="testimoniales contenedor clearfix">
      <div class="testimonial">
        <blockquote>
          <p>Sed mollis velit sit amet felis condimentum ultrices. Fusce vehicula ut sem vitae semper. Nullam blandit
            neque eu semper ullamcorper. Duis commodo quam in orci condimentum ultricies.
          <footer class="info-testimonial clearfix">
            <img src="img/testimonial.jpg" alt="imagen testimonial">
            <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
          </footer>
        </blockquote>
      </div>
      <!--.testimonial-->
      <div class="testimonial">
        <blockquote>
          <p>Sed mollis velit sit amet felis condimentum ultrices. Fusce vehicula ut sem vitae semper. Nullam blandit
            neque eu semper ullamcorper. Duis commodo quam in orci condimentum ultricies.
          <footer class="info-testimonial clearfix">
            <img src="img/testimonial.jpg" alt="imagen testimonial">
            <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
          </footer>
        </blockquote>
      </div>
      <!--.testimonial-->
      <div class="testimonial">
        <blockquote>
          <p>Sed mollis velit sit amet felis condimentum ultrices. Fusce vehicula ut sem vitae semper. Nullam blandit
            neque eu semper ullamcorper. Duis commodo quam in orci condimentum ultricies.
          <footer class="info-testimonial clearfix">
            <img src="img/testimonial.jpg" alt="imagen testimonial">
            <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
          </footer>
        </blockquote>
      </div>
      <!--.testimonial-->
    </div>
  </section>
  <!--TESTIMONIALES-->

  <div class="newsletter parallax">
    <div class="contenido contenedor">
      <p> regístrate al newsletter:</p>
      <h3>gdlwebcamp</h3>
      <a href="#" class="boton_newsletter button transparente">Registro</a>
    </div>
    <!--.contenido-->
  </div>
  <!--NEWSLETTER-->

  <section class="seccion">
    <h2>Faltan</h2>
    <div class="cuenta-regresiva contenedor">
      <ul class="clearfix">
        <li>
          <p id="dias" class="numero"></p> días
        </li>
        <li>
          <p id="horas" class="numero"></p> horas
        </li>
        <li>
          <p id="minutos" class="numero"></p> minutos
        </li>
        <li>
          <p id="segundos" class="numero"></p> segundos
        </li>
      </ul>
    </div>
  </section>
  <!--CUENTA REGESIVA-->

  <?php include_once 'includes/templates/footer.php';?>