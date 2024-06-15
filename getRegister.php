<?php
    require_once 'DBOperation.php';

    $dbOperation = new DBOperation();

    // Obtener registros
    $registros = $dbOperation->getRegister();

    // Comprobar si hay registros
    if ($registros) {
        // Enviar respuesta JSON con los registros
        echo json_encode(array('error' => false, 'registros' => $registros));
    } else {
        // Enviar respuesta JSON indicando que no hay registros
        echo json_encode(array('error' => true, 'message' => 'No se encontraron registros'));
    }
?>