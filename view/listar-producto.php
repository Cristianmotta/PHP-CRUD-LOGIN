<?php
require_once '../model/producto.php';
$productoModel = new producto();

$busqueda = $_GET['busqueda'] ?? '';
$precio = !empty($_GET['precio']) ? (float) $_GET['precio'] : null;

if ($busqueda || $precio !== null){
    $producto = $productoModel->buscar($busqueda, $precio);
} else {
    $producto = $productoModel->obtenerTodos();
}

$nombres = [];
$precios = [];
foreach ($producto as $p) {
    $nombres[] = $p['nombre'];
    $precios[] = $p['precio'];
}
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario | PlusSys</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --sidebar-color: #1e293b;
            --accent-gold: #c5a059;
            --text-main: #ffffff;
            --text-pale: #cbd5e1;
            --input-bg: #0f172a;
            --row-hover: rgba(197, 160, 89, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        #sidebar {
            width: 250px; height: 100vh; position: fixed;
            background: var(--sidebar-color); transition: 0.3s; z-index: 1000;
            border-right: 1px solid rgba(197, 160, 89, 0.1);
        }
        #sidebar.active { margin-left: -250px; }
        .nav-link { color: var(--text-pale); padding: 15px 25px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(197, 160, 89, 0.1); border-left: 4px solid var(--accent-gold); }
        .nav-link i { margin-right: 15px; font-size: 1.2rem; }

        /* --- CONTENIDO --- */
        #content { width: calc(100% - 250px); margin-left: 250px; transition: 0.3s; min-height: 100vh; }
        #content.active { width: 100%; margin-left: 0; }

        .admin-card {
            background: var(--sidebar-color); border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05); padding: 25px;
            margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        /* --- FORMULARIOS --- */
        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important; padding: 10px;
        }
        .form-control::placeholder { color: #94a3b8 !important; }

        /* --- TABLA OSCURA --- */
        .table { --bs-table-bg: transparent; --bs-table-color: var(--text-pale); }
        .table thead th {
            color: var(--accent-gold) !important; text-transform: uppercase;
            font-size: 0.75rem; letter-spacing: 1px;
            border-bottom: 2px solid var(--accent-gold) !important;
        }
        .table td { padding: 15px !important; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .table-hover tbody tr:hover td { background-color: var(--row-hover) !important; color: white !important; }

        .btn-gold { background: var(--accent-gold); color: var(--bg-dark); font-weight: 700; border: none; }
        .btn-gold:hover { background: #e2c275; }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; } #sidebar.active { margin-left: 0; }
            #content { width: 100%; margin-left: 0; }
        }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header p-4 text-center">
            <h4 class="fw-bold mb-0" style="color: var(--accent-gold);">PLUS<span class="text-white">SYS</span></h4>
        </div>
        <div class="mt-2">
            <a href="../view/dashboard.php" class="nav-link"><i class="bi bi-house-door"></i> Inicio</a>
            <a href="../controller/ListarUsuarioController.php" class="nav-link"><i class="bi bi-people"></i> Usuarios</a>
            <a href="../view/crear-categoria.php" class="nav-link"><i class="bi bi-tag"></i> Categorías</a>
            <a href="#" class="nav-link active"><i class="bi bi-box-seam"></i> Productos</a>
            <hr class="mx-3" style="opacity: 0.1;">
            <a href="../controller/LogoutController.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left"></i> Salir</a>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg px-4 py-3 border-bottom border-secondary">
            <button type="button" id="sidebarCollapse" class="btn btn-link text-white p-0">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <a href="../view/crear-producto.php" class="btn btn-gold btn-sm px-3">
                    <i class="bi bi-cart-plus me-1"></i> Nuevo Producto
                </a>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            <div class="admin-card">
                <h5 class="fw-bold mb-4 text-white"><i class="bi bi-bar-chart-line me-2 text-gold"></i> Comparativa de Precios</h5>
                <div style="height: 300px;">
                    <canvas id="graficaProductos"></canvas>
                </div>
            </div>

            <div class="admin-card py-3">
                <form method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="busqueda" class="form-control" placeholder="Nombre del producto..." value="<?= htmlspecialchars($busqueda) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"><i class="bi bi-currency-dollar"></i></span>
                            <input type="text" name="precio" class="form-control" placeholder="Precio exacto..." value="<?= htmlspecialchars($precio) ?>">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-gold w-100">Filtrar</button>
                        <a href="../view/listar-producto.php" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Categoría</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($producto)): ?>
                                <?php foreach ($producto as $p): ?>
                                    <tr>
                                        <td class="text-gold fw-bold">#<?= $p['id'] ?></td>
                                        <td class="text-white"><?= htmlspecialchars($p['nombre']) ?></td>
                                        <td><span class="badge bg-dark text-success border border-success">$<?= number_format($p['precio'], 2) ?></span></td>
                                        <td><i class="bi bi-tag small me-1"></i><?= htmlspecialchars($p['categorias']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="../view/editar-producto.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-info border-0"><i class="bi bi-pencil"></i></a>
                                                <button onclick="confirmarEliminar(<?= $p['id'] ?>)" class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-danger">No se encontraron productos con ese criterio.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="../view/dashboard.php" class="btn btn-sm btn-outline-danger">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });

            // Configuración de la Gráfica con colores "Dark"
            const ctx = document.getElementById('graficaProductos').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($nombres) ?>,
                    datasets: [{
                        label: 'Precio ($)',
                        data: <?= json_encode($precios) ?>,
                        backgroundColor: 'rgba(197, 160, 89, 0.6)',
                        borderColor: '#c5a059',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { labels: { color: '#94a3b8' } } 
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { color: '#94a3b8' }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#94a3b8' }
                        }
                    }
                }
            });
        });

        function confirmarEliminar(id) {
            Swal.fire({
                title: '¿Eliminar producto?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                background: '#1e293b',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../controller/productoController.php?eliminar=" + id;
                }
            });
        }
    </script>
</body>
</html>