<?php 
require_once '../model/producto.php';
require_once '../model/categoria.php';

if (!isset($_GET['id'])){
    header("Location: listar-producto.php");
    exit;
}

$id = (int) $_GET['id'];
$categoriaModel = new categoria();
$categorias = $categoriaModel->obtenerTodas();

$productoModel = new producto();
$producto = $productoModel->obtenerPorId($id);

if (!$producto){
    echo "Producto no encontrado";
    exit;
}
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar #<?= $id ?> | PlusSys</title>
    
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
            --edit-blue: #38bdf8;
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

        /* --- EDIT CARD DESIGN --- */
        .admin-panel-card {
            background: var(--sidebar-color);
            border-radius: 24px;
            border: 1px solid rgba(56, 189, 248, 0.2); /* Borde azulado para indicar edición */
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
        .form-control:focus { border-color: var(--accent-gold); box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.15); }

        /* LIVE PREVIEW */
        .preview-box {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 1px dashed var(--edit-blue);
            border-radius: 20px;
            padding: 30px;
            position: sticky;
            top: 100px;
        }

        .btn-update {
            background: var(--accent-gold);
            color: #000;
            font-weight: 700;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            border: none;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-update:hover {
            background: #e2c275;
            transform: scale(1.02);
        }

        .id-badge {
            background: rgba(56, 189, 248, 0.1);
            color: var(--edit-blue);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            border: 1px solid rgba(56, 189, 248, 0.2);
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
            <div class="ms-auto d-flex align-items-center">
                <span class="id-badge me-3">MODO EDICIÓN</span>
                <span class="text-pale small">Inventario > <span class="text-white">Editar Producto</span></span>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="admin-panel-card">
                        <div class="mb-5">
                            <h2 class="fw-bold text-white mb-2">Modificar Registro</h2>
                            <p class="text-pale">Actualice los valores del producto seleccionado. El ID del registro no puede ser modificado.</p>
                        </div>

                        <form method="POST" action="../controller/productoController.php">
                            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                            
                            <div class="mb-4">
                                <h6 class="text-gold mb-3 text-uppercase small fw-bold">Identificación del Producto</h6>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre" class="form-control" id="edit_nombre" 
                                           value="<?= htmlspecialchars($producto['nombre']) ?>" placeholder="Nombre" required>
                                    <label for="edit_nombre">Nombre del Producto</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-gold mb-3 text-uppercase small fw-bold">Valores y Categoría</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="0.01" name="precio" class="form-control" id="edit_precio" 
                                                   value="<?= $producto['precio'] ?>" placeholder="0.00" required>
                                            <label for="edit_precio">Precio Unitario ($)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="id_categoria" class="form-select" id="edit_cat" required>
                                                <?php foreach ($categorias as $c): ?>
                                                    <option value="<?= $c['id'] ?>" <?= ($producto['id_categoria'] == $c['id']) ? 'selected' : '' ?>>
                                                        <?= $c['nombre'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="edit_cat">Categoría Asignada</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" name="editar" class="btn btn-update">
                                    <i class="bi bi-arrow-repeat me-2"></i>Guardar Cambios
                                </button>
                                <a href="listar-producto.php" class="btn btn-outline-secondary px-4 d-flex align-items-center" style="border-radius: 12px;">
                                    Descartar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="preview-box">
                        <div class="text-center mb-4">
                            <span class="badge bg-info text-dark mb-2">VISTA PREVIA ACTUALIZADA</span>
                        </div>
                        
                        <div class="card bg-dark border-0 overflow-hidden shadow-lg" style="border-radius: 15px;">
                            <div class="p-3 bg-secondary bg-opacity-10 d-flex justify-content-between">
                                <span class="text-pale x-small">ID: #<?= $producto['id'] ?></span>
                                <i class="bi bi-pencil-square text-info"></i>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <span class="text-gold x-small text-uppercase fw-bold" id="prev_cat_edit">---</span>
                                <h4 class="text-white fw-bold mb-1" id="prev_nombre_edit"><?= htmlspecialchars($producto['nombre']) ?></h4>
                                <h3 class="text-info" id="prev_precio_edit">$<?= number_format($producto['precio'], 2) ?></h3>
                                <hr style="opacity: 0.1;">
                                <div class="alert alert-info py-2 small border-0 bg-opacity-10 text-info" style="font-size: 0.7rem;">
                                    <i class="bi bi-info-circle me-1"></i> Los cambios se verán reflejados en el inventario global al guardar.
                                </div>
                            </div>
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

            // Inicializar texto de categoría en preview
            $('#prev_cat_edit').text($('#edit_cat option:selected').text().toUpperCase());

            // LÓGICA DE VISTA PREVIA
            $('#edit_nombre').on('input', function() {
                $('#prev_nombre_edit').text($(this).val() || 'Nombre del Producto');
            });

            $('#edit_precio').on('input', function() {
                let val = parseFloat($(this).val());
                $('#prev_precio_edit').text(isNaN(val) ? '$0.00' : '$' + val.toLocaleString('en-US', {minimumFractionDigits: 2}));
            });

            $('#edit_cat').on('change', function() {
                $('#prev_cat_edit').text($(this).find("option:selected").text().toUpperCase());
            });
        });
    </script>
</body>
</html>