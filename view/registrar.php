<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | Premium Design</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --azul-oscuro: #0f172a;
            --azul-claro: #38bdf8;
            --gris-premium: #94a3b8;
            --dorado: #c5a059;
            --dorado-brillante: #e2c275;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at bottom left, #1e293b, #0f172a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px; /* Un poco más ancho para los formularios de registro */
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(197, 160, 89, 0.2);
            border-radius: 24px;
            padding: 2rem;
            color: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .card-title {
            font-weight: 700;
            letter-spacing: -1px;
        }

        .card-title span {
            color: var(--dorado);
        }

        .form-label {
            color: var(--gris-premium);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white !important;
            padding: 10px 15px;
        }

        /* Estilo para el input de fecha (calendario) */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Hace que el icono del calendario sea blanco */
            cursor: pointer;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--azul-claro);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .btn-register {
            background: linear-gradient(135deg, #198754, #146c43); /* Verde éxito elegante */
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
            filter: brightness(1.1);
        }

        .back-link {
            color: var(--gris-premium);
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--dorado);
        }

        /* Ajuste para que quepa en pantallas de laptop pequeñas */
        @media (max-height: 750px) {
            .card { padding: 1.5rem; }
            .mb-3 { margin-bottom: 0.8rem !important; }
            h2 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="card">
            <div class="text-center mb-4">
                <h2 class="card-title">Crear <span>Usuario</span></h2>
                <p class="small text">Únete a nuestra plataforma exclusiva</p>
            </div>

            <form action="../controller/registrarController.php" method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person me-1"></i> Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Juan Pérez" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-envelope me-1"></i> Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-lock me-1"></i> Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-calendar-event me-1"></i> Fecha de Nacimiento</label>
                    <input type="date" name="fech_nac" class="form-control" required>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center py-2 mb-3" style="font-size: 0.85rem; border-radius: 8px;">
                        <i class="bi bi-exclamation-circle me-1"></i> Este correo ya está registrado
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-register w-100">
                    Finalizar Registro
                </button>

                <div class="text-center mt-4">
                    <a href="login.php" class="back-link">
                        <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>