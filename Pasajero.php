<?php

require_once ('./BD/Basedatos.php');
require_once ('./models/PasajeroModel.php');
$dep = new PasajeroModel();

@header("Content-type: application/json");

// Consultar GET
// devuelve o 1 o todos, dependiendo si recibe o no parámetro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(isset($_GET['nombre'])) {
        $res = $dep->getNombres();
        echo json_encode($res);
        exit();
    } else if(isset($_GET['validar']) && isset($_GET['identificador'])  && isset($_GET['numasiento'])&& isset($_GET['clase'])&& isset($_GET['pvp'])) {
        $res = $dep->getvalidar($_GET['validar'], $_GET['identificador'],$_GET['numasiento'],$_GET["clase"],$_GET["pvp"]);
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

