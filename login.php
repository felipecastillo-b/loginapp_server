<?php
// Incluye el archivo DBOperation.php ya que este contiene los metodos
require_once 'DBOperation.php';

$response = array(); // Aqui se guardaran en un array las respuestas

if (empty($_POST['email']) || empty($_POST['password'])) { // comprueba si los campos estan vacios
    $response['error'] = true;
    $response['message'] = 'Required parameters are missing';
} else { // en caso de que los campos si se esten completos, pasan a este else
    $db = new DBOperation(); // Crea una instancia de la clase DBOperation, lo que permite acceder a sus metodos
    // LLama al metodo "loginUser" pasando los valores de email y password
    $result = $db->loginUser($_POST['email'], $_POST['password']);
    if ($result['error'] == false) { // comprueba si la operacion fue exitosa o tuvo algun error
        $response['error'] = false;
        $response['message'] = 'Login successful';
    } else {
        $response['error'] = true;
        $response['message'] = $result['message'];
    }
}

// Convierte la respuesta a una cadena JSON
echo json_encode($response);
?>