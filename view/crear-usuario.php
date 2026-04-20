<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario | Panel Administrativo</title>
    
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
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }

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

       
        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }
        #content.active { width: 100%; margin-left: 0; }

        
        .admin-card {
            background: var(--sidebar-color);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            max-width: 700px;
            margin: 20px auto;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .form-label {
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: var(--bg-dark);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
            padding: 12px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.1);
        }

       
        .form-control::placeholder {
            color: #94a3b8 !important; 
            opacity: 1;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        .btn-save {
            background: var(--accent-gold);
            color: var(--bg-dark);
            border: none;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .btn-save:hover {
            background: #e2c275;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: transparent;
            color: var(--text-pale);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 30px;
            border-radius: 10px;
        }
        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; }
            #sidebar.active { margin-left: 0; }
            #content { width: 100%; margin-left: 0; }
            .admin-card { padding: 25px; }
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
            <a href="../controller/ListarUsuarioController.php" class="nav-link active"><i class="bi bi-people"></i> Usuarios</a>
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
            <div class="ms-auto">
                <span class="text-pale small">Panel de Administración > Usuarios > <strong>Nuevo</strong></span>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            <div class="admin-card">
                <div class="mb-4">
                    <h2 class="fw-bold"><i class="bi bi-person-plus me-2" style="color: var(--accent-gold);"></i> Registro de Operador</h2>
                    <p class="text small">Complete los datos para dar de alta un nuevo usuario en el sistema.</p>
                </div>

                <form action="../controller/Usuariocontroller.php" method="POST">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej: Carlos Sánchez" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo Institucional</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="correo" class="form-control" placeholder="usuario@sistema.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contraseña Temporal</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" name="fech_nac" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button class="btn btn-save shadow-sm" type="submit">
                            <i class="bi bi-check-lg me-1"></i> Guardar Usuario
                        </button>
                        <a href="../controller/ListarUsuarioController.php" class="btn btn-cancel">
                            Cancelar
                        </a>
                    </div>

                </form> 
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Sidebar Toggle funcional
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>
</body>
</html>