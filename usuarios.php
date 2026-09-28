<?php

require_once 'guardia.php';

if ($_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo '<h1>403 - Acceso prohibido</h1>';
    echo '<p>No tienes permisos para acceder a esta página.</p>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - NexoStock</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header>
        <h1>NexoStock</h1>
        <p>Administración de usuarios</p>
    </header>

    <main class="pagina-productos">

        <section>
            <h2>Usuarios</h2>
            <p>Esta página es exclusiva para administradores.</p>
        </section>

    </main>

</body>

</html>