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
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Modificar Producto</h1>

    <?php if ($data) { ?>
        <form method="post" action="index.php?entity=producto&action=update">
            <input type="hidden" name="id_producto" value="<?php echo $data['id_producto']; ?>">
            <div class="mb-3">
                <label for="id_serie" class="form-label">Serie</label>
                <select class="form-select" id="id_serie" name="id_serie" required>
                    <?php
                    foreach ($series as $serie) {
                        $idSerie = $serie['id_serie'];
                        $nombreSerie = htmlspecialchars($serie['nombre']);
                        $selected = ($data['id_serie'] == $idSerie) ? ' selected' : '';
                        echo '<option value="' . $idSerie . '"' . $selected . '>' . $nombreSerie . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número de tomo</label>
                <input type="number" class="form-control" id="numero" name="numero" value="<?php echo $data['numero']; ?>" min="1" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $data['precio']; ?>" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($data['isbn']); ?>" maxlength="13">
            </div>
            <button type="submit" class="btn btn-warning">Guardar cambios</button>
            <a href="index.php?entity=producto&action=index" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe ese producto.</div>
        <div class="text-center"><a href="index.php?entity=producto&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>