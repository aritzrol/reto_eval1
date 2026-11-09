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
    <title>Modificar Serie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Modificar Serie</h1>

    <?php if ($data) { ?>
        <form method="post" action="index.php?entity=serie&action=update">
            <input type="hidden" name="id_serie" value="<?php echo $data['id_serie']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Serie</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['nombre']); ?>" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea class="form-control" id="sinopsis" name="sinopsis" rows="3"><?php echo htmlspecialchars($data['sinopsis']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                <input type="text" class="form-control" id="genero" name="genero" value="<?php echo htmlspecialchars($data['genero']); ?>" maxlength="50">
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($data['autor']); ?>" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" id="editorial" name="editorial" value="<?php echo htmlspecialchars($data['editorial']); ?>" maxlength="50">
            </div>
            <button type="submit" class="btn btn-warning">Guardar cambios</button>
            <a href="index.php?entity=serie&action=index" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe esa serie.</div>
        <div class="text-center"><a href="index.php?entity=serie&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>