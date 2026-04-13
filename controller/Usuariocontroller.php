<?php
declare(strict_types=1);

require_once __DIR__. '/../model/usuario.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $fechNac = $_POST['fech_nac'] ?? '';

    if(!$nombre || !$correo || empty($password) || empty($fechNac)){
        echo "Datos Invalidos";
        exit;
    }
    
    $usuario = new Usuario();

    if ($usuario->insertar($nombre, $correo, $password, $fechNac)){
        echo "Usuario creado correctamente";
        header("Location: ../view/editar-usuario.php");
    } else{
        echo "Error al crear usuario";
    }

}


?>