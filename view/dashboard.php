<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            background: linear-gradient(135deg, #1D4ed8, #0d9488);
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .card{
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand">Mi Sistema</span>
            <a href="../controller/LogoutController.php" class="btn btn-danger btn-sm">Cerrar sesion</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="alert alert-success">
            <h2>Bienvenid@ <strong><?= $_SESSION['nombre'] ?></strong></h2>
        </div>

        <div class="row">

            <div class="col-md 4">
                <h5>Usuarios</h5>
                <a href="../controller/ListarUsuarioController.php" class="btn btn-primary">Ver Usuarios</a>
            </div>
        </div>
    </div>
    
</body>
</html>