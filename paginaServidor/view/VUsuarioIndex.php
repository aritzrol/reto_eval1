<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container mt-5">
    <a href="index.php?entity=usuario&action=index" class="btn btn-info">Usuarios</a>
    <a href="index.php?entity=pedido&action=index" class="btn btn-info">Pedidos</a>
    <a href="index.php?entity=serie&action=index" class="btn btn-info">Productos</a>
    <br/>
    <a href="index.php?entity=login&action=logout" class="btn btn-danger">Cerrar sesión</a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Usuarios</h1>

    <table class="table table-striped table-bordered">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Email</th>
                <th scope="col">Telefono</th>
                <th scope="col">Direccion</th>
                <th scope="col">Rol</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($data as $dato) {
                    echo '<tr>';
                    echo '<td>' . $dato["id_usuario"] . '</td>';
                    echo '<td>' . $dato["nombre"] . '</td>';
                    echo '<td>' . $dato["apellidos"] . '</td>';
                    echo '<td>' . $dato["email"] . '</td>';
                    echo '<td>' . $dato["telefono"] . '</td>';
                    echo '<td>' . $dato["direccion"] . '</td>';
                    echo '<td>' . $dato["rol"] . '</td>';
                    echo '<td>';
                    echo '<a href="index.php?entity=usuario&action=show&id=' . $dato['id_usuario'] . '" class="btn btn-info mx-1">Ver</a>';
                    echo '<a href="index.php?entity=usuario&action=edit&id=' . $dato['id_usuario'] . '" class="btn btn-warning mx-1">Modificar</a>';
                    echo '<a href="index.php?entity=usuario&action=destroy&id=' . $dato['id_usuario'] . '" class="btn btn-danger mx-1" onclick="return confirm(\'¿Eliminar este usuario?\');">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
    <a href="index.php?entity=usuario&action=create" class="btn btn-success">Crear nuevo usuario</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>