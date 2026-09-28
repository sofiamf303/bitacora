<?php

require_once 'conexion.php';

$busqueda = trim($_GET['buscar'] ?? '');

$sql = "SELECT
            p.id_producto,
            p.nombre,
            c.nombre AS categoria,
            p.precio,
            p.stock
        FROM productos p
        INNER JOIN categorias c
            ON c.id_categoria = p.id_categoria
        WHERE p.nombre LIKE :nombre
           OR c.nombre LIKE :categoria
        ORDER BY p.id_producto";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    'nombre' => '%' . $busqueda . '%',
    'categoria' => '%' . $busqueda . '%'
]);

$productos = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - NexoStock</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header>
        <h1>NexoStock</h1>
        <p>Gestión de productos</p>
    </header>

    <nav aria-label="Navegación principal">
        <ul>
            <li><a href="dashboard.html">Inicio</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="login.html">Cerrar sesión</a></li>
        </ul>
    </nav>

    <main class="pagina-productos">

        <section>
            <h2>Buscar productos</h2>

            <form method="get" action="productos.php">

                <label for="buscador">Buscar:</label>

                <input
                    type="search"
                    id="buscador"
                    name="buscar"
                    value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Buscar por nombre o categoría">

                <button type="submit">Buscar</button>

            </form>
        </section>

        <section>
            <h2>Productos registrados</h2>

            <div class="tabla-resumen">

                <table>

                    <caption>
                        Lista de productos registrados en NexoStock
                    </caption>

                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($productos) > 0): ?>

                            <?php foreach ($productos as $producto): ?>

                                <tr>
                                    <td><?= htmlspecialchars($producto['id_producto'], ENT_QUOTES, 'UTF-8') ?></td>

                                    <td><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>

                                    <td><?= htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8') ?></td>

                                    <td>
                                        $<?= number_format($producto['precio'], 0, ',', '.') ?>
                                    </td>

                                    <td><?= htmlspecialchars($producto['stock'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5">
                                    No se encontraron productos.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>
        </section>

        <section>
            <h2>Registrar producto</h2>

            <form id="formProducto" novalidate>

                <p>
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required>
                </p>

                <p>
                    <label for="nombre">Nombre del producto:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required
                        minlength="3"
                        aria-describedby="errorNombre">
                    <span id="errorNombre" class="mensaje-error"></span>
                </p>

                <p>
                    <label for="categoria">Categoría:</label>

                    <select
                        id="categoria"
                        name="categoria"
                        required
                        aria-describedby="errorCategoria">
                        <option value="">Selecciona una categoría</option>
                        <option value="Granos">Granos</option>
                        <option value="Despensa">Despensa</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Aseo">Aseo</option>
                        <option value="Papelería">Papelería</option>
                    </select>

                    <span id="errorCategoria" class="mensaje-error"></span>
                </p>

                <p>
                    <label for="precio">Precio:</label>

                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        min="0.01"
                        required
                        aria-describedby="errorPrecio">

                    <span id="errorPrecio" class="mensaje-error"></span>
                </p>

                <p>
                    <label for="stock">Cantidad en stock:</label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        step="1"
                        required
                        aria-describedby="errorStock">

                    <span id="errorStock" class="mensaje-error"></span>
                </p>

                <button type="submit">
                    Registrar producto
                </button>

            </form>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 NexoStock</p>
    </footer>

    <script src="js/ejercicios.js"></script>

</body>

</html>