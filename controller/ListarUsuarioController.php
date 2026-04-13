<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once __DIR__. '/../model/usuario.php';

$usuario = new Usuario();
$usuarios = $usuario->obtenerTodos();


// enviar los datos a la vista
require_once __DIR__. '/../view/listar-usuarios.php';

?>