<?php
require_once '../config/database.php';
require_once 'FuncionesCliente.php';

$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'existeUsuario') {
        $db = new Database();
        $con = $db->conectar();
        $datos['ok'] = usuarioExiste($_POST['usuario'], $con);
    }
}

echo json_encode($datos);