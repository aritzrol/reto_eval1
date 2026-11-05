<?php
// session_start();
// if (!isset($_SESSION['logged_in_user'])) {
//     header("Location: ../index.php?entity=login&action=index");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <a href="index.php?entity=usuario&action=index" class="btn btn-info">Usuarios</a>
    <a href="index.php?entity=producto&action=index" class="btn btn-info">Productos</a>
    <a href="index.php?entity=serie&action=index" class="btn btn-info">Series</a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Productos</h1>

    <table class="table table-striped table-bordered">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Serie</th>
                <th scope="col">Número</th>
                <th scope="col">Precio</th>
                <th scope="col">ISBN</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($data as $dato) {
                    echo '<tr>';
                    echo '<td>' . $dato["id_producto"] . '</td>';
                    echo '<td>' . htmlspecialchars($dato["nombre_serie"]) . '</td>';
                    echo '<td>' . $dato["numero"] . '</td>';
                    echo '<td>' . $dato["precio"] . ' €</td>';
                    echo '<td>' . htmlspecialchars($dato["isbn"]) . '</td>';
                    echo '<td>';
                    echo '<a href="index.php?entity=producto&action=edit&id=' . $dato['id_producto'] . '" class="btn btn-warning mx-1">Modificar</a>';
                    echo '<a href="index.php?entity=producto&action=destroy&id=' . $dato['id_producto'] . '" class="btn btn-danger mx-1" onclick="return confirm(\'¿Eliminar este producto?\');">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
    <a href="index.php?entity=producto&action=create" class="btn btn-success">Crear nuevo producto</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>