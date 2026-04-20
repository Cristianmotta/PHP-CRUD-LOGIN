<?php
require_once '../model/categoria.php';
$categoriaModel = new categoria();
$categorias = $categoriaModel->obtenerTodas();
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto | PlusSys</title>
    
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
            --glass: rgba(255, 255, 255, 0.03);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
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

        /* --- INNOVACIÓN: FORM DESIGN --- */
        .admin-panel-card {
            background: var(--sidebar-color);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-floating > .form-control, .form-floating > .form-select {
            background-color: var(--bg-dark) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
        }

        .form-floating > label { color: #94a3b8 !important; }

        /* Estilo para los inputs enfocados */
        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.15);
        }

        /* LIVE PREVIEW CARD */
        .preview-box {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 1px dashed var(--accent-gold);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            position: sticky;
            top: 100px;
        }

        .btn-gold-lg {
            background: var(--accent-gold);
            color: #000;
            font-weight: 700;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            border: none;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-gold-lg:hover {
            background: #e2c275;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2);
        }

        .step-number {
            width: 35px; height: 35px;
            background: rgba(197, 160, 89, 0.1);
            color: var(--accent-gold);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
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
            <a href="../controller/ListarUsuarioController.php" class="nav-link"><i class="bi bi-people"></i> Usuarios</a>
            <a href="../view/crear-categoria.php" class="nav-link"><i class="bi bi-tag"></i> Categorías</a>
            <a href="../view/listar-producto.php" class="nav-link active"><i class="bi bi-box-seam"></i> Productos</a>
            <hr class="mx-3" style="opacity: 0.1;">
            <a href="../controller/LogoutController.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left"></i> Salir</a>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg px-4 py-3">
            <button type="button" id="sidebarCollapse" class="btn btn-link text-white p-0">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="ms-auto text-pale small">Gestión de Inventario > <span class="text-white">Añadir Nuevo</span></div>
        </nav>

        <div class="container-fluid p-4">
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="admin-panel-card">
                        <div class="mb-5">
                            <h2 class="fw-bold text-white mb-2">Crear Producto</h2>
                            <p class="text-pale">Define las especificaciones del nuevo artículo para el catálogo.</p>
                        </div>

                        <form action="../controller/productoController.php" method="POST">
                            
                            <div class="mb-4">
                                <h6 class="text-gold mb-3 text-uppercase small fw-bold"><span class="step-number">1</span>Información General</h6>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre" class="form-control" id="prod_nombre" placeholder="Nombre" required>
                                    <label for="prod_nombre">Nombre del Producto</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-gold mb-3 text-uppercase small fw-bold"><span class="step-number">2</span>Precios y Clasificación</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="0.01" name="precio" class="form-control" id="prod_precio" placeholder="0.00" required>
                                            <label for="prod_precio">Precio de Venta ($)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="id_categoria" class="form-select" id="prod_cat" required>
                                                <option value="" selected disabled>Seleccione...</option>
                                                <?php foreach ($categorias as $c): ?>
                                                    <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="prod_cat">Categoría</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" class="btn btn-gold-lg">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>Registrar Producto
                                </button>
                                <a href="../view/listar-producto.php" class="btn btn-outline-secondary px-4 d-flex align-items-center" style="border-radius: 12px;">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="preview-box">
                        <i class="bi bi-eye text-gold fs-4 mb-3"></i>
                        <h6 class="text-pale small text-uppercase fw-bold mb-4">Vista Previa en Vivo</h6>
                        
                        <div class="card bg-dark border-0 overflow-hidden text-start shadow-lg" style="border-radius: 15px;">
                            <div style="height: 150px; background: rgba(197, 160, 89, 0.05); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                            <div class="card-body p-4">
                                <span class="badge bg-gold text-dark mb-2" id="prev_cat">CATEGORÍA</span>
                                <h5 class="text-white fw-bold mb-1" id="prev_nombre">Nombre del Producto</h5>
                                <h4 class="text-white" id="prev_precio">$0.00</h4>
                                <hr style="opacity: 0.1;">
                                <div class="d-flex justify-content-between align-items-center text-white small">
                                    <span>Stock: 0 unidades</span>
                                    <span>ID: #---</span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 text-white x-small">Así es como el usuario visualizará el producto en el listado general.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).ready(function() {
            // Sidebar toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
            });

            // LÓGICA DE VISTA PREVIA EN VIVO
            $('#prod_nombre').on('input', function() {
                let val = $(this).val();
                $('#prev_nombre').text(val || 'Nombre del Producto');
            });

            $('#prod_precio').on('input', function() {
                let val = parseFloat($(this).val());
                $('#prev_precio').text(isNaN(val) ? '$0.00' : '$' + val.toLocaleString('en-US', {minimumFractionDigits: 2}));
            });

            $('#prod_cat').on('change', function() {
                let texto = $(this).find("option:selected").text();
                $('#prev_cat').text(texto.toUpperCase());
            });
        });
    </script>
</body>
</html>