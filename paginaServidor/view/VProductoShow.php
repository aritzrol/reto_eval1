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
    <?php
    echo '<h1 class="text-center mb-4"></h1>';
    ?>

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
                echo '<td>' . $data["id_producto"] . '</td>';
                echo '<td>' . $data["nombre"] . '</td>';
                echo '<td>' . $data["numero"] . '</td>';
                echo '<td>' . $data["precio"] . '€</td>';
                echo '<td>' . $data["isbn"] . '</td>';
                echo '</tr>';
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>