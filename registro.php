<?php

session_start();

require_once 'conexion.php';

$mensaje = '';
$registro_exitoso = false;
$nombre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $rol = $_POST['rol'] ?? 'vendedor';

    if (strlen($nombre) < 3) {
        $mensaje = 'El nombre debe tener mínimo 3 caracteres.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Ingresa un correo válido.';
    } elseif (strlen($clave) < 8) {
        $mensaje = 'La contraseña debe tener mínimo 8 caracteres.';
    } elseif (!in_array($rol, ['admin', 'vendedor', 'consultor'], true)) {
        $mensaje = 'El rol seleccionado no es válido.';
    } else {

        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios
                (nombre, correo, clave_hash, rol)
                VALUES (:nombre, :correo, :clave_hash, :rol)";

        try {

            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                'nombre' => $nombre,
                'correo' => $correo,
                'clave_hash' => $clave_hash,
                'rol' => $rol
            ]);

            $mensaje = 'Usuario registrado correctamente.';
            $registro_exitoso = true;
        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {
                $mensaje = 'No fue posible registrar el usuario.';
            } else {
                $mensaje = 'Ocurrió un error al registrar el usuario.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - NexoStock</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header>
        <h1>NexoStock</h1>
        <p>Registro de usuarios</p>
    </header>

    <main class="pagina-productos">

        <section>

            <h2>Crear usuario</h2>

            <?php if ($mensaje !== ''): ?>
                <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <?php if ($registro_exitoso): ?>
                <p>Nombre registrado:</p>
                <p><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form method="post" action="registro.php">

                <p>
                    <label for="nombre">Nombre:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        minlength="3"
                        required>
                </p>

                <p>
                    <label for="correo">Correo:</label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        required>
                </p>

                <p>
                    <label for="clave">Contraseña:</label>
                    <input
                        type="password"
                        id="clave"
                        name="clave"
                        minlength="8"
                        required>
                </p>

                <p>
                    <label for="rol">Rol:</label>

                    <select id="rol" name="rol" required>
                        <option value="vendedor">Vendedor</option>
                        <option value="admin">Administrador</option>
                        <option value="consultor">Consultor</option>
                    </select>
                </p>

                <button type="submit">
                    Registrar usuario
                </button>

            </form>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 NexoStock</p>
    </footer>

</body>

</html>