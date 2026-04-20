<?php
declare(strict_types=1);

require_once __DIR__. '/../model/usuario.php';

$usuario = new Usuario();


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id = (int) $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $fechNac= $_POST['fech_nac'] ?? null;

    if($id === null || $nombre === null || $correo === null || $fechNac === null){
        die("Datos incompletos");
    }

    $usuario->actualizar((int)$id, $nombre, $correo, $fechNac);
    header("Location: ListarUsuarioController.php");
    exit;

} 

$id = (int) $_GET['id'] ?? null;

if(!$id){
    die("ID no proporcionado");
}

$data = $usuario->obtenerPorId($id);

require_once __DIR__ . '/../view/editar-usuario.php';



?>