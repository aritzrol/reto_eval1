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
    <title>Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #27ae60;
        }

        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .serie-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid #e3e6f0;
        }

        .logout {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h1>Gestión de Series</h1>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="index.php?entity=usuario&action=index" class="btn btn-outline-success">Usuarios</a>
                    <a href="index.php?entity=pedido&action=index" class="btn btn-outline-success">Pedidos</a>
                    <a href="index.php?entity=lineaPedido&action=index" class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-cart"></i> Carrito</a>
                </div>
                <div class="logout d-flex gap-2 flex-wrap">
                    <a href="index.php?entity=login&action=logout" class="btn btn-outline-danger">Cerrar sesión</a>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col">
                <?php
                foreach ($data as $dato) {
                    echo '<div class="card mb-4 shadow-sm">';
                    echo '<div class="card-header bg-white py-3">';
                    echo '<div class="serie-header flex-wrap gap-2">';
                    echo '<span>';
                    echo '<strong>' . $dato['nombre'] . '</strong>';
                    echo '</span>';
                    echo '<div>';
                    echo '<a href="index.php?entity=serie&action=show&id=' . $dato["id_serie"] . '" class="btn btn-outline-primary btn-sm me-1" title="Ver Serie">';
                    echo '<i class="bi bi-eye">Ver</i>';
                    echo '</a>';
                    echo '<a href="index.php?entity=serie&action=edit&id=' . $dato["id_serie"] . '" class="btn btn-outline-warning btn-sm" title="Modificar Serie">';
                    echo '<i class="bi bi-pencil">Modificar</i>';
                    echo '</a>';
                    echo '<a href="index.php?entity=serie&action=destroy&id=' . $dato["id_serie"] . '" class="btn btn-outline-danger btn-sm" title="Eliminar Serie" onclick="return confirm(\'¿Seguro que quieres eliminar esta serie?\');">';
                    echo '<i class="bi bi-trash">Eliminar</i>';
                    echo '</a>';
                    echo '</a>';
                    echo '<a href="index.php?entity=producto&action=create&id=' . $dato["id_serie"] . '" class="btn btn-outline-success btn-sm me-1" title="Agregar Producto">';
                    echo '<i class="bi bi-plus">Agregar tomo</i>';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="card-body p-0">';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-hover mb-0 align-middle">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="ps-3" style="width: 50%;">Tomos</th>';
                    echo '<th class="text-end pe-3" style="width: 50%;">Acciones</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($productos as $producto) {
                        if ($producto['id_serie'] == $dato['id_serie']) {
                            echo '<tr>';
                            echo '<td class="ps-3 text-muted">#' . $producto['numero'] . '</td>';
                            echo '<td class="text-end">';
                            echo '<a href="index.php?entity=producto&action=show&id=' . $producto["id_producto"] . '" class="btn btn-outline-primary btn-sm me-1" title="Ver Producto">';
                            echo '<i class="bi bi-eye">Ver</i>';
                            echo '</a>';
                            echo '<a href="index.php?entity=producto&action=edit&id=' . $producto["id_producto"] . '" class="btn btn-outline-warning btn-sm" title="Modificar Producto">';
                            echo '<i class="bi bi-pencil">Modificar</i>';
                            echo '</a>';
                            echo '<a href="index.php?entity=producto&action=destroy&id=' . $producto["id_producto"] . '" class="btn btn-outline-danger btn-sm" title="Eliminar Producto">';
                            echo '<i class="bi bi-trash">Eliminar</i>';
                            echo '</a>';
                            echo '<a href="index.php?entity=lineaPedido&action=store&id=' . $producto["id_producto"] . '" class="btn btn-outline-success btn-sm me-1" title="Agregar Producto">';
                            echo '<i class="bi bi-plus">Añadir al carrito</i>';
                            echo '</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <a href="index.php?entity=serie&action=create" class="btn btn-outline-success btn-sm me-1" title="Agregar Serie">
                <i class="bi bi-plus">Agregar</i>
            </a>
        </div>

</body>

</html>