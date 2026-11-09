# MANGA ANCHA — Reto 1ª evaluación

Tienda online de manga ("Specialized Bookstore") desarrollada como reto de la primera evaluación. El proyecto tiene dos partes:

- **paginaTienda**: la tienda pública (front-end) en HTML, CSS y JavaScript.
- **paginaServidor**: el panel de gestión (back-end) en PHP con patrón MVC y base de datos MySQL.

## Estructura del repositorio

```
reto_eval1/
├── Boceto/            # Bocetos de diseño (página principal, catálogo, card de producto, login)
├── Documentacion/     # Documentación de negocio, perfiles de usuario y control del reto
├── ENUNCIADO/         # Enunciado, anexos y rúbrica del reto
├── paginaTienda/      # Front-end de la tienda
│   ├── index.html     # Inicio
│   ├── catalogue.html # Catálogo
│   ├── cart.html      # Carrito
│   ├── login.html     # Login / registro
│   ├── policy.html    # Políticas
│   ├── store.json     # Datos de prueba (usuarios, pedidos...) para json-server
│   ├── js/            # Lógica de cada página
│   ├── styles/        # Hojas de estilo
│   └── IMG/           # Portadas e iconos
└── paginaServidor/    # Back-end PHP (MVC)
    ├── index.php      # Punto de entrada
    ├── BBDD/          # Script SQL de la base de datos (manga_ancha.sql)
    ├── db/            # Conexión a MySQL
    ├── controller/    # Controladores (Usuario, Producto, Serie, Pedido, LineaPedido, Login)
    ├── model/         # Modelos
    └── view/          # Vistas
```

## Tecnologías

- HTML5, CSS3, JavaScript (vanilla) y Bootstrap 5.3
- [json-server](https://github.com/typicode/json-server) como API simulada para la tienda
- PHP 8 + MySQL/MariaDB (por ejemplo con XAMPP) para el panel de gestión

## Puesta en marcha

### Tienda (paginaTienda)

La tienda consume una API en `http://localhost:3000` (endpoints `/usuarios` y `/pedidos`) servida desde `store.json`.

1. Instala json-server (necesita Node.js):
   ```bash
   npm install -g json-server
   ```
2. Arranca la API desde la carpeta de la tienda:
   ```bash
   cd paginaTienda
   json-server --watch store.json --port 3000
   ```
3. Abre `paginaTienda/index.html` en el navegador (o con una extensión tipo Live Server).

El carrito, el usuario logueado y el modo oscuro se guardan en el `localStorage` del navegador.

### Panel de gestión (paginaServidor)

1. Copia la carpeta `paginaServidor` en el directorio del servidor web (por ejemplo `C:\xampp\htdocs\`).
2. Importa `paginaServidor/BBDD/manga_ancha.sql` en MySQL (por ejemplo desde phpMyAdmin). Crea la base de datos `manga_ancha` con las tablas `usuario`, `perfil`, `serie`, `producto`, `pedido` y `linea_pedido`.
3. Revisa los datos de conexión en `paginaServidor/db/db.php` (por defecto `localhost`, usuario `root`, sin contraseña).
4. Abre `http://localhost/paginaServidor/index.php`.

Las rutas siguen el formato:

```
index.php?entity=<entidad>&action=<acción>&id=<id>
```

- Entidades: `usuario`, `producto`, `serie`, `perfil`, `pedido`, `lineaPedido`, `login`
- Acciones: `index`, `show`, `create`, `store`, `edit`, `update`, `destroy` (y `login` / `logOut` para `login`)

## Ramas

- `main`: rama principal
- `borrador`: rama de trabajo
