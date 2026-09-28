<?php

require_once __DIR__ . '/sesion.php';

/* Vaciar todos los datos de sesión */
$_SESSION = [];

/* Caducar la cookie de sesión */
if (ini_get('session.use_cookies')) {

    $parametros = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $parametros['path'],
        $parametros['domain'],
        $parametros['secure'],
        $parametros['httponly']
    );
}

/* Destruir la sesión */
session_destroy();

/* Volver al ingreso */
header('Location: login.php');
exit;