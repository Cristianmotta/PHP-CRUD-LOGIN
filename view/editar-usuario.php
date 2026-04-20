<?php
// Asumiendo que $data viene del controlador con la info del usuario
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= htmlspecialchars($data['nombre']) ?> | PlusSys</title>
    
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
            --edit-cyan: #22d3ee;
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

        #content { width: calc(100% - 250px); margin-left: 250px; transition: 0.3s; min-height: 100vh; }
        #content.active { width: 100%; margin-left: 0; }

        /* --- EDIT CARD --- */
        .admin-panel-card {
            background: var(--sidebar-color);
            border-radius: 24px;
            border: 1px solid rgba(34, 211, 238, 0.2);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-floating > .form-control {
            background-color: var(--bg-dark) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
        }

        .form-floating > label { color: #94a3b8 !important; }
        .form-control:focus { border-color: var(--edit-cyan); box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1); }

        /* PREVIEW PROFILE */
        .profile-preview {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 24px;
            padding: 35px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.05);
            position: sticky;
            top: 40px;
        }

        .avatar-circle {
            width: 100px; height: 100px;
            background: var(--edit-cyan);
            color: var(--bg-dark);
            font-size: 2.5rem;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.3);
        }

        .btn-update {
            background: var(--edit-cyan);
            color: var(--bg-dark);
            font-weight: 700;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            border: none;
            transition: 0.3s;
        }

        .btn-update:hover {
            background: #67e8f9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(34, 211, 238, 0.2);
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; }
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
            <a href="../controller/ListarUsuarioController.php" class="nav-link active"><i class="bi bi-people"></i> Usuarios</a>
            <a href="../view/crear-categoria.php" class="nav-link"><i class="bi bi-tag"></i> Categorías</a>
            <a href="../view/listar-producto.php" class="nav-link"><i class="bi bi-box-seam"></i> Productos</a>
            <hr class="mx-3" style="opacity: 0.1;">
            <a href="../controller/LogoutController.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left"></i> Salir</a>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg px-4 py-3 border-bottom border-secondary">
            <button type="button" id="sidebarCollapse" class="btn btn-link text-white p-0">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="ms-auto">
                <span class="badge bg-info text-dark">MODO EDICIÓN DE USUARIO</span>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <div class="row g-4 justify-content-center">
                
                <div class="col-lg-7">
                    <div class="admin-panel-card">
                        <div class="mb-5">
                            <h2 class="fw-bold text-white mb-2">Editar Perfil</h2>
                            <p class="text-pale">Actualice la información de contacto y detalles personales del usuario.</p>
                        </div>

                        <form method="POST" action="../controller/EditarUsuarioController.php">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">

                            <div class="mb-4">
                                <label class="text-edit-cyan small fw-bold text-uppercase mb-2 d-block" style="color:var(--edit-cyan)">Datos de Identidad</label>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre" class="form-control" id="user_nombre" 
                                           value="<?= htmlspecialchars($data['nombre'] ?? '') ?>" placeholder="Nombre" required>
                                    <label for="user_nombre">Nombre Completo</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-edit-cyan small fw-bold text-uppercase mb-2 d-block" style="color:var(--edit-cyan)">Contacto y Seguridad</label>
                                <div class="form-floating mb-3">
                                    <input type="email" name="correo" class="form-control" id="user_correo" 
                                           value="<?= htmlspecialchars($data['correo'] ?? '') ?>" placeholder="correo@ejemplo.com" required>
                                    <label for="user_correo">Dirección de Correo Electrónico</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-edit-cyan small fw-bold text-uppercase mb-2 d-block" style="color:var(--edit-cyan)">Información Adicional</label>
                                <div class="form-floating mb-3">
                                    <input type="date" name="fech_nac" class="form-control" id="user_fecha" 
                                           value="<?= $data['fech_nac'] ?? '' ?>" required>
                                    <label for="user_fecha">Fecha de Nacimiento</label>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" class="btn btn-update">
                                    <i class="bi bi-check2-circle me-2"></i>Actualizar Usuario
                                </button>
                                <a href="../controller/ListarUsuarioController.php" class="btn btn-outline-secondary px-4 d-flex align-items-center" style="border-radius: 12px;">
                                    Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="profile-preview shadow-lg">
                        <div class="avatar-circle" id="user_initials">
                            <?= strtoupper(substr($data['nombre'], 0, 1)) ?>
                        </div>
                        <h4 class="text-white fw-bold mb-1" id="prev_name"><?= htmlspecialchars($data['nombre']) ?></h4>
                        <p class="text-info small mb-4" id="prev_email"><?= htmlspecialchars($data['correo']) ?></p>
                        
                        <div class="bg-dark bg-opacity-50 p-3 rounded-4 border border-secondary border-opacity-25 text-start">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-pale x-small">ID de Sistema:</span>
                                <span class="text-white x-small fw-bold">#<?= $data['id'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-pale x-small">Nacimiento:</span>
                                <span class="text-white x-small" id="prev_date"><?= $data['fech_nac'] ?></span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-secondary border-opacity-10">
                            <i class="bi bi-shield-lock text-edit-cyan me-2"></i>
                            <span class="text-pale x-small">Cuenta protegida por PlusSys</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });

            // Lógica de Live Preview
            $('#user_nombre').on('input', function() {
                let name = $(this).val();
                $('#prev_name').text(name || 'Nombre Usuario');
                $('#user_initials').text(name ? name.charAt(0).toUpperCase() : '?');
            });

            $('#user_correo').on('input', function() {
                $('#prev_email').text($(this).val() || 'correo@ejemplo.com');
            });

            $('#user_fecha').on('change', function() {
                $('#prev_date').text($(this).val());
            });
        });
    </script>
</body>
</html>