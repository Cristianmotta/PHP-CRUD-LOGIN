<?php 
require_once '../model/categoria.php';

$categoria = new categoria();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])){

    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    var_dump($nombre);

    if ($nombre){
        $categoria->insertar($nombre);
    }

    header("Location: ../view/crear-categoria.php");
    exit;
}

if(isset($_GET['eliminar'])){
    $id = (int) $_GET['eliminar'];

    try{
        $categoria->eliminar($id);

        header("Location: ../view/crear-categoria.php?sucess=1");
        exit;
    } catch (PDOException $e) {

        header("Location: ../view/crear-categoria.php?error=1");
        exit;
    }
}



?>