<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
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
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Modificar Pedido</h1>

    <?php if ($data) { ?>
        <form method="post" action="index.php?entity=pedido&action=update">
            <input type="hidden" name="id_pedido" value="<?php echo $data['id_pedido']; ?>">
            <input type="hidden" name="id_usuario" value="<?php echo $data['id_usuario']; ?>">
            <div class="mb-3">
                <label for="Nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['nombre']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="Fecha" class="form-label">Fecha</label>
                <input type="text" class="form-control" id="numero" name="fecha" value="<?php echo $data['fecha']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="precio_total" class="form-label">Precio total del pedido</label>
                <input type="number" class="form-control" id="precio_total" name="precio_total" value="<?php echo $data['precio_total']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="estado_pedido" class="form-label">Estado del pedido</label>
                <select class="form-select" id="estado_pedido" name="estado_pedido" required>
                    <option value="pendiente" <?php echo ($data['estado_pedido'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="pagado" <?php echo ($data['estado_pedido'] == 'pagado') ? 'selected' : ''; ?>>Pagado</option>
                    <option value="enviado" <?php echo ($data['estado_pedido'] == 'enviado') ? 'selected' : ''; ?>>Enviado</option>
                    <option value="cancelado" <?php echo ($data['estado_pedido'] == 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Guardar cambios</button>
            <a href="index.php?entity=pedido&action=index" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe ese producto.</div>
        <div class="text-center"><a href="index.php?entity=producto&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>