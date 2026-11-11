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
    <title>Lista de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container mt-5">
    <a href="index.php?entity=serie&action=index" class="btn btn-info">Volver</a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Carrito de compra</h1>
    
    <table class="table table-striped table-bordered">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tomo</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí va el PHP -->
            <?php //var_dump($data);
                foreach($data as $dato) {
                    echo '<tr>';
                    echo '<td>' . $dato["id_linea_pedido"] . '</td>';
                    echo '<td>' . $dato["nombre"] . '</td>';
                    echo '<td>' . $dato["numero"] . '</td>';
                    echo '<td>' . $dato["cantidad"] . '</td>';
                    echo '<td>' . $dato["precio_unitario"] . '</td>';
                    echo '<td>';
                    echo '<a href="index.php?entity=lineaPedido&action=destroy&id=' . $dato['id_linea_pedido'] . '" class="btn btn-danger mx-1">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="index.php?entity=lineaPedido&action=create" class="btn btn-success">Realizar Pedido</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
