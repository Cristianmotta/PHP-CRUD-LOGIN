<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Premium Design</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Inter', sans-serif;
            /* Fondo con profundidad */
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        /* Contenedor Adaptable */
        .login-container {
            width: 100%;
            max-width: 400px; /* Tamaño ideal para laptop y móvil */
            z-index: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(197, 160, 89, 0.3); /* Borde dorado sutil */
            border-radius: 24px;
            padding: 2.5rem;
            color: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .card-title {
            font-weight: 700;
            letter-spacing: -1px;
            color: white;
        }

        .card-title span {
            color: var(--dorado);
        }

        /* Inputs Modernos */
        .form-label {
            color: var(--gris-premium);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--azul-claro);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
            color: white;
        }

        /* Botón con el Plus Dorado */
        .btn-ingresar {
            background: linear-gradient(135deg, var(--dorado), var(--dorado-brillante));
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-ingresar:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3);
            background: var(--dorado-brillante);
        }

        .btn-crear-cuenta {
            color: var(--azul-claro);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-crear-cuenta:hover {
            color: white;
        }

        /* Alertas Personalizadas */
        .custom-alert {
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.9rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .barra-tiempo {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.5);
            animation: disminuir 10s linear forwards;
        }

        @keyframes disminuir {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* Ajuste para pantallas muy pequeñas */
        @media (max-height: 600px) {
            body { align-items: flex-start; }
            .card { padding: 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <?php if (isset($_GET['registro'])): ?>
            <div id="mensajeRegistro" class="alert alert-success custom-alert mb-4 bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i> Usuario registrado con éxito
                <div class="barra-tiempo"></div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="text-center mb-4">
                <div class="mb-2" style="font-size: 2.5rem; color: var(--dorado);">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h2 class="card-title">Bienvenido <span>Plus</span></h2>
                <p class="text small">Ingresa tus credenciales para continuar</p>
            </div>

            <form action="../controller/LoginController.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div id="mensajeError" class="alert alert-danger custom-alert bg-danger text-white mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Datos incorrectos
                        <div class="barra-tiempo"></div>
                    </div>
                <?php endif; ?>

                <button class="btn btn-ingresar w-100 mb-4" type="submit">
                    Ingresar al Sistema
                </button>

                <div class="text-center">
                    <span class="text-muted small">¿No tienes una cuenta?</span><br>
                    <a href="registrar.php" class="btn-crear-cuenta">
                        Regístrate ahora
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función genérica para ocultar mensajes
        const autoHide = (id) => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => {
                    el.style.transition = "opacity 0.5s ease";
                    el.style.opacity = "0";
                    setTimeout(() => el.remove(), 500);
                }, 10000);
            }
        };

        autoHide("mensajeError");
        autoHide("mensajeRegistro");
    </script>
</body>
</html>