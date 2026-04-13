<?php
if (!isset($usuarios)) {
    die("Acceso no permitido");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
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

    <h2 class="mb-4">Lista de Usuarios</h2>

    <a href="../view/crear-usuario.php" class="btn btn-success mb-3">+ Crear usuarios</a>

    <table class="table table-bordered table-hover shadow">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha Nacimiento</th>
                <th></th>
                <th></th>
            </tr>
        </thead>


        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr id="fila-<?= $u['id'] ?>">
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['correo']) ?></td>
                    <td><?= $u['fech_nac']  ?></td>
                    <td><a href="../controller/EditarUsuarioController.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Editar</a></td>
                    <td><a href="#" onclick="return confirmarEliminar(<?= $u['id'] ?>)" class="btn btn-danger btn-sm">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <div class="container-fluid">
        <a href="../controller/LogoutController.php" class="btn btn-danger btn-sm">Volver</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmarEliminar(id){
        Swal.fire({
            title: '¿Estas seguro?',
            text: "No podras recuperar este usuario",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result)=> {
            if(result.isConfirmed){
                window.location.href = "../controller/EliminarUsuarioController.php?id=" + id;
            }
        });

        return false;
    }
</script>

<?php if (isset($_GET['eliminado'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Eliminado',
    text: 'Usuario eliminado correctamente',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>
</body>
</html>