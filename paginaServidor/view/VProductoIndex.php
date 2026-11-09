<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
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
    <h1 class="text-center mb-4">Lista de Productos</h1>

    <?php
        $mensajesError = [
            'store'   => 'No se ha podido crear el producto (¿ISBN repetido?).',
            'update'  => 'No se ha podido modificar el producto (¿ISBN repetido?).',
            'destroy' => 'No se ha podido eliminar el producto (puede que esté en algún pedido).'
        ];
        if (!empty($error) && isset($mensajesError[$error])) {
            echo '<div class="alert alert-danger">' . $mensajesError[$error] . '</div>';
        }
    ?>

    <a href="index.php?entity=producto&action=create" class="btn btn-success mb-3">Crear nuevo producto</a>

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
                if (empty($data)) {
                    echo '<tr><td colspan="6" class="text-center">No hay productos.</td></tr>';
                }

                foreach ($data as $dato) {
                    $id = (int) $dato['id_producto'];
                    echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $dato['nombre_serie'] . '</td>';
                    echo '<td>' . $dato['numero'] . '</td>';
                    echo '<td>' . $dato['precio'] . '€</td>';
                    echo '<td>' . (string) $dato['isbn'] . '</td>';
                    echo '<td>';
                    echo '<a href="index.php?entity=producto&action=show&id=' . $id . '" class="btn btn-info mx-1">Ver</a>';
                    echo '<a href="index.php?entity=producto&action=edit&id=' . $id . '" class="btn btn-warning mx-1">Modificar</a>';
                    echo '<a href="index.php?entity=producto&action=destroy&id=' . $id . '" class="btn btn-danger mx-1" onclick="return confirm(\'¿Seguro que quieres eliminar este producto?\');">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
