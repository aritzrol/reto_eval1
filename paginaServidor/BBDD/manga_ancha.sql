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
    FOREIGN KEY (id_serie) REFERENCES serie(id_serie)
);

CREATE TABLE pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    precio_total DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE linea_pedido (
    id_linea_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(6,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);

INSERT INTO usuario (nombre, email, password, rol) VALUES
('Admin', 'admin@mangaancha.test', 'CAMBIAR_POR_HASH', 'admin'),
('Cliente', 'cliente@mangaancha.test', 'CAMBIAR_POR_HASH', 'cliente');

INSERT INTO perfil (id_usuario, apellidos, telefono, direccion) VALUES
(1, 'Administrador', '600000001', 'Calle Ejemplo 1'),
(2, 'Prueba', '600000002', 'Calle Ejemplo 2');

INSERT INTO serie (nombre, sinopsis, genero, autor, editorial) VALUES
('One Piece', 'Un joven pirata busca el tesoro definitivo.', 'Shonen', 'Eiichiro Oda', 'Planeta Comic'),
('Nana', 'Dos mujeres llamadas Nana comparten piso en Tokio.', 'Josei', 'Ai Yazawa', 'Panini');

INSERT INTO producto (id_serie, numero, precio, isbn) VALUES
(1, 1, 8.00, '9788468471525'),
(1, 2, 8.00, '9788468471532'),
(2, 1, 8.50, '9788411011111');

INSERT INTO pedido (id_usuario, precio_total) VALUES (2, 16.50);

INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 1, 8.00),
(1, 3, 1, 8.50);