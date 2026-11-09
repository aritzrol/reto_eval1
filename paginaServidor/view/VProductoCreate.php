<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if(!isset($_SESSION['logged_in_user'])) {
//     header("Location: index.php?entity=login&action=index");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Formulario de Alta de Producto</h1>
    <form method="post" action="index.php?entity=producto&action=store">
        <div class="mb-3">
            <label for="id_serie" class="form-label">Serie</label>
            <select class="form-select" id="id_serie" name="id_serie" required>
                <option value="">Selecciona una serie</option>
                <?php
                foreach ($series as $serie) {
                    $idSerie = $serie['id_serie'];
                    $nombreSerie = $serie['nombre'];
                    echo '<option value="' . $idSerie . '">' . $nombreSerie . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Número de tomo</label>
            <input type="number" class="form-control" id="numero" name="numero" placeholder="Ingresa el número" min="1" required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" placeholder="Ingresa el precio" step="0.01" min="0" required>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Ingresa el ISBN" maxlength="13">
        </div>
        <button type="submit" class="btn btn-primary">Dar de Alta</button>
        <a href="index.php?entity=producto&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>