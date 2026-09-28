CREATE DATABASE IF NOT EXISTS nexostock
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE nexostock;

CREATE TABLE categorias (
    id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE productos (
    id_producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    id_categoria INT UNSIGNED NOT NULL,

    INDEX idx_productos_categoria (id_categoria),

    CONSTRAINT fk_productos_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE clientes (
    id_cliente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(30)
);

CREATE TABLE pedidos (
    id_pedido INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT UNSIGNED NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,

    INDEX idx_pedidos_cliente (id_cliente),

    CONSTRAINT fk_pedidos_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE detalle_pedido (
    id_detalle INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,

    INDEX idx_detalle_pedido (id_pedido),
    INDEX idx_detalle_producto (id_producto),

    CONSTRAINT fk_detalle_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalle_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    rol VARCHAR(30) NOT NULL DEFAULT 'vendedor',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    bloqueado_hasta DATETIME NULL,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE intentos_acceso (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NULL,
    correo VARCHAR(150) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    exitoso TINYINT(1) NOT NULL DEFAULT 0,

    INDEX idx_intentos_correo_fecha (correo, fecha),

    CONSTRAINT fk_intentos_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id)
        ON DELETE SET NULL
);