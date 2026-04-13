<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
<body class="bg-light">
<div class="container mt-5">

    <div class="card p-4 shadow">
        <h2>Editar Usuario</h2>

        <form  method="POST"  action="../controller/EditarUsuarioController.php">

            <input type="hidden" name="id" value="<?= $data['id'] ?>" required>

                <div class="mb-3">
                    <label>Nombre:</label><br>
                    <input type="text" name="nombre" value="<?= $data['nombre'] ?>"  class="form-control" required>
                </div>
        
                <div class="mb-3">
                    <label>Correo:</label>
                    <input type="email" name="correo" value="<?=  $data['correo'] ?>"  class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Fecha:</label>
                    <input type="date" name="fech_nac" value="<?= $data['fech_nac'] ?>"  class="form-control"  require>
                </div>

                <button class="btn btn-primary" type="submit">Actualizar</button>
                <a href="../controller/ListarUsuarioController.php" class="btn btn-secondary">volver</a>
        </form>
        
    </div>
</div>
    

    
</body>
</html>