<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | Mi Sistema</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --azul-oscuro: #0f172a;
            --azul-claro: #38bdf8;
            --gris-premium: #64748b;
            --dorado: #c5a059;
            --dorado-brillante: #e2c275;
        }

        body {
            background-color: var(--azul-oscuro);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .auth-header {
            text-align: center;
            padding: 2.5rem 2rem 1.5rem 2rem;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background-color: #f1f5f9;
            color: var(--dorado);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.25rem auto;
            box-shadow: 0 4px 10px rgba(197, 160, 89, 0.15);
        }

        .form-label {
            color: var(--azul-oscuro);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: var(--gris-premium);
        }

        .form-control {
            border-color: #cbd5e1;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--azul-claro);
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.15);
        }

        /* Botón Principal (Dorado) */
        .btn-gold {
            background-color: var(--dorado);
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: var(--dorado-brillante);
            color: var(--azul-oscuro);
            transform: translateY(-1px);
        }

        /* Botón Volver (Limpio) */
        .btn-return {
            color: var(--gris-premium);
            background: transparent;
            border: 1px solid #e2e8f0;
            font-weight: 500;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-return:hover {
            background-color: #f8fafc;
            color: var(--azul-oscuro);
            border-color: #cbd5e1;
        }
    </style>
</head>
<body>

    <div class="card auth-card shadow p-4 p-sm-5">
        
        <div class="auth-header">
            <div class="icon-circle">
                <i class="bi bi-key-fill"></i>
            </div>
            <h3 class="fw-bold m-0" style="color: var(--azul-oscuro);">¿Olvidaste tu contraseña?</h3>
            <p class="text-muted small mt-2">Introduce tu correo electrónico y te enviaremos un PIN de seguridad para restablecerla.</p>
        </div>

        <form action="../controller/RecuperarController.php" method="POST">

            <!-- Campo Correo Electrónico -->
            <div class="mb-4">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" 
                           name="correo" 
                           class="form-control" 
                           placeholder="ejemplo@correo.com"
                           required>
                </div>
            </div>

            <!-- Acciones -->
            <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-gold shadow-sm">
                    <i class="bi bi-shield-check me-2"></i>Enviar Pin
                </button>
                
                <a href="login.php" class="btn btn-return text-decoration-none text-center">
                    <i class="bi bi-arrow-left me-1"></i>Volver al Login
                </a>
            </div>

        </form>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>