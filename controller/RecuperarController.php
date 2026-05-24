<?php 

require_once '../config/conexion.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);

if(!$correo){
    die("Correo invalido");
}

$db = conexion::getInstance()->getConexion();

/* Validar si Existe el correo */

$sql = "SELECT * FROM usuario 
        WHERE correo = :correo";

$stmt = $db->prepare($sql);

$stmt->execute([
    ':correo' => $correo
]);

$usuario = $stmt->fetch();

if(!$usuario){
    die("No existe una cuenta con ese correo");
}

/* Generar Pin */
$pin = rand(100000, 999999);
/* Tiempo de expiracion */
$expira = time() + 60;

/* Guardar pin */

$sql = "UPDATE usuario 
        SET pin_recuperacion = :pin,
            pin_expiracion = :expira
        WHERE correo = :correo";

$stmt = $db->prepare($sql);

$stmt->execute([
    ':pin' => $pin,
    ':expira' => $expira,
    ':correo' => $correo
]);

/* Enviar correo */

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    /* Correo Relacionado */
    $mail->Username = 'streepsoftcolombia@gmail.com';

    /*Contraseña de aplicacion */
    $mail->Password = 'fthowdgizpgjmobl';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom('streepsoftcolombia@gmail.com', 'streepsoft');
    
    $mail->Port = 587;
    $mail->Timeout = 5;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->addAddress($correo);
    $mail->isHTML(true);
    $mail->Subject = 'Recuperacion de contraseña';
    

    /* Correo HTML */

   $mail->Body = "
        <div style='
            padding:20px;
            font-family:Arial;
            background:#f5f5f5;
            border-radius:10px;
        '>

            <h2 style='color:#d8651d;'>
                Recuperación de contraseña
            </h2>

            <p>Tu PIN de seguridad es:</p>

            <h1 style='
                text-align:center;
                color:#94920d;
                letter-spacing:5px;
            '>
                $pin
            </h1>

            <p>
                Este PIN expirará en 1 minutos
            </p>

        </div>
    ";

    $mail->send();

    /*Guardar sesion*/

    $_SESSION['correo_recuperacion'] = $correo;


    header("Location: ../view/verificar-pin.php");
    exit();

} catch (Exception $e){
    echo "Error al enviar correo: {$mail->ErrorInfo}";
}

?>