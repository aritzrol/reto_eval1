<?php
// ============================================================
// VISTA de prueba: CRUD de `producto` (manga_ancha)
// Aquí solo está la parte visual. La lógica la escribes tú.
// La página ya se ve sin tocar nada porque las variables
// de abajo están vacías.
// ============================================================

// ---------- TU CÓDIGO PHP AQUÍ (zona de práctica) ----------

// TODO 1: conexión a la base de datos con PDO

// TODO 2: si la petición es POST, mirar $_POST['accion'] y hacer:
//         'crear'    -> INSERT
//         'editar'   -> UPDATE
//         'eliminar' -> DELETE
//         (usa consultas preparadas)

// TODO 3: si viene ?editar=ID por la URL, cargar esa fila en $enEdicion

// TODO 4: rellenar $series (SELECT de serie) y $productos (SELECT con JOIN)

// ---------- Variables que la vista espera ----------
$mensaje   = '';   // texto de éxito, por ejemplo "Producto creado"
$error     = '';   // texto de error, por ejemplo "ISBN duplicado"
$enEdicion = null; // null = formulario de crear; array = formulario de editar

$series = [];      // cada elemento: ['id_serie' => 1, 'nombre' => 'Naruto']
$productos = [];   // cada elemento: ['id_producto', 'serie', 'numero', 'precio', 'isbn']

// Función para imprimir texto seguro en HTML
function h($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD productos - manga_ancha</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .ok    { background: #e6f4ea; color: #1e6b34; padding: .6rem 1rem; border-radius: 6px; }
        .error { background: #fdeaea; color: #a32020; padding: .6rem 1rem; border-radius: 6px; }
        form.datos { display: grid; grid-template-columns: 120px 1fr; gap: .6rem; align-items: center; margin: 1rem 0 2rem; }
        input, select { padding: .4rem; }
        button, .btn { padding: .4rem .8rem; cursor: pointer; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: .5rem; text-align: left; }
        th { background: #f2f2f2; }
        td.acciones { white-space: nowrap; }
        form.inline { display: inline; }
    </style>
</head>
<body>
    <h1>CRUD de productos</h1>

    <!-- Mensajes -->
    <?php if ($mensaje): ?><p class="ok"><?= h($mensaje) ?></p><?php endif; ?>
    <?php if ($error):   ?><p class="error"><?= h($error) ?></p><?php endif; ?>

    <!-- FORMULARIO: sirve para crear y para editar -->
    <h2><?= $enEdicion ? 'Editar producto #' . h($enEdicion['id_producto']) : 'Nuevo producto' ?></h2>
    <form class="datos" method="post" action="">
        <!-- 'accion' le dice a tu PHP qué operación hacer: crear o editar -->
        <input type="hidden" name="accion" value="<?= $enEdicion ? 'editar' : 'crear' ?>">
        <?php if ($enEdicion): ?>
            <input type="hidden" name="id_producto" value="<?= h($enEdicion['id_producto']) ?>">
        <?php endif; ?>

        <label for="id_serie">Serie</label>
        <select name="id_serie" id="id_serie" required>
            <option value="">-- elige una serie --</option>
            <?php foreach ($series as $s): ?>
                <option value="<?= h($s['id_serie']) ?>"
                    <?= ($enEdicion && $enEdicion['id_serie'] == $s['id_serie']) ? 'selected' : '' ?>>
                    <?= h($s['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="numero">Número</label>
        <input type="number" name="numero" id="numero" min="1" required
               value="<?= h($enEdicion['numero'] ?? '') ?>">

        <label for="precio">Precio (€)</label>
        <input type="number" name="precio" id="precio" min="0" step="0.01" required
               value="<?= h($enEdicion['precio'] ?? '') ?>">

        <label for="isbn">ISBN (13)</label>
        <input type="text" name="isbn" id="isbn" maxlength="13"
               value="<?= h($enEdicion['isbn'] ?? '') ?>">

        <span></span>
        <span>
            <button type="submit"><?= $enEdicion ? 'Guardar cambios' : 'Crear producto' ?></button>
            <?php if ($enEdicion): ?>
                <a class="btn" href="?">Cancelar</a>
            <?php endif; ?>
        </span>
    </form>

    <!-- LISTADO -->
    <h2>Listado (<?= count($data) ?>)</h2>
    <table>
        <tr>
            <th>ID</th><th>Serie</th><th>Nº</th><th>Precio</th><th>ISBN</th><th>Acciones</th>
        </tr>
        <?php foreach ($data as $p): ?>
            <tr>
                <td><?= h($p['id_producto']) ?></td>
                <td><?= h($p['id_serie']) ?></td>
                <td><?= h($p['numero']) ?></td>
                <td><?= h($p['precio']) ?> €</td>
                <td><?= h($p['isbn']) ?></td>
                <td class="acciones">
                    <!-- Editar: manda el id por la URL (GET) -->
                    <a class="btn" href="?editar=<?= h($p['id_producto']) ?>">Editar</a>

                    <!-- Eliminar: manda el id por POST con accion=eliminar -->
                    <form class="inline" method="post" action=""
                          onsubmit="return confirm('¿Eliminar este producto?');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_producto" value="<?= h($p['id_producto']) ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$data): ?>
            <tr><td colspan="6">No hay productos todavía.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
