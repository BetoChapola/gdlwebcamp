$(document).ready(function () {
  $('.sidebar-menu').tree()


  // Controles de la tabla
  // https://datatables.net/reference/option/language  
  $('#registros').DataTable({
    'paging': true,
    'pageLength': 10,
    'lengthChange': false,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
    'language': {
        paginate:{
            next: 'Siguiente',
            previous: 'Anterior',
            last: 'Último',
            first: 'Primero'
        },
        info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',
        emptyTable: 'No hay registros',
        infoEmpty: '0 Registros',
        search: 'Buscar'

    }
  });


  $('#crear_registro_admin').attr('disabled', true);
  $('#repetir_password').on('input', function () { //o puede ser on 'blur'
    var password_nuevo = $('#password').val();

    // $(this), hace referencia al selector principal: $('#repetir_password')
    if ($(this).val() == password_nuevo) {
      $('#resultado_password').text('Correcto');
      $('#resultado_password').parents('.form-group').addClass('has-success').removeClass('has-error');
      $('input#password').parents('.form-group').addClass('has-success').removeClass('has-error');
      $('#crear_registro_admin').attr('disabled', false);
    }else{
      $('#resultado_password').text('Incorrecto');
      $('#resultado_password').parents('.form-group').addClass('has-error').removeClass('has-success');
      $('input#password').parents('.form-group').addClass('has-error').removeClass('has-success');
    }
  });


  //Date picker
  $('#fecha_evento').datepicker({
    autoclose: true
  })

  //Initialize Select2 Elements
  $('.seleccionar').select2();

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  // Icon Picker
  $('#icono').iconpicker();

  //Flat red color scheme for iCheck
  $('input[type="checkbox"].minimal, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass   : 'iradio_flat-blue'
  })
})
