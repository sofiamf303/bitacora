USE nexostock;

-- =========================================
-- CATEGORÍAS
-- =========================================

INSERT INTO categorias (nombre) VALUES
('Granos'),
('Despensa'),
('Bebidas'),
('Aseo'),
('Papelería');

-- =========================================
-- 20 PRODUCTOS
-- =========================================

INSERT INTO productos (nombre, precio, stock, id_categoria) VALUES
('Arroz', 4500, 10, 1),
('Lentejas', 3800, 3, 1),
('Frijoles', 5200, 7, 1),
('Harina', 3200, 12, 1),
('Avena', 4100, 9, 1),

('Aceite', 8900, 4, 2),
('Azúcar', 4200, 15, 2),
('Sal', 2200, 2, 2),
('Pasta', 3000, 11, 2),
('Atún', 6500, 8, 2),

('Café', 12500, 8, 3),
('Chocolate', 6800, 12, 3),
('Gaseosa', 3500, 4, 3),
('Jugo', 4000, 10, 3),

('Jabón', 3200, 20, 4),
('Detergente', 9800, 6, 4),
('Esponja', 1800, 3, 4),
('Cloro', 4500, 7, 4),

('Cuaderno', 5500, 14, 5),
('Lápiz', 1200, 2, 5);

-- =========================================
-- 10 CLIENTES
-- =========================================

INSERT INTO clientes (nombre, email, telefono) VALUES
('Ana Gómez', 'ana.gomez@example.com', '3001112233'),
('Carlos Pérez', 'carlos.perez@example.com', '3002223344'),
('Laura Rodríguez', 'laura.rodriguez@example.com', '3003334455'),
('Juan Martínez', 'juan.martinez@example.com', '3004445566'),
('Sofía Torres', 'sofia.torres@example.com', '3005556677'),
('Daniel López', 'daniel.lopez@example.com', '3006667788'),
('María Sánchez', 'maria.sanchez@example.com', '3007778899'),
('Andrés Ramírez', 'andres.ramirez@example.com', '3008889900'),
('Valentina Castro', 'valentina.castro@example.com', '3009990011'),
('Miguel Herrera', 'miguel.herrera@example.com', '3010001122');

-- =========================================
-- 15 PEDIDOS
-- =========================================

INSERT INTO pedidos (id_cliente, total) VALUES
(1, 9000),
(2, 7600),
(3, 15600),
(4, 8900),
(5, 12500),
(6, 6800),
(7, 7000),
(8, 19600),
(9, 11000),
(10, 4500),
(1, 10400),
(2, 9800),
(3, 6500),
(4, 9000),
(5, 12000);

-- =========================================
-- DETALLE DE LOS PEDIDOS
-- =========================================

INSERT INTO detalle_pedido
(id_pedido, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 2, 4500),
(2, 2, 2, 3800),
(3, 3, 3, 5200),
(4, 6, 1, 8900),
(5, 11, 1, 12500),
(6, 12, 1, 6800),
(7, 13, 2, 3500),
(8, 16, 2, 9800),
(9, 19, 2, 5500),
(10, 20, 3, 1500),
(11, 7, 2, 4200),
(12, 9, 2, 3000),
(13, 10, 1, 6500),
(14, 15, 2, 4500),
(15, 4, 3, 4000);

-- =========================================
-- DETALLE DE LOS PEDIDOS
-- =========================================

INSERT INTO detalle_pedido
(id_pedido, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 2, 4500),
(2, 2, 2, 3800),
(3, 3, 3, 5200),
(4, 6, 1, 8900),
(5, 11, 1, 12500),
(6, 12, 1, 6800),
(7, 13, 2, 3500),
(8, 16, 2, 9800),
(9, 19, 2, 5500),
(10, 20, 3, 1500),
(11, 7, 2, 4200),
(12, 9, 2, 3000),
(13, 10, 1, 6500),
(14, 15, 2, 4500),
(15, 4, 3, 4000);
