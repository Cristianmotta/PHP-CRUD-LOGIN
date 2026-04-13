<?php
declare(strict_types=1);

require_once __DIR__. "/../model/usuario.php";

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $usuarioModel = new usuario();
    $usuario = $usuarioModel->obtenerPorCorreo($correo);

    if ($usuario && password_verify($password, $usuario['password'])){

        session_regenerate_id(true);

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];

        header("Location: ../view/dashboard.php");
        exit;
    } else {
        echo "Correo o Contraseña incorrectos";
    }
}

?>