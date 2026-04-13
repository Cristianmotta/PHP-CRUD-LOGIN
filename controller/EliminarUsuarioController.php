<?php 
declare(strict_types=1);

require_once __DIR__ . '/../model/usuario.php';

$id = (int) $_GET['id'] ?? null;

$usuario = new usuario();

if ($usuario->eliminar($id)){
    header("Location: ListarUsuarioController.php?eliminado=1");
    exit;
} else {
    echo "Error al eliminar";
}


?>