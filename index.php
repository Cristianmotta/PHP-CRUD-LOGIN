<?php
require_once 'config/conexion.php';

try{
    $db = conexion::getInstance()->getConexion();
    echo "conexion existosa";
} catch (Exception $e){
    echo "Error:  ".$e->getMessage();
}

?>