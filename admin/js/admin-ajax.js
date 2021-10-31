$(document).ready(function () {

/** 
  Esta es la función jQuery para llamar al formulario por su ID. En su evento 'submit' ejecutamos una función
  y atrapamos su evento (e). Prevenimos que se ejecute el 'action' del <form> para que podamos manejar los datos desde
  jQuery.

  El motivo por el cual creamos este archivo es para no mostrar el contenido de 'modelo-admin.php'. Queremos que ese doducmento
  solo se encargue del proceso de inserción de datos. Pero el manejo de los datos estará a cargo de este archivo.
*/

  //======================================================================
  // INSERTAR NUEVO ADMINISTRADOR
  //======================================================================
  $('#guardar-registro').on('submit', function (e) {
    e.preventDefault();

    // Podemos almacenar los datos en un array de varios objetos, es similar al FormData();
    // https://api.jquery.com/serializearray/
    var datos = $(this).serializeArray();
      /*
          la estructura del array serializeArray() es similar a esto:
          Array(4) [ {…}, {…}, {…}, {…} ]
          0: Object { name: "usuario", value: "_dato_" }
          1: Object { name: "nombre", value: "_dato_" }
          2: Object { name: "password", value: "_dato_" }
          3: Object { name: "registro", value: "_dato_" }
      */


    $.ajax({
      type: $(this).attr('method'), //definidmos el tipo del request (post)
      data: datos, // nombramos los datos que enviaremos
      url: $(this).attr('action'), // la dirección a dónde vamos a enviar los datos (modelo-admin.php.)
      dataType: 'json', //usaremos json como portador de datos
      success: function (data) {
        // Aquí recibímos la respuesta del archivo que esta en la "url: $(this).attr('action')", en este caso es modelo-admin.php.
        console.log(data);

        var resultado = data;
        if (resultado.respuesta == 'exito') {
          Swal.fire(
            'Correcto!',
            'El administrador se guardo correctamente!',
            'success'
          )
          // document.getElementById('guardar-registro').reset();
          //Funciona, pero no quita los estilo de los campos de password
        } else {
          Swal.fire(
            'Error!',
            'Hubo un error!',
            'error'
          )
        }
      }
    })
  });

    //======================================================================
  // INSERTAR NUEVO INVITADO (incluye la imagen del invitado)
  //======================================================================
  $('#guardar-registro-archivo').on('submit', function (e) {
    e.preventDefault();

    var datos = new FormData(this);

    $.ajax({
      type: $(this).attr('method'),
      data: datos,
      url: $(this).attr('action'),
      dataType: 'json',
      contentType: false,
      processData: false,
      async: true,
      cache: false,
      success: function (data) {
        // Aquí recibímos la respuesta del archivo que esta en la "url: $(this).attr('action')", en este caso es
        // modelo-invitado.php.
        console.log(data);

        var resultado = data;
        if (resultado.respuesta == 'exito') {
          Swal.fire(
            'Correcto!',
            'El administrador se creo correctamente!',
            'success'
          )
        } else {
          Swal.fire(
            'Error!',
            'Hubo un error!',
            'error'
          )
        }
      }
    })
  });
  //======================================================================
  // ELIMINAR ADMINISTRADOR
  //======================================================================

  /**
      Borraremos un registro mediante el icono de borrar que se encuentra en la columna de acciones.
      El boton tiene una CLASE (.borrar_registro) que funcionará como SELECTOR para poder llamar a la función de borrado.
      Cuando hacemos click en el icono de borrar se previene la acción del <a></a>.
  **/ 

  $('.borrar_registro').on('click', function (e) {
      e.preventDefault();

      // Vamos a utilizar nuestros atributos personalizados: data-id y data-tipo
      // Creamos data-tipo para usar menos archivos. Asi solo haremos llegar el "tipo" de elemento que queremos borrar,
      // haciendo mas reutilizable nuestro código.
      var id = $(this).attr('data-id');
      var tipo = $(this).attr('data-tipo');

      Swal.fire({
          title: '¿Quieres eliminar este registro?',
          text: "Un registro eliminado no se puede recuperar!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminar!',
          cancelButtonText: 'No, Cancelar!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                type: 'post',
                data: {
                  'id': id,
                  'registro': 'eliminar'
                },
                url: 'modelo-' + tipo + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    console.log(resultado);
                    if (resultado.respuesta == 'exito') {
                        Swal.fire(
                          'Eliminado!',
                          'El registro ha sido eliminado.',
                          'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error...',
                          text: 'No se pudo eliminar!'
                      })
                    }
                }
            })

          }
      })
  });

});
