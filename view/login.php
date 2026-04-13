<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body{
            background: linear-gradient(135deg, #1D4ed8, #0d9488);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card{
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 350px;">
        <h2 class="text-center mb-3">Iniciar sesión</h2>

        <form action="../controller/LoginController.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Correo: </label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña: </label>
                <input type="password" name="password" class="form-control" required><br>
            </div>
           
            <button class="btn btn-primary w-100" type="submit">Ingresar</button>
            
        </form>
    </div>
    

    
</body>
</html>