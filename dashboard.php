<?php

require_once 'guardia.php';

$nombre_usuario = htmlspecialchars(
    $_SESSION['nombre'],
    ENT_QUOTES,
    'UTF-8'
);

$rol_usuario = htmlspecialchars(
    $_SESSION['rol'],
    ENT_QUOTES,
    'UTF-8'
);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NexoStock</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="dashboard">

        <header class="barra-superior">

            <div>
                <h1>NexoStock</h1>
                <p>Panel principal</p>
            </div>

            <p>
                Usuario: <?= $nombre_usuario ?>
                | Rol: <?= $rol_usuario ?>
            </p>

        </header>

        <aside class="menu-lateral">

            <button class="boton-menu" type="button">
                ☰ Menú
            </button>

            <nav aria-label="Menú principal">

                <h2>Menú</h2>

                <ul>
                    <li>
                        <a href="dashboard.php">Inicio</a>
                    </li>

                    <li>
                        <a href="productos.php">Productos</a>
                    </li>

                    <li>
                        <a href="usuarios.php">Usuarios</a>
                    </li>

                    <li>
                        <a href="salir.php">Cerrar sesión</a>
                    </li>
                </ul>

            </nav>

        </aside>

        <main class="contenido">

            <section>

                <h2>Resumen</h2>

                <div class="tarjetas">

                    <article class="tarjeta">
                        <h3>Ventas</h3>
                        <p>$0</p>
                    </article>

                    <article class="tarjeta">
                        <h3>Productos</h3>
                        <p>0</p>
                    </article>

                    <article class="tarjeta">
                        <h3>Stock bajo</h3>
                        <p>0</p>
                    </article>

                    <article class="tarjeta">
                        <h3>Pedidos</h3>
                        <p>0</p>
                    </article>

                </div>

            </section>

            <section class="tabla-resumen">

                <h2>Actividad reciente</h2>

                <table>

                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>Producto ejemplo</td>
                            <td>General</td>
                            <td>20</td>
                        </tr>

                        <tr>
                            <td>Otro producto</td>
                            <td>General</td>
                            <td>10</td>
                        </tr>

                        <tr>
                            <td>Producto 3</td>
                            <td>General</td>
                            <td>8</td>
                        </tr>

                        <tr>
                            <td>Producto 4</td>
                            <td>General</td>
                            <td>15</td>
                        </tr>

                        <tr>
                            <td>Producto 6</td>
                            <td>General</td>
                            <td>12</td>
                        </tr>

                        <tr>
                            <td>Producto 7</td>
                            <td>General</td>
                            <td>12</td>
                        </tr>

                        <tr>
                            <td>Producto 8</td>
                            <td>General</td>
                            <td>12</td>
                        </tr>

                        <tr>
                            <td>Producto 9</td>
                            <td>General</td>
                            <td>12</td>
                        </tr>

                        <tr>
                            <td>Producto 10</td>
                            <td>General</td>
                            <td>12</td>
                        </tr>

                    </tbody>

                </table>

            </section>

        </main>

        <footer class="pie">
            <p>&copy; 2026 NexoStock</p>
        </footer>

    </div>

    <script src="js/menu.js"></script>

</body>

</html>