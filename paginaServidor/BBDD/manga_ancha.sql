DROP DATABASE IF EXISTS manga_ancha;
CREATE DATABASE manga_ancha CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE manga_ancha;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente'
);

-- Relacion 1 a 1 con usuario
CREATE TABLE perfil (
    id_usuario INT PRIMARY KEY,
    apellidos VARCHAR(100),
    telefono VARCHAR(15),
    direccion VARCHAR(200),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE serie (
    id_serie INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    sinopsis TEXT,
    genero VARCHAR(50),
    autor VARCHAR(100),
    editorial VARCHAR(50)
);

CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_serie INT NOT NULL,
    numero INT NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    isbn VARCHAR(13) UNIQUE,
    FOREIGN KEY (id_serie) REFERENCES serie(id_serie) ON DELETE CASCADE
);

CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    precio_total DECIMAL(8,2) NOT NULL,
    estado_pedido ENUM('pendiente', 'pagado', 'enviado', 'cancelado') NOT NULL DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE linea_pedido (
	id_linea_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    id_pedido INT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(6,2) NOT NULL,
    estado_pedido ENUM('carrito', 'pagado') NOT NULL DEFAULT 'carrito',
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido)
);

/*INSERT DE PRUEBA*/
USE manga_ancha;

-- 1. Series (primero, porque producto depende de ellas)
INSERT INTO serie (id_serie, nombre, sinopsis, genero, autor, editorial) VALUES
(1, 'Naruto', 'Un joven ninja sueña con ser el líder de su aldea.', 'Shonen', 'Masashi Kishimoto', 'Planeta Cómic'),
(2, 'One Piece', 'Un chico de goma navega en busca del tesoro definitivo.', 'Aventura', 'Eiichiro Oda', 'Planeta Cómic'),
(3, 'Dragon Ball', 'Las aventuras de Goku buscando las bolas de dragón.', 'Shonen', 'Akira Toriyama', 'Planeta Cómic'),
(4, 'Death Note', 'Un estudiante encuentra un cuaderno que mata a quien se escribe en él.', 'Thriller', 'Tsugumi Ohba', 'Norma Editorial');

-- 2. Productos (10 tomos)
INSERT INTO producto (id_serie, numero, precio, isbn) VALUES
(1, 1, 7.95, '9780000000011'),
(1, 2, 7.95, '9780000000028'),
(1, 3, 7.95, '9780000000035'),
(2, 1, 8.50, '9780000000042'),
(2, 2, 8.50, '9780000000059'),
(2, 3, 8.50, '9780000000066'),
(3, 1, 8.95, '9780000000073'),
(3, 2, 8.95, '9780000000080'),
(4, 1, 9.50, '9780000000097'),
(4, 2, 9.50, '9780000000103');

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `password`, `rol`) VALUES
	(1, 'fernando', 'fer@gmail.com', '$2y$10$A4ah/c9DmJ16HFzjXVMFAukH1wiGOgSSqBrfU8u03tXMnbfIXtwBC', 'cliente'),
	(2, 'aritz', 'aritz@gmail.com', '$2y$10$O4O/LJr0zxQ7zBJkyDP17u0BLVyajPZtpB8clchLonm/PnrhTdMiq', 'admin'),
	(3, 'gaizka', 'gaizka@gmail.com', 'abcd', 'cliente');

INSERT INTO `perfil` (`id_usuario`, `apellidos`, `telefono`, `direccion`) VALUES
	(1, 'Medrano', '123456789', 'donosti'),
	(2, 'Rolando', '987654321', 'bilbao'),
	(3, 'prueba', '654654654', 'prueba');

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `fecha`, `precio_total`, `estado_pedido`) VALUES
	(1, 1, '2026-11-10 09:36:43', 50.00, 'pendiente'),
	(2, 1, '2026-10-15 09:37:04', 60.00, 'pagado'),
	(3, 1, '2026-09-10 09:37:34', 70.00, 'enviado'),
	(4, 3, '2026-05-10 10:12:44', 100.00, 'pendiente');