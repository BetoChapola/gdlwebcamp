<?php

// *** NOTA***
// Para que una redirección PHP pueda funcionar NO DEBE HABER ningún código antes.
// Recuerda que la definición de la función no la ejecuta. Una función se ejecuta cuando es llamada: función();

function usuario_autenticado(){
    if (!revisar_usuario()) {
        header('Location:login.php');
        exit();

        // Este bloque puede ser un poco confuso porque pareciera una doble negación dando como resultado un positivo.
        // Pero no es así. Si usáramos la función así: if (revisar_usuario()) {} (sin el operador de negación "!")
        // el retorno de revisar_usuario() = true, la función se ejecutará. Eso implicaría que si el usuario esta logueado
        // correctamente sería redireccionado al login.php. Pero nosotros no queremos que eso suceda. 
        // Queremos que suceda cuando el usuario NO ESTE AUTENTICADO
        // (no exista o que intente entrar a un sitio solo para usuarios logueados.)
        // La manera correcta de leer esta expresión if (!revisar_usuario()) {} es:
        // si (NO es TRUE){}

    }
}

function revisar_usuario(){
    // Revisa que el usuario este en la BD.
    // retorna "true" si se encuentra la variable $_SESSION['usuario']. Quiere decir que la sesión se inicio.
    // retorna "false" si no se encuentra la variable.
    return isset($_SESSION['usuario']);
    
}


// Iniciamos la sesión con los valores que se le asignaron desde insertar_admin.php al momento del login:
// session_start();
// $_SESSION['usuario'] = $usuario_admin;
// $_SESSION['nombre'] = $nombre_admin;
session_start();

// Llamamos a la función usuario_autenticado() que a su vez llama a la función revisar_usuario()
// para verificar que exista la variable $_SESSION['usuario']
usuario_autenticado();


