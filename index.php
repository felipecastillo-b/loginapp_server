<?php
require_once 'DBOperation.php';

$response = array();

if (empty($_POST['email']) || empty($_POST['password'])) {
    $response['error'] = true;
    $response['message'] = 'Required parameters are missing';
} else {
    $db = new DBOperation();
    if ($db->loginUser($_POST['email'], $_POST['password'])) {
        $response['error'] = false;
        $response['message'] = 'Login successful';
    } else {
        $response['error'] = true;
        $response['message'] = 'Invalid email or password';
    }
}

// Solo imprime la respuesta JSON si el contenido es un array
if (!empty($response)) {
    echo json_encode($response);
}
?>
