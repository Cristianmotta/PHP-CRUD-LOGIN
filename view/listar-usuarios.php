<?php
// Mantenemos tu lógica de seguridad
if (!isset($usuarios)) {
    die("Acceso no permitido");
}
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | PlusSys</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --sidebar-color: #1e293b;
            --accent-gold: #c5a059;
            --text-pale: #94a3b8;
            --azul-claro: #38bdf8;
            --row-hover: rgba(56, 189, 248, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: #e2e8f0;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR (Consistente con Dashboard) --- */
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
        .nav-link { color: var(--text-pale); padding: 15px 25px; display: flex; align-items: center; transition: 0.3s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(197, 160, 89, 0.1); border-left: 4px solid var(--accent-gold); }
        .nav-link i { margin-right: 15px; font-size: 1.2rem; }

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

        /* --- CORRECCIÓN DE TABLA OSCURA --- */
        .premium-card {
            background: rgba(30, 41, 59, 0.5); /* Un tono ligeramente más claro que el fondo general */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(197, 160, 89, 0.1);
            border-radius: 20px;
            padding: 25px;
        }

        .table {
            --bs-table-bg: transparent; /* Eliminamos el fondo blanco */
            --bs-table-color: #e2e8f0;   /* Texto blanco/gris claro */
            --bs-table-border-color: rgba(255, 255, 255, 0.05);
            margin-bottom: 0;
        }

        /* Forzar que las celdas no tengan fondo blanco */
        .table td, .table th {
            background: transparent !important;
            color: #cbd5e1 !important; /* Gris suave para que no canse la vista */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* Estilo para las filas impares (striped) en modo oscuro */
        .table-striped>tbody>tr:nth-of-type(odd)>* {
            background-color: rgba(255, 255, 255, 0.02) !important;
            box-shadow: inset 0 0 0 9999px rgba(255, 255, 255, 0.02);
        }

        /* Efecto hover elegante */
        .table-hover>tbody>tr:hover>* {
            background-color: rgba(56, 189, 248, 0.05) !important; /* Un toque de azul claro al pasar el mouse */
            color: #ffffff !important; /* El texto se vuelve blanco puro al resaltar */
        }

        /* Ajuste de los iconos dentro de la tabla */
        .bi-calendar3, .bi-person {
            color: var(--accent-gold);
        }

        /* Color de los inputs de búsqueda de DataTable */
        .dataTables_filter input, .dataTables_length select {
            background-color: rgba(15, 23, 42, 0.5) !important;
            border: 1px solid rgba(148, 163, 184, 0.2) !important;
            color: white !important;
        }
        /* Estilos DataTables */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-pale) !important;
            margin-top: 15px;
        }

        .form-select, .form-control-sm {
            background-color: var(--sidebar-color) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
        }

        /* Botones */
        .btn-gold-outline {
            border: 1px solid var(--accent-gold);
            color: var(--accent-gold);
            transition: 0.3s;
        }
        .btn-gold-outline:hover {
            background: var(--accent-gold);
            color: var(--bg-dark);
        }

        .page-link {
            background-color: var(--sidebar-color) !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: var(--text-pale) !important;
        }
        .page-item.active .page-link {
            background-color: var(--accent-gold) !important;
            border-color: var(--accent-gold) !important;
            color: var(--bg-dark) !important;
        }

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
            <a href="#" class="nav-link active"><i class="bi bi-people"></i> Usuarios</a>
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
                <span class="me-3 d-none d-md-inline text-pale"><?= $_SESSION['nombre'] ?? 'Usuario' ?></span>
                <div class="rounded-circle bg-secondary" style="width: 35px; height: 35px; border: 2px solid var(--accent-gold);"></div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold m-0">Gestión de <span style="color: var(--accent-gold);">Usuarios</span></h2>
                    <p class="text small m-0">Visualiza y administra los accesos al sistema</p>
                </div>
                <a href="../view/crear-usuario.php" class="btn btn-gold-outline px-4 shadow-sm">
                    <i class="bi bi-person-plus-fill me-2"></i> Nuevo Usuario
                </a>
            </div>

            <div class="premium-card shadow-lg">
                <div class="table-responsive">
                    <table id="tablaUsuarios" class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-gold">ID</th>
                                <th class="text-gold">NOMBRE</th>
                                <th class="text-gold">CORREO ELECTRÓNICO</th>
                                <th class="text-gold">NACIMIENTO</th>
                                <th class="text-center text-gold">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                                <tr id="fila-<?= $u['id'] ?>">
                                    <td class="fw-bold text-pale">#<?= $u['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center me-3" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                                            </div>
                                            <?= htmlspecialchars($u['nombre']) ?>
                                        </div>
                                    </td>
                                    <td class="text-pale"><?= htmlspecialchars($u['correo']) ?></td>
                                    <td><i class="bi bi-calendar3 me-2 small opacity-50"></i><?= $u['fech_nac'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="../controller/EditarUsuarioController.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-info" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button onclick="confirmarEliminar(<?= $u['id'] ?>)" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Sidebar Toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });

            // DataTables Personalizado
            $('#tablaUsuarios').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                pageLength: 10,
                responsive: true,
                dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>'
            });
        });

        function confirmarEliminar(id) {
            Swal.fire({
                title: '¿Eliminar usuario?',
                text: "Esta acción no se puede deshacer",
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
                    window.location.href = "../controller/EliminarUsuarioController.php?id=" + id;
                }
            });
        }
    </script>

    <?php if (isset($_GET['eliminado'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Logrado!',
                text: 'Usuario eliminado correctamente',
                background: '#1e293b',
                color: '#fff',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>
</html>