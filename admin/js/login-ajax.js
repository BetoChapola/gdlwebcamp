  $(document).ready(function () {

    //======================================================================
    // L  O  G  I  N
    //======================================================================
    $('#login-admin').on('submit', function (e) {
      e.preventDefault();

      var datos = $(this).serializeArray();
      console.log(datos);

      $.ajax({
        type: $(this).attr('method'),
        data: datos,
        url: $(this).attr('action'),
        dataType: 'json',
        success: function (data) {

          var resultado = data;
          console.log(resultado);
          if (resultado.respuesta == 'exitoso') {
            Swal.fire(
              'Login Correcto!',
              'Bienvenido ' + resultado.usuario + '!!!',
              'success'
            )
            setTimeout(function () {
              window.location.href = 'admin-area.php'
            }, 2000);
          } else {
            Swal.fire(
              'Error!',
              'El usuario o password son incorrectos!',
              'error'
            )
          }

        }
      })
    });

  });
