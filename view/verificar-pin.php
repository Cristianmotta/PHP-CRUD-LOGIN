<?php
session_start();

if(!isset($_SESSION['correo_recuperacion'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar PIN | Mi Sistema</title>
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
            padding: 1.5rem 1rem;
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

        /* Estilos de los bloques para el PIN */
        .pin-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 2rem 0;
        }

        .pin-input {
            width: 50px;
            height: 55px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            background-color: #f8fafc;
            color: var(--azul-oscuro);
            transition: all 0.2s ease;
        }

        .pin-input:focus {
            outline: none;
            border-color: var(--azul-claro);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
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
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3 class="fw-bold m-0" style="color: var(--azul-oscuro);">Verificar PIN</h3>
            <p class="text-muted small mt-2">Hemos enviado un código de seguridad a tu correo. Por favor, ingrésalo a continuación.</p>
        </div>

        <form action="../controller/VerificarPinController.php" method="POST" id="pinForm">
            
            <!-- Input oculto para recolectar el PIN completo y enviarlo a PHP -->
            <input type="hidden" name="pin" id="hiddenPin">

            <!-- Cuadritos visuales de 6 dígitos -->
            <div class="pin-container">
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <input type="text" class="pin-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
            </div>

            <!-- Acciones -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-gold shadow-sm">
                    <i class="bi bi-check2-circle me-2"></i>Verificar Código
                </button>
                <a href="login.php" class="btn btn-return text-decoration-none text-center">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

    <!-- Gestión de Mensajes Toast desde PHP -->
    <?php if(isset($_GET['error']) && $_GET['error'] == 'incorrecto'): ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'PIN incorrecto',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'expirado'): ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'El PIN ha expirado',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'PIN verificado correctamente',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>

    <!-- Lógica JavaScript para controlar el flujo de los cuadros -->
    <script>
        const inputs = document.querySelectorAll('.pin-container input');
        const hiddenPin = document.getElementById('hiddenPin');
        const form = document.getElementById('pinForm');

        inputs.forEach((input, index) => {
            // Auto-saltar al siguiente cuadro al escribir
            input.addEventListener('input', (e) => {
                // Verificar que solo se ingresen números
                if (isNaN(input.value)) {
                    input.value = '';
                    return;
                }
                
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateHiddenInput();
            });

            // Detectar borrado para regresar al cuadro anterior
            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Junta los valores de los 6 cuadros en el input oculto
        function updateHiddenInput() {
            let pinValue = "";
            inputs.forEach(input => {
                pinValue += input.value;
            });
            hiddenPin.value = pinValue;
        }

        // Asegurar que se unan todos los campos antes de enviar el formulario
        form.addEventListener('submit', (e) => {
            updateHiddenInput();
            if(hiddenPin.value.length !== 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Incompleto',
                    text: 'Por favor introduce los 6 dígitos del PIN.',
                    confirmButtonColor: '#0f172a'
                });
            }
        });
    </script>
</body>
</html>