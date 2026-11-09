<?php
    session_start();
    if(!isset($_SESSION['logged_in_user'])){
        header("Location: index.php?entity=login&action=index");
        exit();
    }
    $id_usuario = $_SESSION['id_usuario'];
    $usuario = $_SESSION['usuario'];
    $rol_usuario = $_SESSION['rol_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <a href="index.php?entity=usuario&action=index" class="btn btn-info">Usuarios</a>
    <a href="index.php?entity=producto&action=index" class="btn btn-info">Productos</a>
    <a href="index.php?entity=serie&action=index" class="btn btn-info">Series</a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Detalle de Usuario</h1>

    <?php if ($data) { ?>
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td><?php echo $data['id_usuario']; ?></td>
                </tr>
                <tr>
                    <th scope="row">Nombre</th>
                    <td><?php echo htmlspecialchars($data['nombre']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td><?php echo htmlspecialchars($data['email']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Rol</th>
                    <td><?php echo htmlspecialchars($data['rol']); ?></td>
                </tr>
                <tr>
                    <th scope="row">Apellidos</th>
                    <td><?php echo htmlspecialchars($data['apellidos'] ?? ''); ?></td>
                </tr>
                <tr>
                    <th scope="row">Teléfono</th>
                    <td><?php echo htmlspecialchars($data['telefono'] ?? ''); ?></td>
                </tr>
                <tr>
                    <th scope="row">Dirección</th>
                    <td><?php echo htmlspecialchars($data['direccion'] ?? ''); ?></td>
                </tr>
            </tbody>
        </table>

        <a href="index.php?entity=usuario&action=edit&id=<?php echo $data['id_usuario']; ?>" class="btn btn-warning">Modificar</a>
        <a href="index.php?entity=usuario&action=index" class="btn btn-secondary">Volver a la lista</a>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe ese usuario.</div>
        <div class="text-center"><a href="index.php?entity=usuario&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>