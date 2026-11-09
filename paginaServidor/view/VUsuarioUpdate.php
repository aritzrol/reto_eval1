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
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Modificar Usuario</h1>

    <?php if ($data) { ?>
        <form method="post" action="index.php?entity=usuario&action=update&id=<?php echo $data['id_usuario']; ?>">
            <input type="hidden" name="id_usuario" value="<?php echo $data['id_usuario']; ?>">

            <h4>Datos de la cuenta</h4>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['nombre']); ?>" maxlength="50" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Escribe la contraseña" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="cliente" <?php echo ($data['rol'] == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                    <option value="admin" <?php echo ($data['rol'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <h4 class="mt-4">Perfil</h4>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($data['apellidos'] ?? ''); ?>" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($data['telefono'] ?? ''); ?>" maxlength="15">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($data['direccion'] ?? ''); ?>" maxlength="200">
            </div>

            <button type="submit" class="btn btn-warning">Guardar cambios</button>
            <a href="index.php?entity=usuario&action=index" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe ese usuario.</div>
        <div class="text-center"><a href="index.php?entity=usuario&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>