<?php

require_once '../config/conexion.php';

session_start();

/* Validar sesion */

if(!isset($_SESSION['correo_recuperacion'])){
    header("Location: ../view/login.php");
    exit;
}

/* Obtener datos */

$pin = filter_input(INPUT_POST, 'pin', FILTER_SANITIZE_SPECIAL_CHARS);
$correo = $_SESSION['correo_recuperacion'];
$db = conexion::getInstance()->getConexion();

/*Buscar usuario*/
$sql = "SELECT * FROM usuario
        WHERE correo = :correo
        AND pin_recuperacion = :pin";

$stmt = $db->prepare($sql);

$stmt->execute([
    ':correo' => $correo,
    ':pin'=> $pin
]);

$usuario = $stmt->fetch();

/* Validar Pin */

if(!$usuario){
    header("Location: ../view/verificar-pin.php?error=incorrecto");
    exit;
}

/* validar expiracion */
if(time() > $usuario['pin_expiracion']){
    header("Location: ../view/verificar-pin.php?error=expirado");
    exit;
}

/* Pin correcto */

$_SESSION['pin_verificacion'] = true;

header("Location: ../view/nueva-contraseña.php?success=pin");
exit;


?>