<?php
session_start();

if(
    !isset($_SESSION['correo_recuperacion']) ||
    !isset($_SESSION['pin_verificacion'])
){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña | Mi Sistema</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            max-width: 440px;
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .auth-header {
            text-align: center;
            padding: 1.5rem 1rem 0.5rem 1rem;
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

        /* Barra de fuerza personalizada */
        .progress {
            background-color: #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        /* Botón de envío */
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
        }
    </style>
</head>
<body>

    <div class="card auth-card shadow p-4 p-sm-5">
        
        <div class="auth-header">
            <div class="icon-circle">
                <i class="bi bi-lock-hash"></i>
            </div>
            <h3 class="fw-bold m-0" style="color: var(--azul-oscuro);">Nueva Contraseña</h3>
            <p class="text-muted small mt-2">Por tu seguridad, crea una combinación fuerte que no utilices en otros sitios.</p>
        </div>

        <!-- Alerta Bootstrap clásica en caso de error en servidor -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger d-flex align-items-start gap-2 small border-0" style="background-color: #fef2f2; color: #991b1b; border-radius: 12px;">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <div>
                    <strong>La contraseña debe cumplir:</strong>
                    <ul class="mb-0 ps-3 mt-1">
                        <li>Mínimo 8 caracteres</li>
                        <li>Una letra mayúscula</li>
                        <li>Un número</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <form action="../controller/NuevaContraseñaController.php" method="POST" id="resetForm">

            <!-- Campo: Nueva Contraseña -->
            <div class="mb-3">
                <label class="form-label">Nueva Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input 
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="••••••••"
                        required>
                </div>
                
                <div class="progress mt-2" style="height: 6px;">
                    <div
                        id="barraPassword"
                        class="progress-bar"
                        style="width: 0%">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-1">
                    <small id="textoPassword" class="text-danger fw-semibold" style="font-size: 0.75rem;">
                        Contraseña muy corta
                    </small>
                </div>
            </div>

            <!-- Campo: Confirmar Contraseña -->
            <div class="mb-4">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input 
                        type="password"
                        name="confirmar"
                        id="confirmar"
                        class="form-control"
                        placeholder="••••••••"
                        required>
                </div>
                <small id="mensajeConfirmacion" class="text-danger fw-semibold d-block mt-1" style="font-size: 0.75rem;">
                    ✖ Las contraseñas no coinciden
                </small>
            </div>

            <!-- Acciones -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-gold shadow-sm">
                    <i class="bi bi-arrow-right-circle me-2"></i>Actualizar Contraseña
                </button>
                <a href="login.php" class="btn btn-return text-decoration-none text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Gestión de Alertas con SweetAlert2 -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'confirmar'): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'No coinciden',
                text: 'Las contraseñas ingresadas no son iguales.',
                confirmButtonColor: '#0f172a'
            });
        </script>
    <?php elseif (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Contraseña inválida',
                confirmButtonColor: '#0f172a',
                html: `
                    <div style="text-align: left; padding-left: 1.5rem;">
                        <p>Tu nueva clave debe incluir obligatoriamente:</p>
                        <ul>
                            <li>Mínimo 8 caracteres de longitud</li>
                            <li>Al menos una letra mayúscula</li>
                            <li>Al menos un número</li>
                        </ul>
                    </div>
                `
            });
        </script>
    <?php endif; ?>

    <!-- Lógica del medidor de fuerza y coincidencias -->
    <script>
        const password = document.getElementById("password");
        const barra = document.getElementById("barraPassword");
        const texto = document.getElementById("textoPassword");
        const confirmar = document.getElementById("confirmar");
        const mensaje = document.getElementById("mensajeConfirmacion");

        password.addEventListener("keyup", function(){
            const valor = password.value;
            let fuerza = 0;

            if(valor.length >= 8) fuerza++;
            if(/[A-Z]/.test(valor))  fuerza++;
            if(/[0-9]/.test(valor))  fuerza++;

            switch(fuerza){
                case 0:
                case 1:
                    barra.style.width = "33%";
                    barra.className = "progress-bar bg-danger";
                    texto.innerHTML = "Contraseña débil";
                    texto.className = "text-danger fw-semibold";
                    break;
                case 2:
                    barra.style.width = "66%";
                    barra.className = "progress-bar";
                    barra.style.backgroundColor = "var(--dorado)"; // Combinación intermedia dorada
                    texto.innerHTML = "Contraseña media";
                    texto.className = "fw-semibold";
                    texto.style.color = "var(--dorado)";
                    break;
                case 3:
                    barra.style.width = "100%";
                    barra.className = "progress-bar bg-success";
                    texto.innerHTML = "Contraseña segura";
                    texto.className = "text-success fw-semibold";
                    break;
            }
        });

        function verificarCoincidencia() {
            if(password.value === "" && confirmar.value === "") {
                mensaje.innerHTML = "";
                return;
            }

            if(password.value === confirmar.value){
                mensaje.innerHTML = "✔ Las contraseñas coinciden";
                mensaje.className = "text-success fw-semibold mt-1 d-block";
            } else {
                mensaje.innerHTML = "✖ Las contraseñas no coinciden";
                mensaje.className = "text-danger fw-semibold mt-1 d-block";
            }
        }

        password.addEventListener("keyup", verificarCoincidencia);
        confirmar.addEventListener("keyup", verificarCoincidencia);
    </script>
</body>
</html>