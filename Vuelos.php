<?php
require_once ('./BD/Basedatos.php');
require_once ('./models/VuelosModel.php');
$dep = new VuelosModel();

@header("Content-type: application/json");

// Consultar GET
// devuelve o 1 o todos, dependiendo si recibe o no parámetro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $res = $dep->getUnVuelo($_GET['id']);
        echo json_encode($res);
        exit();
    } else {
        $res = $dep->getAll();
        echo json_encode($res);
        exit();
    }
}


// En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");


