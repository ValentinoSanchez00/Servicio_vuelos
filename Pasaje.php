<?php

require_once ('./BD/Basedatos.php');
require_once ('./models/PasajeModel.php');
$dep = new PasajeModel();

@header("Content-type: application/json");

// Consultar GET
// devuelve o 1 o todos, dependiendo si recibe o no parámetro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['identificadores'])) {
        $res = $dep->getPasjeIdentificadores();
        echo json_encode($res);
        exit();
    } else {
        $res = $dep->getAll();
        echo json_encode($res);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if (isset($_GET['id'])) {
        $res = $dep->deletebyId($_GET["id"]);
        echo json_encode($res);
        exit();
    }
}
// Crear un nuevo reg POST
// Los campos del array que venga se deberán llamar como los campos de la tabla Departamentos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // se cargan toda la entrada que venga en php://input
    $post = json_decode(file_get_contents('php://input'), true);
    $res = $dep->postvalidar($post);
    $resul['resultado'] = $res;
    echo json_encode($resul);
    exit();
}


// En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

