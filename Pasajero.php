<?php

require_once ('./BD/Basedatos.php');
require_once ('./models/PasajeroModel.php');
$dep = new PasajeroModel();

@header("Content-type: application/json");

// Consultar GET
// devuelve o 1 o todos, dependiendo si recibe o no parámetro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['nombre'])) {
        $res = $dep->getNombres();
        echo json_encode($res);
        exit();
    } else if (isset($_GET['validar']) && isset($_GET['identificador'])) {
        $res = $dep->getvalidarnombre($_GET['validar'], $_GET['identificador']);
        echo $res;
        exit();
    } else if (isset($_GET['validarasiento']) && isset($_GET['identificador'])) {
        $res = $dep->getvalidarasiento($_GET['validarasiento'], $_GET['identificador']);
        echo $res;
        exit();
    } else {
        $res = $dep->getAll();
        echo json_encode($res);
        exit();
    }
}




// En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

