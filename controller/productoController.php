<?php 
require_once '../model/producto.php';

$producto = new producto();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])){

    $id = (int) $_POST['id'];
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $idcategoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if ($nombre && $precio && $idcategoria){

        $producto->actualizar($id, $nombre, $precio, $idcategoria);

        header("Location: ../view/listar-producto.php");
        exit;
    }

    echo "Error al actualizar";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $idcategoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

    if (!$idcategoria){
        echo "Debe Seleccionar una categoria";
        exit;
    }

    if ($nombre && $precio && $idcategoria){

        $producto = new producto();
        $producto->insertar($nombre, $precio, $idcategoria);

        echo "Producto Guardado";
        header("Location: ../view/listar-producto.php");
        exit;
    }
        
    echo "Error: datos invalidos";
    exit;
}



if(isset($_GET['eliminar'])){
    $id = (int) $_GET['eliminar'];

    $producto = new producto();
    $producto->eliminar($id);

    header("Location: ../view/listar-producto.php");
    exit;
}




?>