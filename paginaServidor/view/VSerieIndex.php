<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Series</title>
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
    <h1 class="text-center mb-4">Lista de Series</h1>

    <table class="table table-striped table-bordered">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Autor</th>
                <th scope="col">Tomos</th>
                <th scope="col">Editorial</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($data as $dato) {
                    echo '<tr>';
                    echo '<td>' . $dato["id_serie"] . '</td>';
                    echo '<td>' . $dato["nombre"] . '</td>';
                    echo '<td>' . $dato["autor"] . '</td>';
                    echo '<td><select>';

                    foreach($productos as $producto) {
                        if ($producto["id_serie"] == $dato["id_serie"]) {
                            echo '<option name="id" value="' . $producto["id_producto"] . '">Tomo ' . $producto["numero"] . '</option>';
                        }
                    }

                    echo '</select>';
                    echo '<a href="index.php?entity=producto&action=show' . $dato['id_producto'] . '" class="btn btn-info mx-1" type="submit">Ver</a>';
                    echo '<a href="index.php?entity=producto&action=insert' . $dato['id_producto'] . '" class="btn btn-info mx-1" type="submit">Agregar</a>';
                    echo '<a href="index.php?entity=producto&action=edit' . $dato['id_producto'] . '" class="btn btn-warning mx-1" type="submit">Modificar</a>';
                    echo '<a href="index.php?entity=producto&action=destroy=' . $dato['id_producto'] . '" class="btn btn-danger mx-1" type="submit">Eliminar</a>';
                    echo '</td>';
                    echo '<td>' . $dato["editorial"] . '</td>';
                    echo '<td>';
                    echo '<a href="index.php?entity=serie&action=show&id=' . $dato['id_serie'] . '" class="btn btn-info mx-1">Ver</a>';
                    echo '<a href="index.php?entity=serie&action=edit&id=' . $dato['id_serie'] . '" class="btn btn-warning mx-1">Modificar</a>';
                    echo '<a href="index.php?entity=serie&action=destroy&id=' . $dato['id_serie'] . '" class="btn btn-danger mx-1">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
    <a href="index.php?entity=serie&action=create" class="btn btn-success">Crear nueva serie</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>