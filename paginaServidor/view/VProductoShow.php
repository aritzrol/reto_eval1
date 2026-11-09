<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <a href="index.php?entity=usuario&action=index" class="btn btn-info">Usuarios</a>
    <a href="index.php?entity=producto&action=index" class="btn btn-info">Productos</a>
    <a href="index.php?entity=serie&action=index" class="btn btn-info">Series</a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Detalle del Producto</h1>

    <?php if ($data) { ?>
        <table class="table table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Serie</th>
                    <th scope="col">Número</th>
                    <th scope="col">Precio</th>
                    <th scope="col">ISBN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    echo '<tr>';
                    echo '<td>' . $data['id_producto'] . '</td>';
                    echo '<td>' . htmlspecialchars($data['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['numero']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['precio']) . '€</td>';
                    echo '<td>' . htmlspecialchars($data['isbn']) . '</td>';
                    echo '</tr>';
                ?>
            </tbody>
        </table>
        <a href="index.php?entity=producto&action=edit&id=<?php echo $data['id_producto']; ?>" class="btn btn-warning">Modificar</a>
        <a href="index.php?entity=producto&action=destroy&id=<?php echo $data['id_producto']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">Eliminar</a>
        <a href="index.php?entity=producto&action=index" class="btn btn-secondary">Volver a la lista</a>
    <?php } else { ?>
        <div class="alert alert-warning text-center">No existe ese producto.</div>
        <div class="text-center"><a href="index.php?entity=producto&action=index" class="btn btn-secondary">Volver a la lista</a></div>
    <?php } ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
