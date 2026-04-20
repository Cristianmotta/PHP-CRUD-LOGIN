<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
$datos = [5, 10, 7, 12]; // Datos de ejemplo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistema Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --sidebar-color: #1e293b;
            --accent-gold: #c5a059;
            --text-pale: #94a3b8;
            --azul-claro: #38bdf8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: white;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-color);
            transition: all 0.3s;
            z-index: 1000;
            border-right: 1px solid rgba(197, 160, 89, 0.1);
        }

        #sidebar.active { margin-left: -250px; }

        .sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.05); }

        .nav-link {
            color: var(--text-pale);
            padding: 15px 25px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .nav-link i { font-size: 1.2rem; margin-right: 15px; }

        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(197, 160, 89, 0.1);
            border-left: 4px solid var(--accent-gold);
        }

        /* --- CONTENT AREA --- */
        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        #content.active {
            width: 100%;
            margin-left: 0;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* --- CARDS & CHARTS --- */
        .premium-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 20px;
        }

        /* Notificación Flotante */
        #welcomeToast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: var(--sidebar-color);
            border-left: 5px solid var(--accent-gold);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .btn-action {
            background: var(--sidebar-color);
            border: 1px solid var(--azul-claro);
            color: var(--azul-claro);
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-action:hover {
            background: var(--azul-claro);
            color: var(--bg-dark);
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; }
            #sidebar.active { margin-left: 0; }
            #content { width: 100%; margin-left: 0; }
            #content.active { margin-left: 250px; }
        }
    </style>
</head>
<body>

    <div id="welcomeToast">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle fs-3 me-3" style="color: var(--accent-gold);"></i>
            <div>
                <small class="text-muted d-block">Sesión iniciada</small>
                <strong>Bienvenido, <?= $_SESSION['nombre'] ?></strong>
            </div>
        </div>
    </div>

    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold mb-0" style="color: var(--accent-gold);">PLUS<span class="text-white">SYS</span></h4>
        </div>
        <div class="mt-4">
            <a href="#" class="nav-link active"><i class="bi bi-house-door"></i> Inicio</a>
            <a href="../controller/ListarUsuarioController.php" class="nav-link"><i class="bi bi-people"></i> Usuarios</a>
            <a href="../view/crear-categoria.php" class="nav-link"><i class="bi bi-tag"></i> Categorías</a>
            <a href="../view/listar-producto.php" class="nav-link"><i class="bi bi-box-seam"></i> Productos</a>
            <hr class="mx-3" style="opacity: 0.1;">
            <a href="../controller/LogoutController.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left"></i> Salir</a>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg px-4 py-3">
            <button type="button" id="sidebarCollapse" class="btn btn-link text-white p-0">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 d-none d-md-inline text-pale"><?= $_SESSION['nombre'] ?></span>
                <div class="rounded-circle bg-secondary" style="width: 35px; height: 35px; border: 2px solid var(--accent-gold);"></div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="premium-card shadow">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0"><i class="bi bi-graph-up-arrow me-2 text-info"></i> Usuarios por Mes</h5>
                            <span class="badge rounded-pill" style="background: rgba(56, 189, 248, 0.1); color: var(--azul-claro);">Actualizado</span>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="miGrafica"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card text-center border-0" style="background: linear-gradient(145deg, #1e293b, #0f172a);">
                        <i class="bi bi-people fs-1 d-block mb-3" style="color: var(--accent-gold);"></i>
                        <h6>Gestión de Usuarios</h6>
                        <a href="../controller/ListarUsuarioController.php" class="btn btn-action w-100 mt-2">Administrar</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <i class="bi bi-tags fs-1 d-block mb-3" style="color: var(--azul-claro);"></i>
                        <h6>Categorías</h6>
                        <a href="../view/crear-categoria.php" class="btn btn-action w-100 mt-2">Ver Todas</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <i class="bi bi-box-seam fs-1 d-block mb-3" style="color: var(--text-pale);"></i>
                        <h6>Inventario</h6>
                        <a href="../view/listar-producto.php" class="btn btn-action w-100 mt-2">Listado</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            // Toggle Sidebar
            const btnToggle = document.getElementById('sidebarCollapse');
            btnToggle.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('active');
                document.getElementById('content').classList.toggle('active');
            });

            // Auto-ocultar Bienvenido
            setTimeout(() => {
                const toast = document.getElementById('welcomeToast');
                toast.style.transition = "0.5s";
                toast.style.opacity = "0";
                toast.style.transform = "translateX(100px)";
                setTimeout(() => toast.remove(), 500);
            }, 5000);

            // Gráfica Profesional
            const ctx = document.getElementById('miGrafica').getContext('2d');
            new Chart(ctx, {
                type: 'line', // Cambiado a línea para más elegancia
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
                    datasets: [{
                        label: 'Usuarios Registrados',
                        borderColor: '#c5a059',
                        backgroundColor: 'rgba(197, 160, 89, 0.1)',
                        data: <?= json_encode($datos) ?>,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#94a3b8' } },
                        y: { 
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { color: '#94a3b8' }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>