<?php 

require_once '../config/conexion.php';

session_start();

/*Validar sesiones */

if(
    !isset($_SESSION['correo_recuperacion']) ||
    !isset($_SESSION['pin_verificacion'])
){

    header("Location: ../view/login.php");
}

/* Obtener Datos */

$password = trim($_POST['password'] ?? '');
$confirmar = $_POST['confirmar'] ?? '';

$correo = $_SESSION['correo_recuperacion'];

/* Validar contraseñas */

if($password !== $confirmar){

    die("Las contraseñas no coinciden");

}


/* Validar seguridad */

if(
    strlen(trim($password)) < 8 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[0-9]/', $password)
){
    header("Location: ../view/nueva-contraseña.php?error=password");
    exit;
}

/* Encriptar Password */
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$db = conexion::getInstance()->getConexion();

/* Actualizar password */

$sql = "UPDATE usuario
        SET password = :password,
        
            pin_recuperacion = NULL,
            pin_expiracion = NULL

        WHERE correo = :correo";

$stmt = $db->prepare($sql);

$stmt->execute([
    ':password' => $passwordHash,
    ':correo' => $correo
]);

$_SESSION['pin_verificacion'] = true;

unset($_SESSION['correo_recuperacion']);
unset($_SESSION['pin_verificacion']);

/* Redireccion */

header("Location: ../view/login.php?password=actualizada");
exit;


?>