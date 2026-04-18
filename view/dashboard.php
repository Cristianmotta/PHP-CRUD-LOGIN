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
    
    <style>
        body{
            background: linear-gradient(135deg, #0f2a75, #0f5953);
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

            <div class="col-md-4">
                <h5>Usuarios</h5>
                <a href="../controller/ListarUsuarioController.php" class="btn btn-primary">Ver Usuarios</a>
            </div>
        </div>

        <div class="container mt-5">
            <h3>Usuarios por mes</h3>
            <canvas id="miGrafica"></canvas>
        </div>
    </div>

    
    <?php
        $datos = [5, 10, 7, 12];
    ?>

  <script src="../public/js/chart.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function(){
        
        const ctx = document.getElementById('miGrafica').getContext('2d');

        let datos = <?= json_encode($datos) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
                datasets: [{
                    label: 'Usuarios Registrados',
                    backgroundColor: 'rgba(13, 109, 253, 0.89)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    data: datos,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    length: {
                        labels: {
                            color: '#000' 
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#000000'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.83)'
                        }
                    },
                    y: {
                        beginAtzero: true,
                        ticks: {
                            color: '#000000'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.82)'
                        }
                    }
                }
            }
        });
    });        
    </script>
</body>
</html>