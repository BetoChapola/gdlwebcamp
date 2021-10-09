$(function () {
  
  // ########## Agregar clase a Menú ##########
  $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass("activo");
  $('body.calendario .navegacion-principal a:contains("Calendario")').addClass("activo");
  $('body.invitados .navegacion-principal a:contains("Invitados")').addClass("activo");
  
  // ########## LETTERING (funciona con css. Revisar el main.css) ##########
  // http://letteringjs.com/
  $(".nombre-sitio").lettering();

  // ########## MENU FIJO ##########
  var windowHeight = $(window).height();
  var barraAltura = $(".barra").innerHeight();

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll > windowHeight) {
      $(".barra").addClass("fixed");
      $("body").css({ "margin-top": barraAltura + "px" });
    } else {
      $(".barra").removeClass("fixed");
      $("body").css({ "margin-top": "0px" });
    }
  });

  // Ejecutamos los scripts solo si son necesarios
  // Crearemos validaciones, tomando en cuenta la clase que le asignamos al <body>
  if ($(".index").length > 0) {
    
    // ########## Programa del Evento ##########
    $("div.ocultar").hide(); //Oculta todos los div (talleres, conferencias, seminarios)
    $(".programa-evento .info-curso:first").show(); //Muestra el primer div (talleres)
    $(".menu-programa a:first").addClass("activo");

    $(".menu-programa a").on("click", function () {
      //Al hacer click en uno de los links (talleres, conferencias, seminarios):
      $(".menu-programa a").removeClass("activo"); //Se le remueve a todos la clase activo (desaparece el trianguilot de indicador)
      $(this).addClass("activo"); //Se le agrega el indicador al elemento que hicimos click
      $(".ocultar").hide(); //Se ocultan los elementos que no esten activos
      var enlace = $(this).attr("href");
      $(enlace).fadeIn(700);
      return false; //para evitar saltos en la pantalla
    });

    // ########## ANIMACION PARA NUMEROS ##########
    // https://aishek.github.io/jquery-animateNumber/
    $(".resumen-evento li:nth-child(1) p").animateNumber({ number: 6 }, 1200);
    $(".resumen-evento li:nth-child(2) p").animateNumber({ number: 15 }, 1200);
    $(".resumen-evento li:nth-child(3) p").animateNumber({ number: 3 }, 600);
    $(".resumen-evento li:nth-child(4) p").animateNumber({ number: 9 }, 1500);

    // ########## Mapa ##########
    var map = L.map("mapa").setView([21.155563, -86.837305], 19);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    L.marker([21.155563, -86.837305])
      .addTo(map)
      .bindPopup("CCWebCamp.<br> Te esperamos.")
      .openPopup();

    // ########## ANIMACION CUENTA REGRESIVA ##########
    // https://hilios.github.io/jQuery.countdown/
    $(".cuenta-regresiva").countdown("2021/12/10 9:00:00", function (event) {
      $("#dias").html(event.strftime("%D"));
      $("#horas").html(event.strftime("%H"));
      $("#minutos").html(event.strftime("%M"));
      $("#segundos").html(event.strftime("%S"));
    });
  }

  if ($(".invitados").length > 0) {
    // ########## ColorBox (Lo puse al inicio porue causa conflicto al final.)  ##########
    $(".invitado-info").colorbox({ inline: true, width: "50%" });
  }

});
