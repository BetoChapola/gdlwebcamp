(function () {
    "use strict";

    var regalo = document.getElementById('regalo');

    document.addEventListener('DOMContentLoaded', function () {

        if ($(".registro").length > 0) {
// VARIABLES
        //datos usuario
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');
        //campos pases
        var pase_dia = document.getElementById('pase_dia');
        var pase_dos_dias = document.getElementById('pase_dos_dias');
        var pase_completo = document.getElementById('pase_completo');
        //botones y divs
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        var lista_productos = document.getElementById('lista_productos');
        var suma = document.getElementById('suma_total');
        //extras
        var camisa = document.getElementById('camisa_evento');
        var etiquetas = document.getElementById('etiquetas');

        botonRegistro.disabled = true; //el boton esta deshabilitado pero el css lo mantiene con los colores "habilitado". Necesario corregir

                // EVENTOS
                calcular.addEventListener('click', calcularMontos);

                pase_dia.addEventListener('change', mostrarDias);
                pase_dos_dias.addEventListener('change', mostrarDias);
                pase_completo.addEventListener('change', mostrarDias);
        
                nombre.addEventListener('blur', validarCampos);
                apellido.addEventListener('blur', validarCampos);
                email.addEventListener('blur', validarCampos);
                email.addEventListener('blur', validarMail);
        }
        



        // FUNCIONES
        function validarCampos() {
            if (this.value == '') {
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = "Este campo es obligatorio";
                this.style.border = '1px solid red';
                errorDiv.style.border = '1px solid red';
            } else {
                errorDiv.style.display = 'none';
                this.style.border = '1px solid #18bd00';
            }
        }

        function validarMail() {
            if (this.value.indexOf("@") > -1) {
                errorDiv.style.display = 'none';
                this.style.border = '1px solid #18bd00';
            } else {
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = "Este campo debe contener un mail valido";
                this.style.border = '1px solid red';
                errorDiv.style.border = '1px solid red';
            }
        }

        function calcularMontos(event) {
            event.preventDefault();

            if (regalo.value === '') {
                alert("Debes elegir un regalo");
                regalo.focus();
            } else {
                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletos2Dias = parseInt(pase_dos_dias.value, 10) || 0,
                    boletoCompleto = parseInt(pase_completo.value, 10) || 0,
                    cantidadCamisas = parseInt(camisa.value, 10) || 0,
                    cantidadEtiquetas = parseInt(etiquetas.value, 10) || 0;
                /*
                La función parseInt comprueba el primer argumento, una cadena, e intenta devolver un entero de la base especificada. Por ejemplo, una base de 10 indica una conversión a número decimal, 8 octal, 16 hexadecimal, y así sucesivamente.
                https://developer.mozilla.org/es/docs/Web/JavaScript/Referencia/Objetos_globales/parseInt
                
                || 0
                Convierte un NaN en el valor que asignemos, ejemplos:
                || 0
                || "Hola, no soy un número"
                */
                var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletoCompleto * 50) + ((cantidadCamisas * 10) * .93) + (cantidadEtiquetas * 2);

                var listadoProductos = new Array();

                if (boletosDia >= 1) {
                    listadoProductos.push(`${boletosDia} Pases por día`);
                }
                if (boletos2Dias >= 1) {
                    listadoProductos.push(`${boletos2Dias} Pases por 2 días`);
                }
                if (boletoCompleto >= 1) {
                    listadoProductos.push(`${boletoCompleto} Pases completos`);
                }
                if (cantidadCamisas >= 1) {
                    listadoProductos.push(`${cantidadCamisas} Camisas`);
                }
                if (cantidadEtiquetas >= 1) {
                    listadoProductos.push(`${cantidadEtiquetas} Etiquetas`);
                }

                lista_productos.style.display = "block";
                lista_productos.innerHTML = '';
                for (var i = 0; i < listadoProductos.length; i++) {
                    lista_productos.innerHTML += listadoProductos[i] + '<br/>';
                }

                suma.innerHTML = "$ " + totalPagar.toFixed(2);

                botonRegistro.disabled = false;
                document.getElementById('total_pedido').value = totalPagar;
            }


        }

        function mostrarDias() {
            var boletosDia = parseInt(pase_dia.value, 10) || 0;
            var boletos2Dias = parseInt(pase_dos_dias.value, 10) || 0;
            var boletoCompleto = parseInt(pase_completo.value, 10) || 0;
            var diasElegidos = [];


            // ! Se debe estudiar la manera de manipular los contenidos de los array.
            // ! Cómo eliminar, insertar.
            // ! tengo un error cuando se muestran o se esconden los dias elegidos.
            if (boletosDia > 0) {
                diasElegidos.push('viernes');
                console.log(diasElegidos);
            }
            if (boletos2Dias > 0) {
                diasElegidos.push('viernes', 'sabado');
                console.log(diasElegidos);
            }
            if (boletoCompleto > 0) {
                diasElegidos.push('viernes', 'sabado', 'domingo');
                console.log(diasElegidos);
            }


            for (var i = 0; i < diasElegidos.length; i++) {
                document.getElementById(diasElegidos[i]).style.display = 'block';
            }

            // los oculta si vuelven a 0
            if (diasElegidos.length == 0) {
                var todosDias = document.getElementsByClassName('contenido-dia');
                for (var i = 0; i < todosDias.length; i++) {
                    todosDias[i].style.display = 'none';
                }
            }
        }
    });
})();