<?php
declare(strict_types=1);

require_once __DIR__. '/../model/usuario.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $fechNac = $_POST['fech_nac'] ?? '';

    try {
        $usuario = new usuario();
        $usuario->insertar($nombre, $correo, $password, $fechNac);

        header("Location: ../view/login.php?registro=1");
        exit;

    } catch (PDOException $e) {

        header("Location: ../view/registrar.php?error=1");
        exit;
    }

}


?>