<?php

session_start();

require_once 'conexion.php';

$mensaje = '';

/* Generar token CSRF */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    /* Validar token CSRF */
    if (
        empty($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)
    ) {
        $mensaje = 'Solicitud no válida.';
    } else {

        /* Validación básica del servidor */
        if (
            !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
            strlen($clave) < 8
        ) {
            $mensaje = 'Credenciales incorrectas.';
        } else {

            /* Buscar usuario */
            $sql = "SELECT
                        id,
                        nombre,
                        correo,
                        clave_hash,
                        rol,
                        activo,
                        bloqueado_hasta
                    FROM usuarios
                    WHERE correo = :correo
                    LIMIT 1";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                'correo' => $correo
            ]);

            $usuario = $stmt->fetch();

            $ahora = new DateTime();

            /* Usuario existe */
            if ($usuario) {

                /* Comprobar si está bloqueado */
                if (
                    $usuario['bloqueado_hasta'] !== null &&
                    new DateTime($usuario['bloqueado_hasta']) > $ahora
                ) {
                    $mensaje = 'Credenciales incorrectas.';
                } else {

                    /* Verificar contraseña */
                    if (password_verify($clave, $usuario['clave_hash'])) {

                        /* Registrar intento exitoso */
                        $sqlIntento = "INSERT INTO intentos_acceso
                                       (id_usuario, correo, exitoso)
                                       VALUES (:id_usuario, :correo, 1)";

                        $stmtIntento = $conexion->prepare($sqlIntento);

                        $stmtIntento->execute([
                            'id_usuario' => $usuario['id'],
                            'correo' => $correo
                        ]);

                        /* Iniciar sesión */
                        session_regenerate_id(true);

                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['nombre'] = $usuario['nombre'];
                        $_SESSION['rol'] = $usuario['rol'];

                        /* Nuevo token después del login */
                        $_SESSION['csrf_token'] =
                            bin2hex(random_bytes(32));

                        header('Location: dashboard.html');
                        exit;

                    } else {

                        /* Registrar intento fallido */
                        $sqlIntento = "INSERT INTO intentos_acceso
                                       (id_usuario, correo, exitoso)
                                       VALUES (:id_usuario, :correo, 0)";

                        $stmtIntento = $conexion->prepare($sqlIntento);

                        $stmtIntento->execute([
                            'id_usuario' => $usuario['id'],
                            'correo' => $correo
                        ]);

                        /* Contar fallos de los últimos 15 minutos */
                        $sqlFallos = "SELECT COUNT(*) AS total
                                      FROM intentos_acceso
                                      WHERE correo = :correo
                                      AND exitoso = 0
                                      AND fecha >= NOW() - INTERVAL 15 MINUTE";

                        $stmtFallos = $conexion->prepare($sqlFallos);

                        $stmtFallos->execute([
                            'correo' => $correo
                        ]);

                        $fallos = (int) $stmtFallos->fetch()['total'];

                        /* Bloquear después de cinco fallos */
                        if ($fallos >= 5) {

                            $bloqueadoHasta =
                                (new DateTime('+15 minutes'))
                                ->format('Y-m-d H:i:s');

                            $sqlBloqueo = "UPDATE usuarios
                                           SET bloqueado_hasta = :bloqueado_hasta
                                           WHERE id = :id";

                            $stmtBloqueo =
                                $conexion->prepare($sqlBloqueo);

                            $stmtBloqueo->execute([
                                'bloqueado_hasta' => $bloqueadoHasta,
                                'id' => $usuario['id']
                            ]);
                        }

                        $mensaje = 'Credenciales incorrectas.';
                    }
                }

            } else {

                /*
                 * Mismo mensaje para evitar revelar
                 * si el correo existe.
                 */
                $mensaje = 'Credenciales incorrectas.';
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
    <title>Iniciar sesión - NexoStock</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header>
        <h1>NexoStock</h1>
        <p>Inicio de sesión</p>
    </header>

    <main class="pagina-productos">

        <section>

            <h2>Iniciar sesión</h2>

            <?php if ($mensaje !== ''): ?>
                <p>
                    <?= htmlspecialchars(
                        $mensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="login.php">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(
                        $_SESSION['csrf_token'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                <p>
                    <label for="correo">Correo:</label>

                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        required
                    >
                </p>

                <p>
                    <label for="clave">Contraseña:</label>

                    <input
                        type="password"
                        id="clave"
                        name="clave"
                        required
                        minlength="8"
                    >
                </p>

                <button type="submit">
                    Iniciar sesión
                </button>

            </form>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 NexoStock</p>
    </footer>

</body>

</html>