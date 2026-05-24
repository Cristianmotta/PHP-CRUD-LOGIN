<?php
require_once 'config/conexion.php';

try{
    $db = conexion::getInstance()->getConexion();
    header("Location: /PHP-CRUD-LOGIN/view/login.php");
} catch (Exception $e){
    echo "Error:  ".$e->getMessage();
}

?>