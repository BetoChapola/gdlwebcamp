<?php

function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0)
{
    // https://www.php.net/manual/es/language.references.pass.php

    $dias = array(
        0 => 'un dia',
        1 => 'pase_completo',
        2 => 'pase_2dias'
    );

    //Vamos a combinar el nuevo array() $dias que creamos con el array de boletos
    // https://www.php.net/manual/es/function.array-combine.php
    $total_boletos = array_combine($dias, $boletos);

    /**la función crea un array combinado:
     * $total_boletos = {
     *  'llave' => 'valor'
     *  .....
     *  'llaveN' => 'valorN'
     * }
     * $total_boletos = {
     *  'un_dia' => 'valor', 
     *  'pase_completo => 'valor', 
     *  'pase_2dias' => 'valor')
     * }
     */

    //1) Creamos un array vacío.
    $json = array();

    foreach ($total_boletos as $key => $boletos) :
        /**Aqui vamos a crear la estructura del json.
         * $total_boletos as $key (un dia, pase_completo o pase_2dias) => $boletos (cantidad de boletos).
         * $total_boletos ya es un array combinado, pero esta "vacío". Solo es la estructura asociativa de
         * 2 arrays combinados previamente. Ahora lo reescribiremos con la cantidad de boletos seleccionados,
         * en un nuevo array: $json[];
         */
        if ((int) $boletos > 0) : //Convertimos $boletos a int porque originalmente era un string
            //Queremos que se guarde en la llave actual $json[$key] el valor convertido a int = (int) $boletos;
            $json[$key] = (int) $boletos;
        endif;
    endforeach;

    // Agragamos los extras al array json();
    $camisas = (int) $camisas;
    if ($camisas > 0) {
        $json['camisas'] = $camisas;
    }
    $etiquetas = (int) $etiquetas;
    if ($etiquetas > 0) {
        $json['etiquetas'] = $etiquetas;
    }
    return json_encode($json);
}

function eventos_json(&$eventos){
    $eventos_json = array();

    foreach($eventos as $evento) :
        $eventos_json ['eventos'][] = $evento;
    endforeach;

    return json_encode($eventos_json);
}
