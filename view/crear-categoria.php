<?php
require_once '../model/categoria.php';
$categoriaModel = new categoria();
$categoria = $categoriaModel->obtenerTodas();
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías | Panel Administrativo</title>
    
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
            width: 250px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-color);
            transition: all 0.3s;
            z-index: 1000;
            border-right: 1px solid rgba(197, 160, 89, 0.1);
        }
        #sidebar.active { margin-left: -250px; }
        .nav-link { color: var(--text-pale); padding: 15px 25px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(197, 160, 89, 0.1); border-left: 4px solid var(--accent-gold); }
        .nav-link i { margin-right: 15px; font-size: 1.2rem; color: white; }

        /* --- CONTENIDO --- */
        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }
        #content.active { width: 100%; margin-left: 0; }

        .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* --- TARJETAS TIPO PANEL --- */
        .admin-card {
            background: var(--sidebar-color);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .form-control {
            background-color: var(--bg-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
            padding: 12px;
        }

        .form-control::placeholder {
            color: #94a3b8 !important; /* Placeholder visible */
        }

        /* --- TABLA OSCURA (Sin rastro de blanco) --- */
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-pale);
            --bs-table-border-color: rgba(255, 255, 255, 0.05);
        }

        .table thead th {
            color: var(--accent-gold) !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--accent-gold) !important;
            background: transparent !important;
        }

        .table td {
            background: transparent !important;
            color: var(--text-pale) !important;
            padding: 15px !important;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover td {
            background-color: var(--row-hover) !important;
            color: white !important;
        }

        .btn-gold {
            background: var(--accent-gold);
            color: var(--bg-dark);
            font-weight: 700;
            border: none;
            padding: 10px 25px;
        }

        .btn-gold:hover { background: #e2c275; transform: translateY(-1px); }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; }
            #sidebar.active { margin-left: 0; }
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
            <a href="#" class="nav-link active"><i class="bi bi-tag"></i> Categorías</a>
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
            <div class="ms-auto">
                <span class="text-pale small">Inventario > <strong>Categorías</strong></span>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            <div class="admin-card">
                <h3 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2" style="color: var(--accent-gold);"></i> Nueva Categoría</h3>
                <form method="POST" action="../controller/CategoriaController.php">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label class="form-label text-pale">Nombre de la Categoría</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Electrónica, Ropa, Hogar..." required>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-gold w-100"><i class="bi bi-save me-2"></i>Guardar Categoría</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h3 class="fw-bold mb-4"><i class="bi bi-list-ul me-2" style="color: var(--accent-gold);"></i> Categorías Existentes</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th>Nombre</th>
                                <th width="15%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categoria as $c): ?>
                            <tr>
                                <td class="fw-bold text-white">#<?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['nombre']) ?></td>
                                <td class="text-center">
                                    <button onclick="confirmarEliminar(<?= $c['id'] ?>)" class="btn btn-outline-danger btn-sm border-0">
                                        <i class="bi bi-trash3 fs-5"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });

        function confirmarEliminar(id){
            Swal.fire({
                title: '¿Eliminar categoría?',
                text: "Esta acción verificará si hay productos asociados.",
                icon: 'warning',
                background: '#1e293b',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed){
                    window.location.href = "../controller/CategoriaController.php?eliminar=" + id;
                }
            });
        }
    </script>

    <?php if (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                title: 'No se puede eliminar',
                text: 'Esta categoría tiene productos relacionados.',
                icon: 'error',
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#c5a059'
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                title: 'Operación Exitosa',
                icon: 'success',
                background: '#1e293b',
                color: '#fff',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>
</html>