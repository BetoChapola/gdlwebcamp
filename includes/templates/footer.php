<footer class="site-footer">
  <div class="contenedor clearfix">
    <div class="footer-informacion">
      <h3>Sobre <span>gdlwebcamp</span></h3>
      <p>Praesent rutrum efficitur pharetra. Vivamus scelerisque pretium velit, id tempor turpis pulvinar et. Ut
        bibendum finibus massa non molestie. Curabitur urna metus, placerat gravida lacus ut, lacinia congue orci.
        Maecenas luctus mi at ex
        blandit vehicula. Morbi porttitor tempus euismod.</p>
    </div>
    <div class="ultimos-tweets">
      <h3>Últimos <span>tweets</span></h3>
      <ul>
        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, blanditiis similique debitis dolores
          aspernatur impedit.</li>
        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, blanditiis similique debitis dolores
          aspernatur impedit.</li>
        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, blanditiis similique debitis dolores
          aspernatur impedit.</li>
      </ul>
    </div>
    <div class="menu">
      <h3>Redes <span>sociales</span></h3>
      <nav class="redes-sociales">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-pinterest-p"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </nav>
    </div>
  </div>
  <p class="copyrigth">Todos los derechos reservados CCWEBCAMP | Caifán 2020</p>
</footer>

<script src="js/vendor/modernizr-3.8.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
  window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')
</script>
<script src="js/plugins.js"></script>

<!--MAPA-->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!--ANIMATE NUMBER-->
<script src="js/jquery.animateNumber.min.js"></script>
<!--COUNT DOWN (NUMEROS EN CUENTA REGRESIVA)-->
<script src="js/jquery.countdown.min.js"></script>
<!--LETTERING-->
<script src="js/jquery.lettering.js"></script>
<!-- MAIN -->
<script src="js/main.js"></script>
<!-- COTIZADOR -->
<script src="js/cotizador.js"></script>

<?php
$archivo = basename($_SERVER['PHP_SELF']);
$pagina = str_replace(".php", "", $archivo);
if ($pagina == 'invitados' || $pagina == 'index') {
  echo '<script src="js/jquery.colorbox-min.js"></script>';
} else if ($pagina == 'conferencia') {
  echo '<script src="js/lightbox.js"></script>';
}
?>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
  window.ga = function() {
    ga.q.push(arguments)
  };
  ga.q = [];
  ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto');
  ga('set', 'transport', 'beacon');
  ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>